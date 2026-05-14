<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPortalController extends Controller
{
    public function profile(Request $request)
    {
        return view('customer.account.profile', ['user' => $request->user()]);
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())->latest('date_ordered')->paginate(10);

        return view('customer.account.orders', ['orders' => $orders]);
    }

    public function orderShow(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('items.product', 'receipt');

        return view('customer.account.order-detail', ['order' => $order]);
    }

    public function wishlist()
    {
        return view('customer.account.wishlist');
    }

    public function addresses()
    {
        return view('customer.account.addresses', ['user' => Auth::user()]);
    }

    public function payment()
    {
        return view('customer.account.payment');
    }

    public function settings()
    {
        return view('customer.account.settings', ['user' => Auth::user()]);
    }
}
