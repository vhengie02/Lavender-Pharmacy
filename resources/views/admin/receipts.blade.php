@extends('layouts.admin')

@section('title', 'Receipts - Admin')

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

    /* Invoice # chip */
    .invoice-chip {
        font-family: 'Courier New', monospace;
        font-size: 0.8rem;
        font-weight: 700;
        color: #7A4F85;
        background: #F9F4FF;
        padding: 3px 8px;
        border-radius: 6px;
        border: 1px solid #EAD8F5;
        display: inline-block;
    }

    /* Order ID chip */
    .order-id-chip {
        font-family: 'Courier New', monospace;
        font-size: 0.78rem;
        color: #9B7BAB;
        background: #F9F4FF;
        padding: 2px 7px;
        border-radius: 5px;
        border: 1px solid #EAD8F5;
        display: inline-block;
    }

    /* Customer cell */
    .customer-cell { display: flex; align-items: center; gap: 10px; }
    .customer-icon-wrap {
        width: 32px; height: 32px; border-radius: 50%;
        background: linear-gradient(135deg, #F5EEFF, #EDE0FA);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .customer-icon-wrap i { color: #B57EDC; font-size: 0.8rem; }
    .customer-name { font-weight: 600; color: #3D2549; }

    /* Price */
    .price-cell { font-weight: 700; color: #5D3A66; }

    /* Date */
    .date-cell { color: #A08AB0; font-size: 0.82rem; }

    /* Action buttons */
    .btn-action {
        width: 32px; height: 32px; border-radius: 8px;
        border: 1.5px solid #DFC8F5; background: white; color: #8B4DAB;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.8rem; transition: all 0.2s ease; text-decoration: none;
    }
    .btn-action:hover { background: #8B4DAB; color: white; border-color: #8B4DAB; box-shadow: 0 3px 8px rgba(139,77,171,0.3); text-decoration: none; }
    .btn-action.download:hover { background: #5D3A66; border-color: #5D3A66; }
    .actions-cell { display: flex; justify-content: flex-end; gap: 6px; }

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
                    <h1><i class="fas fa-file-invoice header-icon"></i>Receipts</h1>
                    <p>Manage customer receipts and invoices</p>
                </div>
            </div>
        </div>

        <!-- Receipts Table Card -->
        <div class="card-modern">
            <div class="card-modern-header">
                <div class="card-modern-header-left">
                    <div class="card-modern-header-icon">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <h5>All Receipts</h5>
                    <span class="count-badge">{{ $receipts->total() }} items</span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($receipts as $receipt)
                            <tr>
                                <td>
                                    <span class="invoice-chip">{{ $receipt->invoice_number }}</span>
                                </td>
                                <td>
                                    <span class="order-id-chip">#{{ $receipt->order_id }}</span>
                                </td>
                                <td>
                                    <div class="customer-cell">
                                        <div class="customer-icon-wrap">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <span class="customer-name">{{ $receipt->order->user->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="price-cell">₱{{ number_format($receipt->order->total_amount, 2) }}</td>
                                <td>
                                    <span class="date-cell">{{ $receipt->date_created->format('M d, Y') }}</span>
                                </td>
                                <td class="text-right">
                                    <div class="actions-cell">
                                        <a href="{{ route('receipts.show', $receipt->receipt_id) }}" class="btn-action" title="View Receipt">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('receipts.download', $receipt->receipt_id) }}" class="btn-action download" title="Download Receipt">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p>No receipts found</p>
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
                {{ $receipts->appends(request()->query())->links() }}
            </div>
            @endif
        </div>

    </div>
</div>

@endsection