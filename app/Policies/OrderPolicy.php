<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine if the user can view the order
     */
    public function view(User $user, Order $order): bool
    {
        return $user->user_id === $order->user_id || $user->role === 'admin';
    }

    /**
     * Determine if the user can create an order
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can update the order
     */
    public function update(User $user, Order $order): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can delete the order
     */
    public function delete(User $user, Order $order): bool
    {
        return $user->role === 'admin';
    }
}
