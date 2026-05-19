@extends('layouts.admin')

@section('title', 'Admin Dashboard - Lavender Pharmacy')

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
    .dashboard-header::after {
        content: '';
        position: absolute;
        bottom: -60px; right: 80px;
        width: 240px; height: 240px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
        pointer-events: none;
    }
    .dashboard-header h1 { font-size: 1.9rem; font-weight: 700; margin-bottom: 6px; color: white; }
    .dashboard-header p { color: rgba(255,255,255,0.75); font-size: 0.9rem; margin: 0; }
    .dashboard-header i.header-icon { margin-right: 10px; opacity: 0.85; }

    /* ── Section label ── */
    .section-label {
        font-size: 0.7rem; font-weight: 800; text-transform: uppercase;
        letter-spacing: 1.2px; color: #A090B0; margin-bottom: 12px;
        display: flex; align-items: center; gap: 8px;
    }
    .section-label::after {
        content: ''; flex: 1; height: 1px; background: #EAD8F5;
    }

    /* ── Metric cards ── */
    .metric-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 10px;
    }
    @media (max-width: 1100px) { .metric-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px)  { .metric-grid { grid-template-columns: 1fr; } }

    .metric-card {
        background: white; border: none; border-radius: 14px;
        padding: 22px 24px;
        box-shadow: 0 2px 12px rgba(93, 58, 102, 0.07);
        transition: all 0.25s ease;
        position: relative; overflow: hidden;
    }
    .metric-card::after {
        content: '';
        position: absolute; bottom: -20px; right: -20px;
        width: 90px; height: 90px; border-radius: 50%;
        background: var(--mc, #B57EDC);
        opacity: 0.06; transition: opacity 0.25s ease; pointer-events: none;
    }
    .metric-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: var(--mc, #B57EDC);
        border-radius: 14px 14px 0 0;
    }
    .metric-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(93, 58, 102, 0.14); }
    .metric-card:hover::after { opacity: 0.1; }

    .metric-card--1 { --mc: #B57EDC; }
    .metric-card--2 { --mc: #5D3A66; }
    .metric-card--3 { --mc: #C8A2C8; }
    .metric-card--4 { --mc: #8B4DAB; }
    .metric-card--5 { --mc: #059669; }
    .metric-card--6 { --mc: #D97706; }
    .metric-card--7 { --mc: #2563EB; }
    .metric-card--8 { --mc: #DC2626; }

    .metric-icon {
        width: 40px; height: 40px; border-radius: 10px;
        background: color-mix(in srgb, var(--mc) 12%, white);
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 14px;
    }
    .metric-icon i { font-size: 1rem; color: var(--mc); }

    .metric-label {
        font-size: 0.72rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.8px;
        color: #A090B0; margin-bottom: 6px;
    }
    .metric-value { font-size: 2rem; font-weight: 800; color: var(--mc); line-height: 1; margin-bottom: 4px; }
    .metric-sub { color: #B0A0BC; font-size: 0.78rem; }

    /* ── Card shell ── */
    .card-modern {
        background: white; border: none; border-radius: 14px;
        box-shadow: 0 2px 12px rgba(93, 58, 102, 0.07); overflow: hidden;
        margin-bottom: 24px;
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
    .card-modern-header p { font-size: 0.78rem; color: #A08AB0; margin: 2px 0 0; }
    .count-badge {
        background: #F0E8FA; color: #7A4F85;
        font-size: 0.72rem; font-weight: 700;
        padding: 3px 9px; border-radius: 20px;
    }
    .card-modern-footer {
        padding: 14px 24px; border-top: 1px solid #F0E8FA;
        background: #FDFAFF; display: flex; justify-content: center;
    }

    /* ── Two-col layout ── */
    .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 0; }
    @media (max-width: 900px) { .two-col { grid-template-columns: 1fr; } }

    /* ── Revenue chart ── */
    .chart-body { padding: 24px 24px 20px; }
    .chart-wrap { position: relative; height: 260px; }

    .period-toggle {
        display: flex; gap: 4px;
        background: #F7F3FC; border: 1px solid #E8D8F5;
        border-radius: 8px; padding: 3px;
    }
    .period-btn {
        padding: 5px 13px; border-radius: 6px; border: none;
        background: transparent; font-size: 0.75rem; font-weight: 600;
        color: #9B7BAB; cursor: pointer; transition: all 0.2s ease;
    }
    .period-btn.active { background: white; color: #5D3A66; box-shadow: 0 1px 4px rgba(93,58,102,0.12); }
    .period-btn:hover:not(.active) { color: #5D3A66; }

    /* ── Top Products card ── */
    .top-products-list { padding: 8px 0; }
    .top-product-row {
        display: flex; align-items: center; gap: 14px;
        padding: 12px 24px; border-bottom: 1px solid #F8F3FC;
        transition: background 0.15s;
    }
    .top-product-row:last-child { border-bottom: none; }
    .top-product-row:hover { background: #FBF7FF; }

    .rank-badge {
        width: 26px; height: 26px; border-radius: 7px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.72rem; font-weight: 800;
    }
    .rank-badge.r1 { background: #FFF8E6; color: #D97706; }
    .rank-badge.r2 { background: #F4F4F5; color: #71717A; }
    .rank-badge.r3 { background: #FFF2EE; color: #EA580C; }
    .rank-badge.rn { background: #F5EEFF; color: #9B7BAB; }

    .top-product-name { font-weight: 700; color: #3D2549; font-size: 0.875rem; flex: 1; min-width: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .top-product-units { font-size: 0.78rem; color: #A08AB0; white-space: nowrap; }
    .top-product-revenue { font-weight: 700; color: #5D3A66; font-size: 0.875rem; white-space: nowrap; }

    .progress-wrap { flex: 1; max-width: 100px; }
    .progress-bar-bg { height: 5px; background: #F0E8FA; border-radius: 99px; overflow: hidden; }
    .progress-bar-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #8B4DAB, #C8A2C8); }

    .top-product-pct { font-size: 0.72rem; font-weight: 700; color: #9B7BAB; white-space: nowrap; width: 34px; text-align: right; }

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
        padding: 13px 20px; font-size: 0.875rem; color: #4A3655;
        border-bottom: 1px solid #F8F3FC; vertical-align: middle;
    }
    .orders-table tbody tr:last-child td { border-bottom: none; }
    .orders-table tbody tr { transition: background 0.15s ease; }
    .orders-table tbody tr:hover td { background: #FBF7FF; }

    .order-id-pill {
        display: inline-flex; align-items: center;
        background: #F0E8FA; color: #6B3D8F;
        font-size: 0.78rem; font-weight: 700;
        padding: 4px 10px; border-radius: 6px;
        font-family: 'Courier New', monospace;
    }
    .customer-cell { display: flex; align-items: center; gap: 10px; }
    .customer-avatar {
        width: 30px; height: 30px; border-radius: 50%;
        background: linear-gradient(135deg, #C8A2C8, #8B4DAB);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.72rem; font-weight: 700; color: white; flex-shrink: 0;
    }
    .customer-name { font-weight: 600; color: #3D2549; }
    .amount-cell { font-weight: 700; color: #5D3A66; }

    .payment-chip {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 0.78rem; color: #7A5285;
        background: #F9F4FF; padding: 3px 9px;
        border-radius: 6px; border: 1px solid #EAD8F5; font-weight: 500;
    }
    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 11px; border-radius: 20px;
        font-size: 0.75rem; font-weight: 700; white-space: nowrap;
    }
    .status-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .status-completed { background: #ECFDF5; color: #059669; }
    .status-pending   { background: #FFFBEB; color: #D97706; }
    .status-other     { background: #FEF2F2; color: #DC2626; }

    .date-cell { color: #8B7A9A; font-size: 0.82rem; }
    .date-time { font-size: 0.72rem; opacity: 0.65; display: block; margin-top: 1px; }

    .btn-view {
        width: 32px; height: 32px; border-radius: 8px;
        border: 1.5px solid #DFC8F5; background: white; color: #8B4DAB;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.8rem; transition: all 0.2s ease; text-decoration: none;
    }
    .btn-view:hover { background: #8B4DAB; color: white; border-color: #8B4DAB; box-shadow: 0 3px 8px rgba(139,77,171,0.3); text-decoration: none; }

    .btn-view-all {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 6px 14px; border-radius: 8px;
        border: 1.5px solid #C8A2C8; background: white; color: #7A4F85;
        font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: all 0.2s ease;
    }
    .btn-view-all:hover { background: #8B4DAB; color: white; border-color: #8B4DAB; box-shadow: 0 3px 12px rgba(139,77,171,0.25); text-decoration: none; }

    .empty-state { padding: 48px 24px; text-align: center; color: #B0A0BC; }
    .empty-state i { font-size: 2.5rem; margin-bottom: 12px; opacity: 0.35; display: block; }
    .empty-state p { font-size: 0.88rem; }

    /* ── Staggered fade-in ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fade-in { animation: fadeUp 0.4s ease both; }
    .fade-in-1 { animation-delay: 0.05s; }
    .fade-in-2 { animation-delay: 0.10s; }
    .fade-in-3 { animation-delay: 0.15s; }
    .fade-in-4 { animation-delay: 0.20s; }
    .fade-in-5 { animation-delay: 0.25s; }
    .fade-in-6 { animation-delay: 0.30s; }
    .fade-in-7 { animation-delay: 0.35s; }
    .fade-in-8 { animation-delay: 0.40s; }
</style>

<div class="dashboard-main">
    <div class="dashboard-container">

        <!-- ── Header ── -->
        <div class="dashboard-header fade-in">
            <h1><i class="fas fa-chart-line header-icon"></i>Admin Dashboard</h1>
            <p>Welcome back, <strong style="color:white;">{{ auth()->user()->name }}</strong> — here's your system overview</p>
        </div>

        <!-- ── Section: Snapshot ── -->
        <div class="section-label fade-in fade-in-1">Snapshot</div>
        <div class="metric-grid mb-4">
            <div class="metric-card metric-card--1 fade-in fade-in-2">
                <div class="metric-icon"><i class="fas fa-peso-sign"></i></div>
                <div class="metric-label">Total Revenue</div>
                <div class="metric-value">₱{{ number_format($totalRevenue, 0) }}</div>
                <div class="metric-sub">From completed orders</div>
            </div>
            <div class="metric-card metric-card--2 fade-in fade-in-3">
                <div class="metric-icon"><i class="fas fa-shopping-bag"></i></div>
                <div class="metric-label">Total Orders</div>
                <div class="metric-value">{{ $totalOrders }}</div>
                <div class="metric-sub">All-time orders</div>
            </div>
            <div class="metric-card metric-card--3 fade-in fade-in-4">
                <div class="metric-icon"><i class="fas fa-pills"></i></div>
                <div class="metric-label">Total Products</div>
                <div class="metric-value">{{ $totalProducts }}</div>
                <div class="metric-sub">In inventory</div>
            </div>
            <div class="metric-card metric-card--4 fade-in fade-in-5">
                <div class="metric-icon"><i class="fas fa-users"></i></div>
                <div class="metric-label">Total Users</div>
                <div class="metric-value">{{ $totalUsers }}</div>
                <div class="metric-sub">Registered customers</div>
            </div>
        </div>

        <!-- ── Section: Analytics ── -->
        <div class="section-label fade-in fade-in-2">Analytics</div>
        <div class="metric-grid mb-4">
            <div class="metric-card metric-card--5 fade-in fade-in-3">
                <div class="metric-icon"><i class="fas fa-chart-line"></i></div>
                <div class="metric-label">Total Sales</div>
                <div class="metric-value" style="font-size:1.6rem;">₱{{ number_format($totalSales ?? $totalRevenue, 0) }}</div>
                <div class="metric-sub">From completed orders</div>
            </div>
            <div class="metric-card metric-card--6 fade-in fade-in-4">
                <div class="metric-icon"><i class="fas fa-check-circle"></i></div>
                <div class="metric-label">Completed Orders</div>
                <div class="metric-value" style="font-size:1.6rem;">{{ $completedOrders ?? $totalOrders }}</div>
                <div class="metric-sub">Successfully fulfilled</div>
            </div>
            <div class="metric-card metric-card--7 fade-in fade-in-5">
                <div class="metric-icon"><i class="fas fa-box"></i></div>
                <div class="metric-label">Items Sold</div>
                <div class="metric-value" style="font-size:1.6rem;">{{ $totalItemsSold ?? '—' }}</div>
                <div class="metric-sub">Total units dispatched</div>
            </div>
            <div class="metric-card metric-card--8 fade-in fade-in-6">
                <div class="metric-icon"><i class="fas fa-exclamation-triangle"></i></div>
                <div class="metric-label">Low Stock</div>
                <div class="metric-value" style="font-size:1.6rem;">{{ $lowStockProducts }}</div>
                <div class="metric-sub">Products need restocking</div>
            </div>
        </div>

        <x-low-stock-alert :count="$lowStockProducts" />

        <!-- ── Revenue Chart + Top Products side-by-side ── -->
        <div class="section-label fade-in fade-in-3">Performance</div>
        <div class="two-col fade-in fade-in-4">

            <!-- Revenue Chart -->
            <div class="card-modern">
                <div class="card-modern-header">
                    <div class="card-modern-header-left">
                        <div class="card-modern-header-icon">
                            <i class="fas fa-chart-area"></i>
                        </div>
                        <div>
                            <h5>Revenue Overview</h5>
                            <p>Completed orders over time</p>
                        </div>
                    </div>
                    <div class="period-toggle">
                        <button class="period-btn" onclick="switchPeriod('weekly', this)">Weekly</button>
                        <button class="period-btn active" onclick="switchPeriod('monthly', this)">Monthly</button>
                        <button class="period-btn" onclick="switchPeriod('yearly', this)">Yearly</button>
                    </div>
                </div>
                <div class="chart-body">
                    <div class="chart-wrap">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Products -->
            <div class="card-modern">
                <div class="card-modern-header">
                    <div class="card-modern-header-left">
                        <div class="card-modern-header-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div>
                            <h5>Top Products</h5>
                            <p>Best-selling items this period</p>
                        </div>
                    </div>
                    <span class="count-badge">{{ count($topProducts ?? []) }} items</span>
                </div>

                <div class="top-products-list">
                    @forelse($topProducts ?? [] as $i => $product)
                        @php
                            $pct = ($totalSales ?? $totalRevenue) > 0
                                ? round(($product['revenue'] / ($totalSales ?? $totalRevenue)) * 100, 1)
                                : 0;
                            $rankClass = match($i) { 0 => 'r1', 1 => 'r2', 2 => 'r3', default => 'rn' };
                        @endphp
                        <div class="top-product-row">
                            <span class="rank-badge {{ $rankClass }}">{{ $i + 1 }}</span>
                            <span class="top-product-name" title="{{ $product['product_name'] }}">{{ $product['product_name'] }}</span>
                            <span class="top-product-units">{{ $product['units_sold'] }} units</span>
                            <div class="progress-wrap">
                                <div class="progress-bar-bg">
                                    <div class="progress-bar-fill" style="width:{{ min($pct * 2, 100) }}%"></div>
                                </div>
                            </div>
                            <span class="top-product-pct">{{ $pct }}%</span>
                            <span class="top-product-revenue">₱{{ number_format($product['revenue'], 0) }}</span>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>No sales data available yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- ── Recent Orders ── -->
        <div class="section-label fade-in fade-in-5">Recent Activity</div>
        <div class="card-modern fade-in fade-in-6">
            <div class="card-modern-header">
                <div class="card-modern-header-left">
                    <div class="card-modern-header-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div>
                        <h5>Recent Orders</h5>
                        <p>Latest {{ $recentOrders->count() }} transactions</p>
                    </div>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="btn-view-all">
                    View All <i class="fas fa-arrow-right"></i>
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
                                <td><span class="order-id-pill">#{{ str_pad($order->order_id, 6, '0', STR_PAD_LEFT) }}</span></td>
                                <td>
                                    <div class="customer-cell">
                                        <div class="customer-avatar">{{ strtoupper(substr($order->user->name ?? '?', 0, 1)) }}</div>
                                        <span class="customer-name">{{ $order->user->name ?? '—' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="date-cell">
                                        {{ $order->date_ordered->format('M d, Y') }}
                                        <span class="date-time">{{ $order->date_ordered->format('H:i') }}</span>
                                    </span>
                                </td>
                                <td class="amount-cell">₱{{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span class="payment-chip">
                                        <i class="fas fa-{{ $order->payment_method === 'cash' ? 'money-bill' : 'credit-card' }}"></i>
                                        {{ ucfirst($order->payment_method) }}
                                    </span>
                                </td>
                                <td>
                                    @php $s = $order->order_status; @endphp
                                    <span class="status-badge {{ $s === 'completed' ? 'status-completed' : ($s === 'pending' ? 'status-pending' : 'status-other') }}">
                                        <span class="dot"></span>
                                        {{ ucfirst($s) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn-view" title="View Order">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p>No recent orders yet</p>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const chartData = {
    monthly: <?php echo json_encode($revenueChart['monthly'] ?? []); ?>,
    weekly:  <?php echo json_encode($revenueChart['weekly']  ?? []); ?>,
    yearly:  <?php echo json_encode($revenueChart['yearly']  ?? []); ?>,
};

function buildDataset(entries) {
    return {
        labels: entries.map(e => e.label),
        values: entries.map(e => parseFloat(e.revenue ?? 0)),
    };
}

const ctx = document.getElementById('revenueChart').getContext('2d');
const gradient = ctx.createLinearGradient(0, 0, 0, 260);
gradient.addColorStop(0, 'rgba(139, 77, 171, 0.20)');
gradient.addColorStop(1, 'rgba(139, 77, 171, 0.00)');

const initial = buildDataset(chartData.monthly);

const revenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: initial.labels,
        datasets: [{
            label: 'Revenue (₱)',
            data: initial.values,
            borderColor: '#8B4DAB',
            borderWidth: 2.5,
            pointBackgroundColor: '#8B4DAB',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
            fill: true,
            backgroundColor: gradient,
            tension: 0.4,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#3D2549',
                titleColor: 'rgba(255,255,255,0.65)',
                bodyColor: '#fff',
                borderColor: '#8B4DAB',
                borderWidth: 1,
                padding: 12,
                cornerRadius: 8,
                callbacks: {
                    label: ctx => '  ₱' + ctx.parsed.y.toLocaleString('en-PH', { minimumFractionDigits: 2 })
                }
            }
        },
        scales: {
            x: {
                grid: { display: false },
                ticks: { color: '#9B7BAB', font: { size: 11, weight: '600' } },
                border: { display: false },
            },
            y: {
                grid: { color: '#F0E8FA' },
                ticks: {
                    color: '#9B7BAB',
                    font: { size: 11 },
                    callback: v => '₱' + (v >= 1000 ? (v / 1000).toFixed(0) + 'k' : v),
                },
                border: { display: false },
                beginAtZero: true,
            }
        }
    }
});

let currentPeriod = 'monthly';

function switchPeriod(period, btn) {
    if (currentPeriod === period) return;
    currentPeriod = period;
    document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const { labels, values } = buildDataset(chartData[period] ?? []);
    revenueChart.data.labels = labels;
    revenueChart.data.datasets[0].data = values;
    revenueChart.update('active');
}
</script>
@endpush

@endsection