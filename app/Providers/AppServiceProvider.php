<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Paginator::defaultView('vendor.pagination.tailwind');
        Paginator::defaultSimpleView('vendor.pagination.simple-tailwind');

        View::composer(['components.storefront-nav', 'components.cart-nav-icon', 'layouts.customer'], function ($view) {
            $cartItemCount = 0;
            if (Auth::check()) {
                $cartItemCount = Cart::where('user_id', Auth::id())->count();
            }
            $view->with('cartItemCount', $cartItemCount);
        });
    }
}
