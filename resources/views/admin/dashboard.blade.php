@extends('layouts.admin')

@section('title', 'Admin Dashboard - Lavender Pharmacy')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1 style="color: #5D3A66;"><i class="fas fa-chart-line"></i> Admin Dashboard</h1>
        <p class="text-muted">Welcome, {{ auth()->user()->name }}! Here's your system overview.</p>
    </div>
</div>

<!-- Key Metrics -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0" style="border-top: 4px solid #B57EDC;">
            <div class="card-body">
                <h6 class="card-title text-muted">Total Revenue</h6>
                <h3 style="color: #B57EDC;">₱{{ number_format($totalRevenue, 2) }}</h3>
                <small class="text-muted">From completed orders</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0" style="border-top: 4px solid #5D3A66;">
            <div class="card-body">
                <h6 class="card-title text-muted">Total Orders</h6>
                <h3 style="color: #5D3A66;">{{ $totalOrders }}</h3>
                <small class="text-muted">All-time orders</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0" style="border-top: 4px solid #C8A2C8;">
            <div class="card-body">
                <h6 class="card-title text-muted">Total Products</h6>
                <h3 style="color: #C8A2C8;">{{ $totalProducts }}</h3>
                <small class="text-muted">In inventory</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0" style="border-top: 4px solid #E6E6FA;">
            <div class="card-body">
                <h6 class="card-title text-muted">Total Users</h6>
                <h3 style="color: #5D3A66;">{{ $totalUsers }}</h3>
                <small class="text-muted">Registered customers</small>
            </div>
        </div>
    </div>
</div>

<!-- Warnings and Alerts -->
<div class="row mb-4">
    <div class="col-md-12">
        @if($lowStockProducts > 0)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> <strong>Attention!</strong> 
                You have <strong>{{ $lowStockProducts }}</strong> product(s) with low stock (less than 10 units).
                <a href="#low-stock" class="alert-link">View details</a>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
</div>

<!-- Recent Orders -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header" style="background-color: #B57EDC; color: white;">
                <h5 class="mb-0"><i class="fas fa-recent"></i> Recent Orders</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td><strong>#{{ str_pad($order->order_id, 6, '0', STR_PAD_LEFT) }}</strong></td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->date_ordered->format('M d, Y H:i') }}</td>
                                <td><strong>₱{{ number_format($order->total_amount, 2) }}</strong></td>
                                <td>{{ ucfirst($order->payment_method) }}</td>
                                <td>
                                    <span class="badge" style="background-color: @if($order->order_status === 'completed') #28a745 @elseif($order->order_status === 'pending') #ffc107 @else #dc3545 @endif">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No recent orders</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">View All Orders</a>
            </div>
        </div>
    </div>
</div>

<!-- Admin Quick Actions -->
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header" style="background-color: #5D3A66; color: white;">
                <h5 class="mb-0"><i class="fas fa-cogs"></i> Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-store"></i> View Shop
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-user"></i> My Profile
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="#" class="btn btn-outline-info w-100">
                            <i class="fas fa-cogs"></i> Settings
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
