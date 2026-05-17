@extends('layouts.editor')

@section('title', 'Products - Lavender Pharmacy')

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
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }
    .dashboard-header h1 { font-size: 1.9rem; font-weight: 700; margin-bottom: 6px; color: white; }
    .dashboard-header p { color: rgba(255,255,255,0.75); font-size: 0.9rem; margin: 0; }
    .dashboard-header i.header-icon { margin-right: 10px; opacity: 0.85; }

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
        padding: 18px 24px;
        border-bottom: 1px solid #F0E8FA;
        flex-wrap: wrap;
        gap: 12px;
    }
    .card-modern-header-left { display: flex; align-items: center; gap: 12px; }
    .card-modern-header-icon {
        width: 36px; height: 36px;
        background: linear-gradient(135deg, #8B4DAB, #C8A2C8);
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .card-modern-header-icon i { color: white; font-size: 0.9rem; }
    .card-modern-header h5 { font-size: 1rem; font-weight: 700; color: #3D2549; margin: 0; }

    .count-badge {
        background: #F0E8FA;
        color: #7A4F85;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 20px;
    }

    /* ── Search ── */
    .search-wrap { padding: 16px 24px; border-bottom: 1px solid #F0E8FA; }
    .search-inner {
        display: flex;
        gap: 8px;
        background: #F7F3FC;
        border: 1.5px solid #E0C8F5;
        border-radius: 10px;
        padding: 6px 12px;
        align-items: center;
        max-width: 420px;
    }
    .search-inner i { color: #B57EDC; font-size: 0.85rem; flex-shrink: 0; }
    .search-inner input {
        flex: 1; border: none; background: transparent;
        outline: none; font-size: 0.875rem; color: #3D2549;
    }
    .search-inner input::placeholder { color: #C0A8D8; }

    /* ── Products table ── */
    .orders-table { width: 100%; border-collapse: collapse; }
    .orders-table thead tr { background: #FDFAFF; }
    .orders-table th {
        padding: 11px 20px;
        font-size: 0.72rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.8px;
        color: #9B7BAB; border-bottom: 1px solid #F0E8FA; white-space: nowrap;
    }
    .orders-table td {
        padding: 14px 20px;
        font-size: 0.875rem; color: #4A3655;
        border-bottom: 1px solid #F8F3FC; vertical-align: middle;
    }
    .orders-table tbody tr:last-child td { border-bottom: none; }
    .orders-table tbody tr { transition: background 0.15s ease; }
    .orders-table tbody tr:hover td { background: #FBF7FF; }

    /* Product name cell */
    .product-cell { display: flex; align-items: center; gap: 12px; }
    .product-icon-wrap {
        width: 38px; height: 38px;
        border-radius: 9px;
        background: linear-gradient(135deg, #F5EEFF, #EDE0FA);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .product-icon-wrap i { color: #B57EDC; font-size: 0.95rem; }
    .product-name-main { font-weight: 700; color: #3D2549; font-size: 0.875rem; line-height: 1.3; }
    .product-name-generic { font-size: 0.75rem; color: #A08AB0; line-height: 1.3; }

    /* Stock badge */
    .stock-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 11px; border-radius: 20px;
        font-size: 0.75rem; font-weight: 700; white-space: nowrap;
    }
    .stock-badge.low { background: #FEF2F2; color: #DC2626; }
    .stock-badge.ok  { background: #ECFDF5; color: #059669; }

    /* Price */
    .price-cell { font-weight: 700; color: #5D3A66; }

    /* Category chip */
    .category-chip {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 0.78rem; color: #7A5285;
        background: #F9F4FF; padding: 3px 9px;
        border-radius: 6px; border: 1px solid #EAD8F5; font-weight: 500;
    }

    /* Action buttons */
    .btn-action-sm {
        width: 32px; height: 32px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.8rem; transition: all 0.2s ease; text-decoration: none;
        cursor: pointer; border: 1.5px solid;
    }
    .btn-edit {
        border-color: #DFC8F5; background: white; color: #8B4DAB;
    }
    .btn-edit:hover { background: #8B4DAB; color: white; border-color: #8B4DAB; box-shadow: 0 3px 8px rgba(139,77,171,0.3); }

    /* Empty state */
    .empty-state { padding: 56px 24px; text-align: center; color: #B0A0BC; }
    .empty-state i { font-size: 2.8rem; margin-bottom: 14px; opacity: 0.3; display: block; }
    .empty-state p { font-size: 0.9rem; margin-bottom: 4px; }
    .empty-state small { font-size: 0.78rem; opacity: 0.7; }

    .btn-add-empty {
        display: inline-flex; align-items: center; gap: 8px;
        margin-top: 16px; padding: 10px 22px;
        background: linear-gradient(135deg, #8B4DAB, #B57EDC);
        color: white; border-radius: 9px; font-size: 0.88rem; font-weight: 700;
        text-decoration: none; transition: all 0.2s ease;
        box-shadow: 0 3px 10px rgba(139,77,171,0.3);
    }
    .btn-add-empty:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(139,77,171,0.4); color: white; text-decoration: none; }

    /* Footer */
    .card-modern-footer {
        padding: 14px 24px; border-top: 1px solid #F0E8FA;
        background: #FDFAFF; display: flex; justify-content: space-between;
        align-items: center; flex-wrap: wrap; gap: 10px;
    }
    .footer-info { font-size: 0.78rem; color: #A08AB0; }

    .btn-view-all {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 7px 16px; border-radius: 8px;
        border: 1.5px solid #C8A2C8; background: white; color: #7A4F85;
        font-size: 0.82rem; font-weight: 600; text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-view-all:hover { background: #8B4DAB; color: white; border-color: #8B4DAB; text-decoration: none; }
</style>

<div class="dashboard-main">
    <div class="dashboard-container">

        <!-- Header -->
        <div class="dashboard-header">
            <div class="dashboard-header-inner">
                <div>
                    <h1><i class="fas fa-pills header-icon"></i>Products</h1>
                    <p>Manage your pharmacy inventory</p>
                </div>
                <a href="{{ route('editor.products.create') }}" class="btn-add-header">
                    <i class="fas fa-plus"></i> Add Product
                </a>
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
                    <span class="count-badge">{{ $products->count() }} items</span>
                </div>

                <!-- Search -->
                <div class="search-inner">
                    <i class="fas fa-search"></i>
                    <input type="text" id="productSearch" placeholder="Search products…">
                </div>
            </div>

            <div class="table-responsive">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody">
                        @forelse($products as $product)
                            <tr data-name="{{ strtolower($product->product_name) }}"
                                data-generic="{{ strtolower($product->generic_name ?? '') }}"
                                data-category="{{ strtolower($product->category->category_name ?? '') }}">
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
                                        {{ $product->category->category_name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="stock-badge {{ $product->stock_quantity < 10 ? 'low' : 'ok' }}">
                                        {{ $product->stock_quantity }} units
                                    </span>
                                </td>
                                <td class="price-cell">₱{{ number_format($product->price, 2) }}</td>
                                <td style="color:#8B7A9A; font-size:0.82rem; max-width:220px;">
                                    {{ Str::limit($product->description ?? '—', 60) }}
                                </td>
                                <td>
                                    <a href="{{ route('editor.products.edit', $product) }}" class="btn-action-sm btn-edit" title="Edit Product">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p>No products yet</p>
                                        <small>Add your first product to get started</small>
                                        <br>
                                        <a href="{{ route('editor.products.create') }}" class="btn-add-empty">
                                            <i class="fas fa-plus"></i> Add Product
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->count() > 0)
            <div class="card-modern-footer">
                <span class="footer-info">Showing {{ $products->count() }} product(s)</span>
            </div>
            @endif
        </div>

    </div>
</div>

@push('scripts')
<script>
document.getElementById('productSearch').addEventListener('keyup', function () {
    const query = this.value.toLowerCase().trim();
    document.querySelectorAll('#productsTableBody tr[data-name]').forEach(row => {
        const matches = query === '' ||
            row.dataset.name.includes(query) ||
            row.dataset.generic.includes(query) ||
            row.dataset.category.includes(query);
        row.style.display = matches ? '' : 'none';
    });
});
</script>
@endpush

@endsection