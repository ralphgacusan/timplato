<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Setting; 

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   public function boot(): void
{
    // === Global settings ===
    $settings = Setting::pluck('value', 'key')->toArray();

    // Convert currency code to symbol
    $currencyCode = $settings['currency'] ?? 'PHP';
    $currencySymbol = match ($currencyCode) {
        'PHP' => '₱',
        'USD' => '$',
        'EUR' => '€',
        default => $currencyCode,
    };

    // Share both settings and symbol with all views
    View::share('settings', $settings);
    View::share('currency', $currencySymbol);

    // Notifications composer
    View::composer('components.customer-layout', function ($view) {
        if (Auth::check()) {
            $user = Auth::user();
            $notifications = Notification::with(['order.items.product.primaryImage', 'product'])
                ->where('user_id', $user->id)
                ->orWhereNull('user_id') // general notifications
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            $view->with('notifications', $notifications);
        } else {
            $view->with('notifications', collect());
        }
    });
}

}
