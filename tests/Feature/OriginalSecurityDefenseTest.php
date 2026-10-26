<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Notification;
use App\Models\User;
use App\Services\LoginProtection;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\TestCase;

require_once dirname(__DIR__).'/Support/SecurityTestApplication.php';

class OriginalSecurityDefenseTest extends TestCase
{
    public function createApplication()
    {
        $app = securityTestApplication();
        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
        $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.10']);
        $this->withHeader('Host', 'localhost');
    }

    public function test_account_failures_are_case_insensitive_and_lock_across_ips_for_a_fixed_window(): void
    {
        $protection = $this->app->make(LoginProtection::class);

        for ($attempt = 1; $attempt <= 4; $attempt++) {
            $result = $protection->attempt(
                ' Safe@Example.test ',
                '192.0.2.10',
                static fn () => false,
            );

            $this->assertFalse($result['blocked']);
            $this->assertSame(5 - $attempt, $result['loginProtection']['remaining']);
        }

        $result = $protection->attempt('safe@example.test', '198.51.100.20', static fn () => false);
        $state = $result['loginProtection'];

        $this->assertTrue($result['blocked']);
        $this->assertTrue($state['locked']);
        $this->assertSame('account', $state['reason']);
        $this->assertSame(0, $state['remaining']);
        $this->assertSame(5, $state['max_attempts']);
        $this->assertSame(15, $state['window_minutes']);
        $this->assertGreaterThanOrEqual(899, $state['retry_after']);
        $this->assertLessThanOrEqual(900, $state['retry_after']);

        $lockedUntil = $state['retry_at'];
        $callbackRan = false;
        $blocked = $protection->attempt(' SAFE@EXAMPLE.TEST ', '203.0.113.99', function () use (&$callbackRan) {
            $callbackRan = true;

            return true;
        });

        $this->assertFalse($callbackRan, 'A different IP and email casing must not bypass an account lock.');
        $this->assertTrue($blocked['blocked']);
        $this->assertSame($lockedUntil, $blocked['loginProtection']['retry_at'], 'A blocked request must not extend the lockout.');
        $this->assertSame($lockedUntil, $protection->state('safe@example.test', '203.0.113.99')['retry_at']);

        $this->travel(901)->seconds();
        $afterExpiry = $protection->attempt('safe@example.test', '203.0.113.99', static fn () => true);
        $this->assertTrue($afterExpiry['success'], 'A fresh login attempt is allowed after the 15-minute lockout expires.');
    }

    public function test_ip_bucket_locks_after_twenty_failures_across_distinct_identities(): void
    {
        $protection = $this->app->make(LoginProtection::class);

        for ($attempt = 1; $attempt <= 20; $attempt++) {
            $result = $protection->attempt(
                "account{$attempt}@example.test",
                '192.0.2.25',
                static fn () => false,
            );
        }

        $state = $result['loginProtection'];
        $this->assertTrue($result['blocked']);
        $this->assertTrue($state['locked']);
        $this->assertSame('ip', $state['reason']);
        $this->assertSame(20, $state['max_attempts']);
        $this->assertSame(0, $state['remaining']);

        $callbackRan = false;
        $next = $protection->attempt('another@example.test', '192.0.2.25', function () use (&$callbackRan) {
            $callbackRan = true;

            return false;
        });

        $this->assertFalse($callbackRan);
        $this->assertTrue($next['blocked']);
    }

    public function test_account_and_ip_lock_state_reports_the_later_expiry_when_both_are_locked(): void
    {
        $protection = $this->app->make(LoginProtection::class);
        $this->travelTo(now()->startOfSecond());
        $startedAt = now()->timestamp;

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $protection->attempt('long-lock@example.test', '192.0.2.26', static fn () => false);
        }

        $this->travel(600)->seconds();
        for ($attempt = 1; $attempt <= 15; $attempt++) {
            $result = $protection->attempt("ip-identity-{$attempt}@example.test", '192.0.2.26', static fn () => false);
        }

