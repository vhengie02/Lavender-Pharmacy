@extends('layouts.editor')

@section('title', 'Editor Dashboard - Lavender Pharmacy')

@section('content')
<style>
    .dashboard-main { width: 100%; min-height: 100vh; background: #F7F3FC; }
    .dashboard-container { padding: 32px 40px; max-width: 1400px; margin: 0 auto; }
    @media (max-width: 768px) { .dashboard-container { padding: 24px 16px; } }

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
        top: -40px; right: -40px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        pointer-events: none;
    }
    .dashboard-header h1 { font-size: 1.9rem; font-weight: 700; margin-bottom: 6px; color: white; }
    .dashboard-header p { color: rgba(255,255,255,0.75); font-size: 0.9rem; margin: 0; }
    .dashboard-header i.header-icon { margin-right: 10px; opacity: 0.85; }

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
        bottom: -20px; right: -20px;
        width: 90px; height: 90px;
        border-radius: 50%;
        background: var(--metric-color, #B57EDC);
        opacity: 0.06;
        pointer-events: none;
    }
    .metric-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: var(--metric-color, #B57EDC);
        border-radius: 12px 12px 0 0;
    }
    .metric-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(93, 58, 102, 0.14); }
    .metric-card--1 { --metric-color: #B57EDC; }
    .metric-card--2 { --metric-color: #dc3545; }
    .metric-card--3 { --metric-color: #5D3A66; }

    .metric-icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    background: color-mix(in srgb, var(--metric-color) 12%, white);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 14px;
}
.metric-icon i {
    font-size: 1rem;
    color: var(--metric-color);
}
    .metric-card .card-title {
        font-size: 0.75rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.8px;
        color: #A090B0; margin-bottom: 8px;
    }
    .metric-card h3 { font-size: 2.2rem; font-weight: 800; margin-bottom: 4px; color: var(--metric-color); line-height: 1; }
    .metric-card small { color: #B0A0BC; font-size: 0.78rem; }

    .card-modern {
        background: white; border: none; border-radius: 14px;
        box-shadow: 0 2px 12px rgba(93, 58, 102, 0.07);
        overflow: hidden;
    }
    .card-modern-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 20px 24px; border-bottom: 1px solid #F0E8FA;
    }
    .card-modern-header-left { display: flex; align-items: center; gap: 12px; }
    .card-modern-header-icon {
        width: 36px; height: 36px;
        background: linear-gradient(135deg, #8B4DAB, #C8A2C8);
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
    }
    .card-modern-header-icon i { color: white; font-size: 0.9rem; }
    .card-modern-header h5 { font-size: 1rem; font-weight: 700; color: #3D2549; margin: 0; }
    .order-count-badge {
        background: #F0E8FA; color: #7A4F85;
        font-size: 0.72rem; font-weight: 700;
        padding: 3px 9px; border-radius: 20px;
    }

    .orders-table { width: 100%; border-collapse: collapse; }
    .orders-table thead tr { background: #FDFAFF; }
    .orders-table th {
        padding: 11px 16px; font-size: 0.72rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.8px;
        color: #9B7BAB; border-bottom: 1px solid #F0E8FA; white-space: nowrap;
    }
    .orders-table td {
        padding: 14px 16px; font-size: 0.875rem;
        color: #4A3655; border-bottom: 1px solid #F8F3FC; vertical-align: middle;
    }
    .orders-table tbody tr:last-child td { border-bottom: none; }
    .orders-table tbody tr:hover td { background: #FBF7FF; }

    .stock-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 11px; border-radius: 20px;
        font-size: 0.75rem; font-weight: 700;
    }
    .stock-badge.low { background: #FEF2F2; color: #DC2626; }
    .stock-badge.ok { background: #ECFDF5; color: #059669; }

    .btn-view {
        width: 32px; height: 32px; border-radius: 8px;
        border: 1.5px solid #DFC8F5; background: white; color: #8B4DAB;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.8rem; transition: all 0.2s ease; text-decoration: none;
    }
    .btn-view:hover {
        background: #8B4DAB; color: white; border-color: #8B4DAB;
        box-shadow: 0 3px 8px rgba(139, 77, 171, 0.3); text-decoration: none;
    }

    .empty-state { padding: 48px 24px; text-align: center; color: #B0A0BC; }
    .empty-state i { font-size: 2.5rem; margin-bottom: 12px; opacity: 0.4; display: block; }

    .card-modern-footer {
        padding: 14px 24px; border-top: 1px solid #F0E8FA;
        background: #FDFAFF; display: flex; justify-content: center;
    }
    .btn-view-all {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 8px 20px; border-radius: 8px;
        border: 1.5px solid #C8A2C8; background: white; color: #7A4F85;
        font-size: 0.85rem; font-weight: 600; text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-view-all:hover {
        background: #8B4DAB; color: white; border-color: #8B4DAB;
        box-shadow: 0 3px 12px rgba(139, 77, 171, 0.25); text-decoration: none;
    }
</style>

<div class="dashboard-main">
    <div class="dashboard-container">

        <div class="dashboard-header">
            <h1><i class="fas fa-edit header-icon"></i>Editor Dashboard</h1>
            <p>Welcome back, <strong style="color:white;">{{ auth()->user()->name }}</strong>!</p>
        </div>

        <div class="row mb-4">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card metric-card metric-card--1">
                    <div class="card-body p-0">
                        <div class="metric-icon"><i class="fas fa-pills"></i></div>
                        <h6 class="card-title">Total Products</h6>
                        <h3>{{ $totalProducts }}</h3>
                        <small>In inventory</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card metric-card metric-card--2">
                    <div class="card-body p-0">
                        <div class="metric-icon"><i class="fas fa-exclamation-triangle"></i></div>
                        <h6 class="card-title">Low Stock Products</h6>
                        <h3>{{ $lowStockProducts }}</h3>
                        <small>Less than 10 units</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card metric-card metric-card--3">
                    <div class="card-body p-0">
                        <div class="metric-icon"><i class="fas fa-clock"></i></div>
                        <h6 class="card-title">Recently Updated</h6>
                        <h3>{{ $recentProducts->count() }}</h3>
                        <small>Latest product changes</small>
                    </div>
                </div>
            </div>
        </div>

        <x-low-stock-alert :count="$lowStockProducts" />

        <div class="row">
            <div class="col-md-12">
                <div class="card-modern">
                    <div class="card-modern-header">
                        <div class="card-modern-header-left">
                            <div class="card-modern-header-icon">
                                <i class="fas fa-boxes"></i>
                            </div>
                            <h5>Recently Updated Products</h5>
                            <span class="order-count-badge">{{ $recentProducts->count() }} latest</span>
                        </div>
                        <a href="{{ route('editor.products.create') }}" class="btn-view-all" style="font-size:0.8rem; padding:6px 14px;">
                            <i class="fas fa-plus"></i> Add Product
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Stock</th>
                                    <th>Price</th>
                                    <th>Updated</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentProducts as $product)
                                    <tr>
                                        <td>
                                            <strong style="color:#3D2549;">{{ $product->product_name }}</strong>
                                            @if($product->generic_name)
                                                <br><span style="font-size:0.78rem; color:#8B7A9A;">{{ $product->generic_name }}</span>
                                            @endif
                                        </td>
                                        <td style="color:#8B7A9A;">{{ $product->category->category_name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="stock-badge {{ $product->stock_quantity < 10 ? 'low' : 'ok' }}">
                                                {{ $product->stock_quantity }} units
                                            </span>
                                        </td>
                                        <td style="font-weight:700; color:#5D3A66;">₱{{ number_format($product->price, 2) }}</td>
                                        <td style="color:#8B7A9A; font-size:0.82rem;">
                                            {{ $product->date_updated->format('M d, Y') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('editor.products.edit', $product) }}" class="btn-view" title="Edit Product">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">
                                                <i class="fas fa-inbox"></i>
                                                No products yet
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
