<?php

namespace App\Policies;

use App\Models\Receipt;
use App\Models\User;

class ReceiptPolicy
{
    /**
     * Determine if the user can view the receipt
     */
    public function view(User $user, Receipt $receipt): bool
    {
        return $user->user_id === $receipt->order->user_id || $user->role === 'admin';
    }

    /**
     * Determine if the user can download the receipt
     */
    public function download(User $user, Receipt $receipt): bool
    {
        return $user->user_id === $receipt->order->user_id || $user->role === 'admin';
    }

    /**
     * Determine if the user can delete the receipt
     */
    public function delete(User $user, Receipt $receipt): bool
    {
        return $user->role === 'admin';
    }
}
