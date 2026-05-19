@extends('layouts.admin')

@section('title', 'Products - Admin')

@section('content')
<style>
    .dashboard-main { width: 100%; min-height: 100vh; background: #F7F3FC; }
    .dashboard-container { padding: 32px 40px; max-width: 1400px; margin: 0 auto; }
    @media (max-width: 768px) { .dashboard-container { padding: 24px 16px; } }

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
        top: -40px; right: -40px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        pointer-events: none;
    }
    .dashboard-header-inner {
        display: flex; align-items: center;
        justify-content: space-between;
        flex-wrap: wrap; gap: 16px;
    }
    .dashboard-header h1 { font-size: 1.9rem; font-weight: 700; margin-bottom: 6px; color: white; }
    .dashboard-header p { color: rgba(255,255,255,0.75); font-size: 0.9rem; margin: 0; }
    .dashboard-header i.header-icon { margin-right: 10px; opacity: 0.85; }

    /* ── Header search form ── */
    .header-search {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-shrink: 0;
    }
    .header-search-inner {
        display: flex; gap: 0;
        background: rgba(255,255,255,0.15);
        border: 1.5px solid rgba(255,255,255,0.35);
        border-radius: 9px;
        overflow: hidden;
        align-items: center;
    }
    .header-search-inner i {
        padding: 0 10px;
        color: rgba(255,255,255,0.7);
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    .header-search-inner input {
        background: transparent;
        border: none;
        outline: none;
        padding: 9px 12px 9px 0;
        font-size: 0.875rem;
        color: white;
        min-width: 200px;
    }
    .header-search-inner input::placeholder { color: rgba(255,255,255,0.55); }
    .btn-search {
        padding: 10px 18px;
        background: rgba(255,255,255,0.2);
        border: none;
        border-left: 1.5px solid rgba(255,255,255,0.25);
        color: white;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }
    .btn-search:hover { background: rgba(255,255,255,0.3); }

    .btn-add-header {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: rgba(255,255,255,0.18);
        border: 1.5px solid rgba(255,255,255,0.4);
        color: white;
        border-radius: 9px;
        font-size: 0.88rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .btn-add-header:hover {
        background: rgba(255,255,255,0.28);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* ── Card shell ── */
    .card-modern {
        background: white; border: none; border-radius: 14px;
        box-shadow: 0 2px 12px rgba(93, 58, 102, 0.07); overflow: hidden;
    }
    .card-modern-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 18px 24px; border-bottom: 1px solid #F0E8FA;
        flex-wrap: wrap; gap: 12px;
    }
    .card-modern-header-left { display: flex; align-items: center; gap: 12px; }
    .card-modern-header-icon {
        width: 36px; height: 36px;
        background: linear-gradient(135deg, #8B4DAB, #C8A2C8);
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .card-modern-header-icon i { color: white; font-size: 0.9rem; }
    .card-modern-header h5 { font-size: 1rem; font-weight: 700; color: #3D2549; margin: 0; }
    .count-badge {
        background: #F0E8FA; color: #7A4F85;
        font-size: 0.72rem; font-weight: 700;
        padding: 3px 9px; border-radius: 20px;
    }

    /* active search indicator */
    .search-active-chip {
        display: inline-flex; align-items: center; gap: 6px;
        background: #EFE0FF; color: #6B3D8F;
        font-size: 0.72rem; font-weight: 700;
        padding: 3px 10px; border-radius: 20px;
        border: 1px solid #D4B0F0;
    }
    .search-active-chip a {
        color: #9B5CC0; text-decoration: none; margin-left: 2px;
        font-size: 0.8rem; line-height: 1;
    }
    .search-active-chip a:hover { color: #5D3A66; }

    /* ── Table ── */
    .orders-table { width: 100%; border-collapse: collapse; }
    .orders-table thead tr { background: #FDFAFF; }
    .orders-table th {
        padding: 11px 20px; font-size: 0.72rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.8px;
        color: #9B7BAB; border-bottom: 1px solid #F0E8FA; white-space: nowrap;
    }
    .orders-table th.text-right { text-align: right; }
    .orders-table td {
        padding: 14px 20px; font-size: 0.875rem; color: #4A3655;
        border-bottom: 1px solid #F8F3FC; vertical-align: middle;
    }
    .orders-table td.text-right { text-align: right; }
    .orders-table tbody tr:last-child td { border-bottom: none; }
    .orders-table tbody tr { transition: background 0.15s ease; }
    .orders-table tbody tr:hover td { background: #FBF7FF; }

    /* Product name cell */
    .product-cell { display: flex; align-items: center; gap: 12px; }
    .product-icon-wrap {
        width: 38px; height: 38px; border-radius: 9px;
        background: linear-gradient(135deg, #F5EEFF, #EDE0FA);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .product-icon-wrap i { color: #B57EDC; font-size: 0.95rem; }
    .product-name-main { font-weight: 700; color: #3D2549; font-size: 0.875rem; line-height: 1.3; }
    .product-name-generic { font-size: 0.75rem; color: #A08AB0; line-height: 1.3; }

    /* Category chip */
    .category-chip {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 0.78rem; color: #7A5285;
        background: #F9F4FF; padding: 3px 9px;
        border-radius: 6px; border: 1px solid #EAD8F5; font-weight: 500;
    }

    /* Price */
    .price-cell { font-weight: 700; color: #5D3A66; }

    /* Stock badge */
    .stock-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 11px; border-radius: 20px;
        font-size: 0.75rem; font-weight: 700; white-space: nowrap;
        float: right;
    }
    .stock-badge.low { background: #FEF2F2; color: #DC2626; }
    .stock-badge.ok  { background: #ECFDF5; color: #059669; }

    /* View button */
    .btn-view {
        width: 32px; height: 32px; border-radius: 8px;
        border: 1.5px solid #DFC8F5; background: white; color: #8B4DAB;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.8rem; transition: all 0.2s ease; text-decoration: none;
    }
    .btn-view:hover { background: #8B4DAB; color: white; border-color: #8B4DAB; box-shadow: 0 3px 8px rgba(139,77,171,0.3); text-decoration: none; }

    /* Empty state */
    .empty-state { padding: 56px 24px; text-align: center; color: #B0A0BC; }
    .empty-state i { font-size: 2.8rem; margin-bottom: 14px; opacity: 0.3; display: block; }
    .empty-state p { font-size: 0.9rem; margin-bottom: 4px; }

    /* Footer / pagination */
    .card-modern-footer {
        padding: 14px 24px; border-top: 1px solid #F0E8FA;
        background: #FDFAFF;
        display: flex; justify-content: space-between;
        align-items: center; flex-wrap: wrap; gap: 10px;
    }
    .footer-info { font-size: 0.78rem; color: #A08AB0; }

    .card-modern-footer nav { display: flex; align-items: center; }
    .card-modern-footer .pagination { margin: 0; display: flex; gap: 4px; list-style: none; padding: 0; }
    .card-modern-footer .page-item .page-link {
        padding: 5px 10px; border-radius: 7px;
        font-size: 0.8rem; font-weight: 600;
        border: 1.5px solid #E0C8F5;
        color: #7A4F85; background: white;
        text-decoration: none; transition: all 0.2s;
    }
    .card-modern-footer .page-item.active .page-link {
        background: linear-gradient(135deg, #8B4DAB, #B57EDC);
        border-color: transparent; color: white;
        box-shadow: 0 2px 8px rgba(139,77,171,0.3);
    }
    .card-modern-footer .page-item.disabled .page-link { opacity: 0.4; cursor: not-allowed; }
    .card-modern-footer .page-item .page-link:hover:not(.active) { background: #F0E8FA; color: #5D3A66; }
</style>

<div class="dashboard-main">
    <div class="dashboard-container">

        <!-- Header -->
        <div class="dashboard-header">
            <div class="dashboard-header-inner">
                <div>
                    <h1><i class="fas fa-pills header-icon"></i>Products</h1>
                    <p>Catalog administration</p>
                </div>
                <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                    <form action="{{ route('admin.products.index') }}" method="GET" class="header-search">
                        <div class="header-search-inner">
                            <i class="fas fa-search"></i>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search products…"
                            >
                            <button type="submit" class="btn-search">Search</button>
                        </div>
                    </form>
                    <a href="{{ route('admin.products.create') }}" class="btn-add-header">
                        <i class="fas fa-plus"></i> Add Product
                    </a>
                </div>
            </div>
        </div>

        <!-- Products Table Card -->
        <div class="card-modern">
            <div class="card-modern-header">
                <div class="card-modern-header-left">
                    <div class="card-modern-header-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <h5>All Products</h5>
                    <span class="count-badge">{{ $products->total() }} items</span>
                    @if(request('search'))
                        <span class="search-active-chip">
                            <i class="fas fa-filter" style="font-size:0.65rem;"></i>
                            "{{ request('search') }}"
                            <a href="{{ route('admin.products.index') }}" title="Clear search">✕</a>
                        </span>
                    @endif
                </div>
            </div>

            <div class="table-responsive">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th class="text-right">Price</th>
                            <th class="text-right">Stock</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>
                                    <div class="product-cell">
                                        <div class="product-icon-wrap">
                                            <i class="fas fa-pills"></i>
                                        </div>
                                        <div>
                                            <div class="product-name-main">{{ $product->product_name }}</div>
                                            @if($product->generic_name)
                                                <div class="product-name-generic">{{ $product->generic_name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="category-chip">
                                        {{ $product->category->category_name ?? '—' }}
                                    </span>
                                </td>
                                <td class="text-right price-cell">₱{{ number_format($product->price, 2) }}</td>
                                <td class="text-right">
                                    <span class="stock-badge {{ $product->stock_quantity < 10 ? 'low' : 'ok' }}">
                                        {{ $product->stock_quantity }} units
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn-view" title="View Product">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p>No products found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages() || $products->count() > 0)
            <div class="card-modern-footer">
                <span class="footer-info">
                    Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} products
                </span>
                {{ $products->appends(request()->query())->links() }}
            </div>
            @endif
        </div>

    </div>
</div>

@endsection