        $state = $protection->state('long-lock@example.test', '192.0.2.26');
        $this->assertTrue($result['blocked']);
        $this->assertTrue($state['locked']);
        $this->assertSame('ip', $state['reason']);
        $this->assertSame(20, $state['max_attempts']);
        $this->assertSame(gmdate(DATE_ATOM, $startedAt + 1500), $state['retry_at']);
    }

    public function test_failures_expire_individually_at_the_rolling_window_boundary(): void
    {
        $protection = $this->app->make(LoginProtection::class);
        $this->travelTo(now()->startOfSecond());

        $protection->attempt('rolling@example.test', '192.0.2.27', static fn () => false);
        $this->travel(600)->seconds();
        $protection->attempt('rolling@example.test', '192.0.2.27', static fn () => false);
        $this->assertSame(2, $protection->state('rolling@example.test', '192.0.2.27')['attempts']);

        $this->travel(301)->seconds();
        $state = $protection->state('rolling@example.test', '192.0.2.27');
        $this->assertFalse($state['locked']);
        $this->assertSame(1, $state['attempts'], 'The failure older than 900 seconds should expire while the newer one remains.');
        $this->assertSame(4, $state['remaining']);
    }

    public function test_success_clears_only_the_account_failures_and_preserves_other_ip_failures(): void
    {
        $protection = $this->app->make(LoginProtection::class);

        $protection->attempt('account@example.test', '192.0.2.30', static fn () => false);
        $protection->attempt('ACCOUNT@example.test', '192.0.2.30', static fn () => false);
        $protection->attempt('different@example.test', '192.0.2.30', static fn () => false);

        $success = $protection->attempt(' account@example.test ', '198.51.100.30', static fn () => true);

        $this->assertTrue($success['success']);
        $this->assertSame(0, $protection->state('account@example.test', '192.0.2.30')['attempts']);
        $this->assertSame(5, $protection->state('account@example.test', '192.0.2.30')['remaining']);

        for ($failure = 1; $failure <= 16; $failure++) {
            $protection->attempt("other-{$failure}@example.test", '192.0.2.30', static fn () => false);
        }
        $finalFailure = $protection->attempt('other-17@example.test', '192.0.2.30', static fn () => false);
        $this->assertTrue($finalFailure['blocked'], 'Earlier failures from this IP must survive a successful login for another IP.');
        $this->assertSame('ip', $finalFailure['loginProtection']['reason']);
    }

    public function test_signin_returns_four_retryable_errors_then_a_429_and_refresh_reads_persistent_state(): void
    {
        $credentials = ['email' => 'safe@example.test', 'password' => 'wrong-password'];

        $this->get('/signin')
            ->assertOk()
            ->assertSee('data-max-attempts="5"', false)
            ->assertSee('5 of 5 attempts remaining.');

        for ($attempt = 0; $attempt < 4; $attempt++) {
            $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.40']);
            $this->from('/signin')->post('/signin', $credentials)
                ->assertRedirect('/signin')
                ->assertSessionHasErrors('email')
                ->assertSessionHas('_old_input.email', 'safe@example.test')
                ->assertSessionMissing('_old_input.password');
        }

        $this->get('/signin')
            ->assertOk()
            ->assertSee('data-locked="false"', false)
            ->assertSee('1 of 5 attempts remaining.');

        $this->withServerVariables(['REMOTE_ADDR' => '192.0.2.40']);
        $lockedResponse = $this->from('/signin')->post('/signin', $credentials)
            ->assertStatus(429)
            ->assertHeader('Retry-After')
            ->assertSee('signin-lockout-dialog')
            ->assertSee('data-locked="true"', false)
            ->assertSee('data-max-attempts="5"', false);

        $retryAt = $this->attributeValue($lockedResponse->getContent(), 'data-retry-at');
        $this->assertNotNull($retryAt);

        // A new session hint and page refresh cannot reset the shared account state.
        $this->withSession(['login_email' => 'safe@example.test', 'loginProtection' => ['locked' => false]])
            ->get('/signin')
            ->assertOk()
            ->assertSee('signin-lockout-dialog')
            ->assertSee('data-locked="true"', false)
            ->assertSee('data-retry-at="'.$retryAt.'"', false);

        $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.40']);
        DB::enableQueryLog();
        try {
            $valid = $this->post('/signin', [
                'email' => 'safe@example.test',
                'password' => 'LabPassword123!',
            ])->assertStatus(429);
            $queries = DB::getQueryLog();
        } finally {
            DB::disableQueryLog();
        }

        $this->assertSame('safe@example.test', session('login_email'));
        $this->assertSame([], array_values(array_filter(
            $queries,
            static fn (array $query) => str_contains(strtolower($query['query']), ' from "users"')
                || str_contains(strtolower($query['query']), ' from `users`')
        )), 'A locked valid-credential request must be rejected before the users table is queried.');
        $this->assertSame('0', $valid->headers->get('X-RateLimit-Remaining'));
    }

    public function test_short_malformed_and_missing_signin_fields_consume_the_ip_budget(): void
    {
        $lastResponse = null;
        for ($attempt = 1; $attempt <= 20; $attempt++) {
            $payload = match ($attempt % 3) {
                0 => [],
                1 => ['email' => "bad-email-{$attempt}", 'password' => 'x'],
                default => ['email' => "also-bad-{$attempt}", 'password' => ''],
            };

            $lastResponse = $this->from('/signin')->post('/signin', $payload);
            if ($attempt < 20) {
                $lastResponse->assertRedirect('/signin');
            }
        }

        $lastResponse->assertStatus(429)->assertHeader('Retry-After');
        $state = $this->app->make(LoginProtection::class)->state(null, '192.0.2.10');
        $this->assertTrue($state['locked']);
        $this->assertSame('ip', $state['reason']);
        $this->assertSame(0, $state['remaining']);
        $this->assertSame(20, $state['max_attempts']);
    }

    public function test_signup_forces_user_role_and_rotates_the_guest_session(): void
    {
        $this->get('/signup')->assertOk();
        $oldSessionId = $this->app['session']->getId();
        $payload = [
            'first_name' => 'New',
            'last_name' => 'Customer',
            'email' => 'new-customer@example.test',
            'phone' => '09123456789',
            'gender' => 'prefer_not_to_say',
            'date_of_birth' => '2000-01-01',
            'password' => 'LongEnoughPass123!',
            'password_confirmation' => 'LongEnoughPass123!',
            'role' => 'admin',
        ];

        // The signup security assertion does not depend on external DNS availability.
        $validator = Mockery::mock();
        $validator->shouldReceive('fails')->once()->andReturnFalse();
        $validator->shouldReceive('validated')->once()->andReturn($payload);
        Validator::shouldReceive('make')->once()->andReturn($validator);

        $this->from('/signup')->post('/signup', $payload)->assertRedirect('/');

        $user = User::where('email', $payload['email'])->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertSame('user', $user->role);
        $this->assertDatabaseCount('users', 2);
        $this->assertNotSame($oldSessionId, $this->app['session']->getId());
    }

    public function test_signup_rejects_short_password_without_flashing_it_and_legacy_shorter_passwords_still_work(): void
    {
        $this->from('/signup')->post('/signup', [
            'first_name' => 'Short',
            'last_name' => 'Password',
            'email' => 'short-password@example.test',
            'phone' => '09123456789',
            'gender' => 'prefer_not_to_say',
            'date_of_birth' => '2000-01-01',
            'password' => 'LegacyPass123!',
            'password_confirmation' => 'LegacyPass123!',
            'role' => 'user',
        ])->assertRedirect('/signup')->assertSessionHasErrors('password');

        $this->assertNull(session('_old_input.password'));
        $this->assertDatabaseMissing('users', ['email' => 'short-password@example.test']);

        $legacyUser = User::create([
            'first_name' => 'Legacy',
            'last_name' => 'Customer',
            'email' => 'legacy@example.test',
            'password' => 'LegacyPass123!',
            'role' => 'user',
        ]);

        $this->from('/signin')->post('/signin', [
            'email' => $legacyUser->email,
            'password' => 'LegacyPass123!',
        ])->assertRedirect('/');

        $this->assertAuthenticatedAs($legacyUser);
    }

    public function test_google_callback_rotates_the_guest_session(): void
    {
        $this->withSession(['guest-marker' => 'before-oauth']);
        $oldSessionId = $this->app['session']->getId();
        $googleUser = new class
        {
            public array $user = ['given_name' => 'OAuth', 'family_name' => 'Customer'];

            public function getEmail(): string
            {
                return 'oauth-customer@example.test';
            }

            public function getName(): string
            {
                return 'OAuth Customer';
            }
        };
        $provider = Mockery::mock();
        $provider->shouldReceive('user')->once()->andReturn($googleUser);
        Socialite::shouldReceive('driver')->once()->with('google')->andReturn($provider);

        $this->get('/auth/google/callback')->assertRedirect('/');

        $user = User::where('email', 'oauth-customer@example.test')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertNotSame($oldSessionId, $this->app['session']->getId());
    }

    public function test_suspended_account_cannot_sign_in_with_valid_credentials(): void
    {
        $user = User::firstOrFail();
        $user->update(['suspended_until' => now()->addHour()]);

        $this->from('/signin')->post('/signin', [
            'email' => $user->email,
            'password' => 'LabPassword123!',
        ])->assertRedirect('/signin')->assertSessionHasErrors('email');

        $this->assertGuest();
        $this->assertTrue($user->fresh()->suspended_until->isFuture());
    }

    public function test_cache_lock_contention_returns_a_retryable_busy_result_without_counting_a_failure(): void
    {
        $email = 'busy@example.test';
        $accountLock = Cache::lock('login-protection:lock:account:'.hash('sha256', $email), 30);
        $this->assertTrue($accountLock->get());
        $callbackRan = false;

        try {
            $result = $this->app->make(LoginProtection::class)->attempt($email, '192.0.2.28', function () use (&$callbackRan) {
                $callbackRan = true;

                return false;
            });
        } finally {
            $accountLock->release();
        }

        $this->assertFalse($callbackRan);
        $this->assertTrue($result['blocked']);
        $this->assertSame('busy', $result['loginProtection']['reason']);
        $this->assertSame(1, $result['loginProtection']['retry_after']);
        $this->assertFalse($this->app->make(LoginProtection::class)->state($email, '192.0.2.28')['locked']);
    }

    public function test_signin_uses_bound_email_queries_and_does_not_execute_password_sql_injection(): void
    {
        $payload = "' OR '1'='1' -- ";
        DB::enableQueryLog();
        try {
            $this->from('/signin')->post('/signin', [
                'email' => 'safe@example.test',
                'password' => $payload,
            ])->assertRedirect('/signin')->assertSessionHasErrors('email');
            $queries = DB::getQueryLog();
        } finally {
            DB::disableQueryLog();
        }

        $this->assertGuest();
        $this->assertDatabaseCount('users', 1);
        $userQueries = array_values(array_filter(
            $queries,
            static fn (array $query) => str_contains(strtolower($query['query']), ' from "users"')
                || str_contains(strtolower($query['query']), ' from `users`')
        ));
        $this->assertNotEmpty($userQueries);
        $this->assertStringContainsString('?', $userQueries[0]['query']);
        $this->assertContains('safe@example.test', $userQueries[0]['bindings']);
        $this->assertStringNotContainsString($payload, $userQueries[0]['query']);
    }

    public function test_review_input_is_validated_and_rendered_as_escaped_text(): void
    {
        $user = User::firstOrFail();
        $this->actingAs($user);

        foreach ([
            ['rating' => 0, 'comment' => 'Invalid low rating'],
            ['rating' => 6, 'comment' => 'Invalid high rating'],
            ['rating' => 3, 'comment' => str_repeat('x', 1001)],
        ] as $payload) {
            $this->from('/product/1')->post('/products/1/reviews', $payload)
                ->assertRedirect('/product/1')->assertSessionHasErrors();
        }

        $this->assertDatabaseCount('reviews', 0);
        $this->post('/products/999/reviews', ['rating' => 5, 'comment' => 'Missing product'])
            ->assertNotFound();

        $payload = '<img src=x onerror="alert(1)">';
        $this->post('/products/1/reviews', ['rating' => 5, 'comment' => $payload])
            ->assertRedirect('/product/1');
        $this->assertDatabaseHas('reviews', ['comment' => $payload, 'rating' => 5]);

        $page = $this->get('/product/1')->assertOk();
        $page->assertSee(e($payload), false)->assertDontSee($payload, false);
    }

    public function test_customer_notification_messages_are_rendered_as_escaped_text(): void
    {
        $user = User::firstOrFail();
        $payload = '<b>Order updated</b><img src=x onerror="alert(1)">';

        // The disposable fixture omits the production orders table, which this table references.
        Schema::create('orders', function ($table): void {
            $table->id('order_id');
        });

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Security test notification',
            'message' => $payload,
        ]);

        $this->actingAs($user);
        $page = $this->get('/product/1')->assertOk();

        $this->assertDatabaseHas('notifications', ['message' => $payload]);
        $visibleText = e(str_ireplace(['<b>', '</b>'], '', $payload));
        $page->assertSee($visibleText, false)->assertDontSee($payload, false);
    }

    public function test_successful_signin_merges_the_guest_cart_from_the_pre_auth_session_id(): void
    {
        $cartResponse = $this->post('/add-to-cart/1', ['quantity' => 2])->assertRedirect();
        $guestCart = Cart::whereNotNull('session_id')->firstOrFail();
        $this->assertSame($this->app['session']->getId(), $guestCart->session_id);
        $sessionCookie = $cartResponse->getCookie(config('session.cookie'));
        $this->assertNotNull($sessionCookie);
        $this->withCookie(config('session.cookie'), $sessionCookie->getValue());

        $this->from('/signin')->post('/signin', [
            'email' => 'safe@example.test',
            'password' => 'LabPassword123!',
        ])->assertRedirect('/');

        $user = User::where('email', 'safe@example.test')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $userCart = Cart::where('user_id', $user->id)->firstOrFail();
        $this->assertSame(2, (int) CartItem::where('cart_id', $userCart->cart_id)->value('quantity'));
        $this->assertDatabaseMissing('carts', ['cart_id' => $guestCart->cart_id]);
    }

    private function attributeValue(string $html, string $attribute): ?string
    {
        $quoted = preg_quote($attribute, '/');
        if (! preg_match('/'.$quoted.'="([^"]*)"/', $html, $matches)) {
            return null;
        }

        return html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5);
    }
}
