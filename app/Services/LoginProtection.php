<?php

namespace App\Services;

use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\Cache;

class LoginProtection
{
    private const LOCK_WAIT_SECONDS = 2;

    private const LOCK_TTL_SECONDS = 30;

    public function attempt(mixed $email, mixed $ip, callable $authenticate): array
    {
        $email = $this->normalizeEmail($email);
        $ip = $this->normalizeIp($ip);

        $accountKey = $email === null ? null : $this->accountKey($email);
        $ipKey = $this->ipKey($ip);

        try {
            $run = fn () => Cache::lock($this->lockKey('ip', $ip), self::LOCK_TTL_SECONDS)
                ->block(self::LOCK_WAIT_SECONDS, function () use ($accountKey, $ipKey, $email, $ip, $authenticate) {
                    $account = $accountKey === null ? null : $this->loadBucket($accountKey, 'account');
                    $ipBucket = $this->loadBucket($ipKey, 'ip');

                    if ($account !== null && $account['locked_until'] > $this->nowTimestamp()) {
                        return $this->result(false, true, $this->buildState($email, $ip, $account, $ipBucket));
                    }

                    if ($ipBucket['locked_until'] > $this->nowTimestamp()) {
                        return $this->result(false, true, $this->buildState($email, $ip, $account, $ipBucket));
                    }

                    $succeeded = (bool) $authenticate();

                    if ($succeeded) {
                        if ($accountKey !== null) {
                            Cache::forget($accountKey);
                        }

                        return $this->result(true, false, $this->buildState($email, $ip));
                    }

                    if ($accountKey !== null) {
                        $account = $this->recordFailure($accountKey, 'account', $account);
                    }

                    $ipBucket = $this->recordFailure($ipKey, 'ip', $ipBucket);

                    return $this->result(false, $this->isLocked($account) || $this->isLocked($ipBucket), $this->buildState($email, $ip, $account, $ipBucket));
                });

            if ($accountKey === null) {
                return $run();
            }

            return Cache::lock($this->lockKey('account', $email), self::LOCK_TTL_SECONDS)
                ->block(self::LOCK_WAIT_SECONDS, $run);
        } catch (LockTimeoutException) {
            $retryAt = $this->nowTimestamp() + 1;

            return $this->result(false, true, [
                'locked' => true,
                'remaining' => 0,
                'retry_after' => 1,
                'retry_at' => gmdate(DATE_ATOM, $retryAt),
                'reason' => 'busy',
                'max_attempts' => config('auth.login.max_attempts', 5),
                'window_minutes' => (int) ceil(config('auth.login.window_seconds', 900) / 60),
                'attempts' => 0,
            ]);
        }
    }

    public function state(mixed $email, mixed $ip): array
    {
        $email = $this->normalizeEmail($email);
        $ip = $this->normalizeIp($ip);

        $account = $email === null ? null : $this->readBucket($this->accountKey($email), 'account');
        $ipBucket = $this->readBucket($this->ipKey($ip), 'ip');

        return $this->buildState($email, $ip, $account, $ipBucket);
    }

    private function buildState(?string $email, string $ip, ?array $account = null, ?array $ipBucket = null): array
    {
        $account ??= $email === null ? $this->emptyBucket() : $this->readBucket($this->accountKey($email), 'account');
        $ipBucket ??= $this->readBucket($this->ipKey($ip), 'ip');

        $accountLocked = $this->isLocked($account);
        $ipLocked = $this->isLocked($ipBucket);

        if ($accountLocked && $ipLocked) {
            $reason = $account['locked_until'] >= $ipBucket['locked_until'] ? 'account' : 'ip';
            $bucket = $reason === 'account' ? $account : $ipBucket;
        } elseif ($accountLocked) {
            $reason = 'account';
            $bucket = $account;
        } elseif ($ipLocked) {
            $reason = 'ip';
            $bucket = $ipBucket;
        } else {
            $reason = 'account';
            $bucket = $account;
        }

        $lockedUntil = $accountLocked || $ipLocked ? $bucket['locked_until'] : null;
        $limit = $this->limit($reason);
        $attempts = count($bucket['failures'] ?? []);
        $retryAfter = $lockedUntil === null ? 0 : max(1, $lockedUntil - $this->nowTimestamp());

        $remaining = $lockedUntil === null
            ? min(
                max(0, $this->limit('account') - count($account['failures'] ?? [])),
                max(0, $this->limit('ip') - count($ipBucket['failures'] ?? []))
            )
            : 0;

        return [
            'locked' => $lockedUntil !== null,
            'remaining' => $remaining,
            'retry_after' => $retryAfter,
            'retry_at' => $lockedUntil === null ? null : gmdate(DATE_ATOM, $lockedUntil),
            'reason' => $reason,
            'max_attempts' => $limit,
            'window_minutes' => (int) ceil($this->windowSeconds() / 60),
            'attempts' => $attempts,
        ];
    }

