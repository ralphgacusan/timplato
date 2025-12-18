<?php

use Illuminate\Support\Facades\View;

if (!function_exists('formatCurrency')) {
    function formatCurrency($amount)
    {
        // Get currency from shared view data
        $settings = View::shared('settings') ?? [];
        $currencyCode = $settings['currency'] ?? 'PHP';
        $currency = match ($currencyCode) {
            'PHP' => '₱',
            'USD' => '$',
            'EUR' => '€',
            default => $currencyCode,
        };
        View::share('currency', $currency);
    }
}
