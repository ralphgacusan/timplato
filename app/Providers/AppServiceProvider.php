<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

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
        View::composer('components.customer-layout', function ($view) {
        if (Auth::check()) {
            $user = Auth::user();

            $notifications = Notification::with(['order.items.product.primaryImage', 'product'])
                ->where('user_id', $user->id)
                ->orWhereNull('user_id') // general notifications
                ->orderBy('created_at', 'desc')
                ->take(5) // limit to latest 5
                ->get();

            $view->with('notifications', $notifications);
        } else {
            $view->with('notifications', collect()); // empty for guests
        }
    });
    }
}
