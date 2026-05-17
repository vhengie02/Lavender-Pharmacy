@extends('layouts.admin')

@section('title', 'Admin Dashboard - Lavender Pharmacy')

@section('content')
<style>
    .dashboard-main {
        width: 100%;
        min-height: 100vh;
        background: #F7F3FC;
    }

    .dashboard-container {
        padding: 32px 40px;
        max-width: 1400px;
        margin: 0 auto;
    }

    @media (max-width: 768px) {
        .dashboard-container { padding: 24px 16px; }
    }

    /* ── Header ── */
    .dashboard-header {
        margin-bottom: 28px;
        background: linear-gradient(135deg, #5D3A66 0%, #8B4DAB 60%, #B57EDC 100%);
        padding: 28px 32px;
        border-radius: 14px;
        box-shadow: 0 4px 20px rgba(93, 58, 102, 0.25);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        pointer-events: none;
    }

    .dashboard-header::after {
        content: '';
        position: absolute;
        bottom: -60px;
        right: 80px;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
        pointer-events: none;
    }

    .dashboard-header h1 {
        font-size: 1.9rem;
        font-weight: 700;
        margin-bottom: 6px;
        color: white;
    }

    .dashboard-header p {
        color: rgba(255,255,255,0.75);
        font-size: 0.9rem;
        margin: 0;
    }

    .dashboard-header i.header-icon {
        margin-right: 10px;
        opacity: 0.85;
    }

    /* ── Metric cards ── */
    .metric-card {
        background: white;
        border: none;
        border-radius: 12px;
        padding: 22px 24px;
        box-shadow: 0 2px 12px rgba(93, 58, 102, 0.07);
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .metric-card::after {
        content: '';
        position: absolute;
        bottom: -20px;
        right: -20px;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: var(--metric-color, #B57EDC);
        opacity: 0.06;
        transition: opacity 0.25s ease;
        pointer-events: none;
    }

    .metric-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--metric-color, #B57EDC);
        border-radius: 12px 12px 0 0;
    }

    .metric-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(93, 58, 102, 0.14);
    }

    .metric-card:hover::after { opacity: 0.1; }

    .metric-card--1 { --metric-color: #B57EDC; }
    .metric-card--2 { --metric-color: #5D3A66; }
    .metric-card--3 { --metric-color: #C8A2C8; }
    .metric-card--4 { --metric-color: #8B4DAB; }

    .metric-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--metric-color);
        opacity: 0.12;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
        position: relative;
    }

    .metric-icon i {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: var(--metric-color);
        opacity: 1;
    }

    .metric-card .card-title {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #A090B0;
        margin-bottom: 8px;
    }

    .metric-card h3 {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 4px;
        color: var(--metric-color);
        line-height: 1;
    }

    .metric-card small {
        color: #B0A0BC;
        font-size: 0.78rem;
    }

    /* ── Alert ── */
    .alert-custom {
        border: none;
        border-radius: 10px;
        border-left: 4px solid #f59e0b;
        background: #fffbeb;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        color: #78350f;
    }

    /* ── Orders card ── */
    .card-modern {
        background: white;
        border: none;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(93, 58, 102, 0.07);
        overflow: hidden;
    }

    .card-modern-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid #F0E8FA;
    }

    .card-modern-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card-modern-header-icon {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #8B4DAB, #C8A2C8);
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-modern-header-icon i {
        color: white;
        font-size: 0.9rem;
    }

    .card-modern-header h5 {
        font-size: 1rem;
        font-weight: 700;
        color: #3D2549;
        margin: 0;
    }

    .card-modern-header .order-count-badge {
        background: #F0E8FA;
        color: #7A4F85;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 20px;
    }

    /* ── Table ── */
    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .orders-table thead tr {
        background: #FDFAFF;
    }

    .orders-table th {
        padding: 11px 16px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #9B7BAB;
        border-bottom: 1px solid #F0E8FA;
        white-space: nowrap;
    }

    .orders-table td {
        padding: 14px 16px;
        font-size: 0.875rem;
        color: #4A3655;
        border-bottom: 1px solid #F8F3FC;
        vertical-align: middle;
    }

    .orders-table tbody tr:last-child td {
        border-bottom: none;
    }

    .orders-table tbody tr {
        transition: background 0.15s ease;
    }

    .orders-table tbody tr:hover td {
        background: #FBF7FF;
    }

    /* Order ID pill */
    .order-id-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #F0E8FA;
        color: #6B3D8F;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.5px;
    }

    /* Customer cell */
    .customer-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .customer-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: linear-gradient(135deg, #C8A2C8, #8B4DAB);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
    }

    .customer-name {
        font-weight: 600;
        color: #3D2549;
    }

    /* Amount */
    .amount-cell {
        font-weight: 700;
        color: #5D3A66;
    }

    /* Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 11px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-completed {
        background: #ECFDF5;
        color: #059669;
    }

    .status-pending {
        background: #FFFBEB;
        color: #D97706;
    }

    .status-cancelled, .status-other {
        background: #FEF2F2;
        color: #DC2626;
    }

    /* Payment method chip */
    .payment-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.78rem;
        color: #7A5285;
        background: #F9F4FF;
        padding: 3px 9px;
        border-radius: 6px;
        border: 1px solid #EAD8F5;
        font-weight: 500;
    }

    /* View button */
    .btn-view {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1.5px solid #DFC8F5;
        background: white;
        color: #8B4DAB;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-view:hover {
        background: #8B4DAB;
        color: white;
        border-color: #8B4DAB;
        box-shadow: 0 3px 8px rgba(139, 77, 171, 0.3);
        text-decoration: none;
    }

    /* Empty state */
    .empty-state {
        padding: 48px 24px;
        text-align: center;
        color: #B0A0BC;
    }

    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 12px;
        opacity: 0.4;
        display: block;
    }

    /* Card footer */
    .card-modern-footer {
        padding: 14px 24px;
        border-top: 1px solid #F0E8FA;
        background: #FDFAFF;
        display: flex;
        justify-content: center;
    }

    .btn-view-all {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 20px;
        border-radius: 8px;
        border: 1.5px solid #C8A2C8;
        background: white;
        color: #7A4F85;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-view-all:hover {
        background: #8B4DAB;
        color: white;
        border-color: #8B4DAB;
        box-shadow: 0 3px 12px rgba(139, 77, 171, 0.25);
        text-decoration: none;
    }
