@extends('layouts.editor')

@section('title', 'Receipts - Editor')

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
    .dashboard-header h1 { font-size: 1.9rem; font-weight: 700; margin-bottom: 6px; color: white; }
    .dashboard-header p { color: rgba(255,255,255,0.75); font-size: 0.9rem; margin: 0; }
    .dashboard-header i.header-icon { margin-right: 10px; opacity: 0.85; }

    /* ── Card ── */
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
        background: #F0E8FA; color: #7A4F85;
        font-size: 0.72rem; font-weight: 700;
        padding: 3px 9px; border-radius: 20px;
    }

    /* ── Search ── */
    .search-inner {
        display: flex; gap: 8px;
        background: #F7F3FC;
        border: 1.5px solid #E0C8F5;
        border-radius: 10px;
        padding: 6px 12px;
        align-items: center;
        max-width: 360px;
    }
    .search-inner i { color: #B57EDC; font-size: 0.85rem; flex-shrink: 0; }
    .search-inner input {
        flex: 1; border: none; background: transparent;
        outline: none; font-size: 0.875rem; color: #3D2549;
    }
    .search-inner input::placeholder { color: #C0A8D8; }

    /* ── Table ── */
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

    /* Invoice number pill */
    .invoice-pill {
        display: inline-flex; align-items: center; gap: 6px;
        background: #F0E8FA; color: #6B3D8F;
        font-size: 0.78rem; font-weight: 700;
        padding: 4px 11px; border-radius: 6px;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.4px;
    }
    .invoice-pill i { font-size: 0.7rem; opacity: 0.7; }

    /* Order ID */
    .order-id-pill {
        display: inline-flex; align-items: center;
        background: #F9F4FF; color: #7A5285;
        font-size: 0.78rem; font-weight: 700;
        padding: 4px 10px; border-radius: 6px;
        font-family: 'Courier New', monospace;
    }

    /* Date cell */
    .date-cell { color: #8B7A9A; font-size: 0.82rem; }
    .date-cell span { display: block; font-size: 0.72rem; opacity: 0.7; margin-top: 1px; }

    /* Empty state */
    .empty-state { padding: 56px 24px; text-align: center; color: #B0A0BC; }
    .empty-state i { font-size: 2.8rem; margin-bottom: 14px; opacity: 0.3; display: block; }
    .empty-state p { font-size: 0.9rem; margin-bottom: 4px; }

    /* Footer / pagination */
    .card-modern-footer {
        padding: 14px 24px;
        border-top: 1px solid #F0E8FA;
        background: #FDFAFF;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .footer-info { font-size: 0.78rem; color: #A08AB0; }

    /* Override Laravel pagination to match theme */
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
            <h1><i class="fas fa-receipt header-icon"></i>Receipts</h1>
            <p>Orders with generated receipts</p>
        </div>

        <!-- Table Card -->
        <div class="card-modern">
            <div class="card-modern-header">
                <div class="card-modern-header-left">
                    <div class="card-modern-header-icon">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <h5>All Receipts</h5>
                    <span class="count-badge">{{ $receipts->total() }} total</span>
                </div>

                <div class="search-inner">
                    <i class="fas fa-search"></i>
                    <input type="text" id="receiptSearch" placeholder="Search invoice or order…">
                </div>
            </div>

            <div class="table-responsive">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Order</th>
                            <th>Date Created</th>
                        </tr>
                    </thead>
                    <tbody id="receiptsTableBody">
                        @forelse ($receipts as $receipt)
                            <tr data-invoice="{{ strtolower($receipt->invoice_number) }}"
                                data-order="{{ $receipt->order_id }}">
                                <td>
                                    <span class="invoice-pill">
                                        <i class="fas fa-file-invoice"></i>
                                        {{ $receipt->invoice_number }}
                                    </span>
                                </td>
                                <td>
                                    <span class="order-id-pill">
                                        #{{ str_pad($receipt->order_id, 6, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td class="date-cell">
                                    {{ $receipt->date_created?->format('M d, Y') }}
                                    <span>{{ $receipt->date_created?->format('H:i') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="empty-state">
                                        <i class="fas fa-receipt"></i>
                                        <p>No receipts yet</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($receipts->hasPages() || $receipts->count() > 0)
            <div class="card-modern-footer">
                <span class="footer-info">
                    Showing {{ $receipts->firstItem() }}–{{ $receipts->lastItem() }} of {{ $receipts->total() }} receipts
                </span>
                {{ $receipts->links() }}
            </div>
            @endif
        </div>

    </div>
</div>

@push('scripts')
<script>
document.getElementById('receiptSearch').addEventListener('keyup', function () {
    const query = this.value.toLowerCase().trim();
    document.querySelectorAll('#receiptsTableBody tr[data-invoice]').forEach(row => {
        const matches = query === '' ||
            row.dataset.invoice.includes(query) ||
            row.dataset.order.includes(query);
        row.style.display = matches ? '' : 'none';
    });
});
</script>
@endpush

@endsection