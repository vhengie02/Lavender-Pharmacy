@extends('layouts.admin')

@section('title', $product->product_name . ' - Admin')

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

    .btn-header-action {
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
        cursor: pointer;
    }
    .btn-header-action:hover {
        background: rgba(255,255,255,0.28);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }
    .btn-header-action.danger {
        background: rgba(220, 38, 38, 0.22);
        border-color: rgba(255,255,255,0.3);
    }
    .btn-header-action.danger:hover {
        background: rgba(220, 38, 38, 0.38);
    }

    /* ── Card shell ── */
    .card-modern {
        background: white; border: none; border-radius: 14px;
        box-shadow: 0 2px 12px rgba(93, 58, 102, 0.07); overflow: hidden;
        margin-bottom: 20px;
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

    /* ── Detail rows (mirroring table rows) ── */
    .detail-table { width: 100%; border-collapse: collapse; }
    .detail-table th {
        padding: 11px 20px; font-size: 0.72rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.8px;
        color: #9B7BAB; border-bottom: 1px solid #F0E8FA;
        background: #FDFAFF; white-space: nowrap; width: 180px;
    }
    .detail-table td {
        padding: 14px 20px; font-size: 0.875rem; color: #4A3655;
        border-bottom: 1px solid #F8F3FC; vertical-align: middle;
    }
    .detail-table tbody tr:last-child td,
    .detail-table tbody tr:last-child th { border-bottom: none; }
    .detail-table tbody tr { transition: background 0.15s ease; }
    .detail-table tbody tr:hover td,
    .detail-table tbody tr:hover th { background: #FBF7FF; }

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
    }
    .stock-badge.low { background: #FEF2F2; color: #DC2626; }
    .stock-badge.ok  { background: #ECFDF5; color: #059669; }

    /* Rx badge */
    .rx-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 11px; border-radius: 20px;
        font-size: 0.75rem; font-weight: 700;
    }
    .rx-badge.required { background: #FFF7ED; color: #C2410C; }
    .rx-badge.not-required { background: #ECFDF5; color: #059669; }

    /* Description body */
    .description-body {
        padding: 20px 24px;
        font-size: 0.875rem; color: #4A3655; line-height: 1.7;
    }
    .description-body.empty { color: #A08AB0; font-style: italic; }

    /* Delete zone */
    .danger-zone-card {
        background: #FFF5F5; border: 1.5px solid #FED7D7;
        border-radius: 14px; padding: 20px 24px;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 14px;
        margin-top: 8px;
    }
    .danger-zone-label { font-size: 0.85rem; color: #9B1C1C; font-weight: 700; }
    .danger-zone-sub { font-size: 0.78rem; color: #C53030; margin-top: 2px; }
    .btn-delete {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 20px;
        background: white; border: 1.5px solid #FC8181;
        color: #C53030; border-radius: 9px;
        font-size: 0.85rem; font-weight: 700;
        cursor: pointer; transition: all 0.2s;
        white-space: nowrap;
    }
    .btn-delete:hover { background: #FEF2F2; border-color: #F56565; box-shadow: 0 3px 8px rgba(197,48,48,0.15); }
</style>

<div class="dashboard-main">
    <div class="dashboard-container">

        <!-- Header -->
        <div class="dashboard-header">
            <div class="dashboard-header-inner">
                <div>
                    <h1><i class="fas fa-pills header-icon"></i>{{ $product->product_name }}</h1>
                    <p>{{ $product->category->category_name ?? 'Uncategorized' }} &mdash; Product detail</p>
                </div>
                <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn-header-action">
                        <i class="fas fa-edit"></i> Edit Product
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn-header-action">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div class="card-modern">
            <div class="card-modern-header">
                <div class="card-modern-header-left">
                    <div class="card-modern-header-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h5>Product Details</h5>
                </div>
            </div>
            <table class="detail-table">
                <tbody>
                    <tr>
                        <th>Generic Name</th>
                        <td>{{ $product->generic_name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Brand</th>
                        <td>{{ $product->brand_name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>
                            <span class="category-chip">
                                {{ $product->category->category_name ?? '—' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td class="price-cell">₱{{ number_format($product->price, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Stock</th>
                        <td>
                            <span class="stock-badge {{ $product->stock_quantity < 10 ? 'low' : 'ok' }}">
                                <i class="fas fa-{{ $product->stock_quantity < 10 ? 'exclamation-triangle' : 'check-circle' }}" style="font-size:0.7rem;"></i>
                                {{ $product->stock_quantity }} units
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Rx Required</th>
                        <td>
                            <span class="rx-badge {{ $product->prescription_required ? 'required' : 'not-required' }}">
                                <i class="fas fa-{{ $product->prescription_required ? 'prescription' : 'times-circle' }}" style="font-size:0.7rem;"></i>
                                {{ $product->prescription_required ? 'Yes — Prescription required' : 'No' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Expiration Date</th>
                        <td>{{ $product->expiration_date?->format('M d, Y') ?? '—' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Description Card -->
        <div class="card-modern">
            <div class="card-modern-header">
                <div class="card-modern-header-left">
                    <div class="card-modern-header-icon">
                        <i class="fas fa-align-left"></i>
                    </div>
                    <h5>Description</h5>
                </div>
            </div>
            <div class="description-body {{ $product->description ? '' : 'empty' }}">
                {{ $product->description ?? 'No description provided for this product.' }}
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="danger-zone-card">
            <div>
                <div class="danger-zone-label"><i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i>Caution</div>
                <div class="danger-zone-sub">Permanently delete this product. This action cannot be undone.</div>
            </div>
            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete">
                    <i class="fas fa-trash-alt"></i> Delete Product
                </button>
            </form>
        </div>

    </div>
</div>

@endsection