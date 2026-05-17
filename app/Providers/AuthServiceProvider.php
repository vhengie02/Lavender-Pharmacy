<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Receipt;
use App\Policies\CartPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ReceiptPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Cart::class => CartPolicy::class,
        Order::class => OrderPolicy::class,
        Receipt::class => ReceiptPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