    private function result(bool $succeeded, bool $blocked, array $state): array
    {
        return [
            'success' => $succeeded,
            'blocked' => $blocked,
            'loginProtection' => $state,
        ];
    }

    private function loadBucket(string $key, string $type): array
    {
        $bucket = $this->readBucket($key, $type);

        if ($bucket['locked_until'] !== null && $bucket['locked_until'] <= $this->nowTimestamp()) {
            Cache::forget($key);

            return $this->emptyBucket();
        }

        if ($bucket['locked_until'] === null && count($bucket['failures']) === 0) {
            Cache::forget($key);
        }

        return $bucket;
    }

    private function readBucket(string $key, string $type): array
    {
        $stored = Cache::get($key);
        if (! is_array($stored)) {
            return $this->emptyBucket();
        }

        $now = $this->nowTimestamp();
        $lockedUntil = is_numeric($stored['locked_until'] ?? null) ? (int) $stored['locked_until'] : null;

        if ($lockedUntil !== null) {
            if ($lockedUntil <= $now) {
                return $this->emptyBucket();
            }

            return [
                'failures' => is_array($stored['failures'] ?? null) ? $stored['failures'] : [],
                'locked_until' => $lockedUntil,
            ];
        }

        $cutoff = $now - $this->windowSeconds();
        $failures = array_values(array_filter(
            is_array($stored['failures'] ?? null) ? $stored['failures'] : [],
            fn ($timestamp) => is_numeric($timestamp) && (int) $timestamp > $cutoff
        ));

        return ['failures' => $failures, 'locked_until' => null];
    }

    private function recordFailure(string $key, string $type, array $bucket): array
    {
        $now = $this->nowTimestamp();
        $bucket['failures'][] = $now;

        if (count($bucket['failures']) >= $this->limit($type)) {
            $bucket['locked_until'] = $now + $this->lockoutSeconds();
            Cache::put($key, $bucket, $this->lockoutSeconds());

            return $bucket;
        }

        $bucket['locked_until'] = null;
        Cache::put($key, $bucket, $this->windowSeconds());

        return $bucket;
    }

    private function emptyBucket(): array
    {
        return ['failures' => [], 'locked_until' => null];
    }

    private function isLocked(?array $bucket): bool
    {
        return $bucket !== null && $bucket['locked_until'] !== null && $bucket['locked_until'] > $this->nowTimestamp();
    }

    private function accountKey(string $email): string
    {
        return 'login-protection:account:'.hash('sha256', $email);
    }

    private function ipKey(string $ip): string
    {
        return 'login-protection:ip:'.hash('sha256', $ip);
    }

    private function lockKey(string $type, string $value): string
    {
        return 'login-protection:lock:'.$type.':'.hash('sha256', $value);
    }

    private function normalizeEmail(mixed $email): ?string
    {
        if (! is_string($email)) {
            return null;
        }

        $email = strtolower(trim($email));

        return $email === '' ? null : $email;
    }

    private function normalizeIp(mixed $ip): string
    {
        if (! is_string($ip) || trim($ip) === '') {
            return 'unknown';
        }

        return strtolower(trim($ip));
    }

    private function limit(string $type): int
    {
        $key = $type === 'account' ? 'auth.login.max_attempts' : 'auth.login.ip_max_attempts';

        return max(1, (int) config($key, $type === 'account' ? 5 : 20));
    }

    private function windowSeconds(): int
    {
        return max(1, (int) config('auth.login.window_seconds', 900));
    }

    private function lockoutSeconds(): int
    {
        return max(1, (int) config('auth.login.lockout_seconds', 900));
    }

    private function nowTimestamp(): int
    {
        return now()->timestamp;
    }
}
