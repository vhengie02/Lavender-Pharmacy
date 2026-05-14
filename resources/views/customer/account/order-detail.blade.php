@extends('layouts.customer')

@section('title', 'Order #' . $order->order_id . ' - Lavender Pharmacy')

@section('content')
    @include('customer.order-detail-inner', [
        'ordersListUrl' => route('customer.orders.index'),
        'wrapperClass' => 'mx-auto max-w-7xl',
    ])
@endsection