</style>

<div class="dashboard-main">
    <div class="dashboard-container">

        <!-- Header -->
        <div class="dashboard-header">
            <h1><i class="fas fa-chart-line header-icon"></i>Admin Dashboard</h1>
            <p>Welcome back, <strong style="color:white;">{{ auth()->user()->name }}</strong>!</p>
        </div>

        <!-- Key Metrics -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card metric-card metric-card--1">
                    <div class="card-body p-0">
                        <div class="metric-icon">
                            <i class="fas fa-peso-sign"></i>
                        </div>
                        <h6 class="card-title">Total Revenue</h6>
                        <h3>₱{{ number_format($totalRevenue, 2) }}</h3>
                        <small>From completed orders</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card metric-card metric-card--2">
                    <div class="card-body p-0">
                        <div class="metric-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <h6 class="card-title">Total Orders</h6>
                        <h3>{{ $totalOrders }}</h3>
                        <small>All-time orders</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card metric-card metric-card--3">
                    <div class="card-body p-0">
                        <div class="metric-icon">
                            <i class="fas fa-pills"></i>
                        </div>
                        <h6 class="card-title">Total Products</h6>
                        <h3>{{ $totalProducts }}</h3>
                        <small>In inventory</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card metric-card metric-card--4">
                    <div class="card-body p-0">
                        <div class="metric-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h6 class="card-title">Total Users</h6>
                        <h3>{{ $totalUsers }}</h3>
                        <small>Registered customers</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Alert -->
        @if($lowStockProducts > 0)
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="alert alert-custom alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Low Stock Alert!</strong> 
                        You have <strong>{{ $lowStockProducts }}</strong> product(s) with fewer than 10 units remaining.
                        <a href="#low-stock" class="alert-link ms-1">View details →</a>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Orders -->
        <div class="row">
            <div class="col-md-12">
                <div class="card-modern">
                    <div class="card-modern-header">
                        <div class="card-modern-header-left">
                            <div class="card-modern-header-icon">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <h5>Recent Orders</h5>
                            <span class="order-count-badge">{{ $recentOrders->count() }} latest</span>
                        </div>
                        <a href="{{ route('orders.index') }}" class="btn-view-all" style="font-size:0.8rem; padding:6px 14px;">
                            <i class="fas fa-arrow-right"></i>View All
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                    <tr>
                                        <td>
                                            <span class="order-id-pill">
                                                #{{ str_pad($order->order_id, 6, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="customer-cell">
                                                <div class="customer-avatar">
                                                    {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                                </div>
                                                <span class="customer-name">{{ $order->user->name }}</span>
                                            </div>
                                        </td>
                                        <td style="color:#8B7A9A; font-size:0.82rem;">
                                            <i class="fas fa-calendar-alt me-1" style="opacity:0.5;"></i>
                                            {{ $order->date_ordered->format('M d, Y') }}
                                            <br>
                                            <span style="font-size:0.75rem; opacity:0.7;">{{ $order->date_ordered->format('H:i') }}</span>
                                        </td>
                                        <td class="amount-cell">₱{{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            <span class="payment-chip">
                                                <i class="fas fa-{{ $order->payment_method === 'cash' ? 'money-bill' : 'credit-card' }}"></i>
                                                {{ ucfirst($order->payment_method) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($order->order_status === 'completed')
                                                <span class="status-badge status-completed">Completed</span>
                                            @elseif($order->order_status === 'pending')
                                                <span class="status-badge status-pending">Pending</span>
                                            @else
                                                <span class="status-badge status-other">{{ ucfirst($order->order_status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('orders.show', $order) }}" class="btn-view" title="View Order">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="empty-state">
                                                <i class="fas fa-inbox"></i>
                                                No recent orders yet
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection