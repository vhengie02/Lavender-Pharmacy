@php
    $navMain = [
        ['label' => 'Dashboard', 'route' => 'editor.dashboard', 'active' => ['editor.dashboard'], 'icon' => 'fa-chart-line'],
        ['label' => 'Point of Sale', 'route' => 'editor.pos', 'active' => ['editor.pos'], 'icon' => 'fa-cash-register'],
        ['label' => 'Products', 'route' => 'editor.products.index', 'active' => ['editor.products.*'], 'icon' => 'fa-pills'],
    ];
    $navReports = [
        ['label' => 'Receipts', 'route' => 'editor.receipts', 'active' => ['editor.receipts'], 'icon' => 'fa-receipt'],
    ];
@endphp

<style>
    .admin-sidebar {
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
        width: 256px;
        background: #ffffff;
        border-right: 1px solid #E6E6FA;
        z-index: 40;
        display: flex;
        flex-direction: column;
        box-shadow: 4px 0 24px rgba(93, 58, 102, 0.08);
    }

    .sidebar-header {
        background: linear-gradient(145deg, #5D3A66 0%, #7A4F85 60%, #B57EDC 100%);
        color: white;
        padding: 22px 18px;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }

    .sidebar-header::after {
        content: '';
        position: absolute;
        bottom: -20px;
        right: -20px;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255,255,255,0.07);
        pointer-events: none;
    }

    .sidebar-brand span {
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: -0.3px;
        line-height: 1.2;
    }

    .sidebar-brand small {
        font-size: 0.7rem;
        opacity: 0.7;
        font-weight: 400;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .sidebar-nav {
        flex: 1;
        overflow-y: auto;
        padding: 16px 12px;
    }

    .nav-section-title {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #B57EDC;
        padding: 10px 14px 6px;
        margin: 0 0 4px 0;
        display: block;
    }

    .nav-section-title:not(:first-of-type) {
        margin-top: 8px;
    }

    .sidebar-divider {
        margin: 10px 0;
        border: none;
        border-top: 1px solid #F0E8FA;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 10px 14px;
        margin-bottom: 2px;
        border-radius: 8px;
        font-size: 0.88rem;
        font-weight: 500;
        transition: all 0.2s ease;
        color: #6B5B77;
        text-decoration: none;
        position: relative;
    }

    .nav-link i {
        font-size: 0.9rem;
        width: 18px;
        text-align: center;
        color: #C8A2C8;
        transition: color 0.2s ease;
        flex-shrink: 0;
    }

    .nav-link:hover {
        background-color: #F5EEFF;
        color: #5D3A66;
    }

    .nav-link:hover i {
        color: #8B4DAB;
    }

    .nav-link.active {
        background: linear-gradient(135deg, #8B4DAB 0%, #B57EDC 100%);
        color: white;
        font-weight: 600;
        box-shadow: 0 3px 10px rgba(139, 77, 171, 0.35);
    }

    .nav-link.active i {
        color: rgba(255,255,255,0.9);
    }

    .nav-link.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 20px;
        background: white;
        border-radius: 0 2px 2px 0;
        opacity: 0.8;
    }

    .quick-actions-block {
        padding: 12px;
        border-top: 1px solid #F0E8FA;
        flex-shrink: 0;
    }

    .quick-actions-title {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #B57EDC;
        padding: 4px 4px 8px;
        display: block;
    }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
    }

    .quick-action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 10px 6px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #7A5285;
        background: #F9F4FF;
        border: 1px solid #E8D8F5;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
        text-align: center;
        line-height: 1.2;
    }

    .quick-action-btn i {
        font-size: 1rem;
        color: #B57EDC;
        transition: color 0.2s ease;
    }

    .quick-action-btn:hover {
        background: #EFE0FF;
        border-color: #B57EDC;
        color: #5D3A66;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(181, 126, 220, 0.2);
        text-decoration: none;
    }

    .quick-action-btn:hover i {
        color: #7A4F85;
    }

    .sidebar-footer {
        border-top: 1px solid #F0E8FA;
        padding: 12px;
        background: #FDFAFF;
        flex-shrink: 0;
    }

    .logout-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        padding: 10px 16px;
        border: 1.5px solid #E8D0D0;
        background: white;
        color: #C0454F;
        border-radius: 8px;
        font-size: 0.88rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .logout-btn:hover {
        background: #dc3545;
        color: white;
        border-color: #dc3545;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.25);
    }

    .sidebar-user-chip {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        margin: 0 12px 8px;
        background: linear-gradient(135deg, #F9F4FF 0%, #EFE0FF 100%);
        border: 1px solid #E0C8F5;
        border-radius: 10px;
        flex-shrink: 0;
    }

    .user-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: linear-gradient(135deg, #8B4DAB, #C8A2C8);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
    }

    .user-info span {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #5D3A66;
        line-height: 1.2;
        max-width: 140px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-info small {
        font-size: 0.68rem;
        color: #A08AB0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sidebar-nav::-webkit-scrollbar { width: 4px; }
    .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
    .sidebar-nav::-webkit-scrollbar-thumb { background: #D4B5D4; border-radius: 2px; }
    .sidebar-nav::-webkit-scrollbar-thumb:hover { background: #B57EDC; }
</style>

<aside class="admin-sidebar">
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <span>Lavender Pharmacy</span>
            <small>Editor Panel</small>
        </div>
    </div>

    <div style="padding-top: 12px;">
        <div class="sidebar-user-chip">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="user-info">
                <span>{{ auth()->user()->name }}</span>
                <small>Editor</small>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <p class="nav-section-title">Main Menu</p>

        @foreach ($navMain as $item)
            @php($active = collect($item['active'])->contains(fn ($p) => request()->routeIs($p)))
            <a href="{{ route($item['route']) }}" class="nav-link {{ $active ? 'active' : '' }}">
                <i class="fas {{ $item['icon'] ?? 'fa-link' }}"></i>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach

        <div class="sidebar-divider"></div>

        <p class="nav-section-title">Reports</p>

        @foreach ($navReports as $item)
            @php($active = collect($item['active'])->contains(fn ($p) => request()->routeIs($p)))
            <a href="{{ route($item['route']) }}" class="nav-link {{ $active ? 'active' : '' }}">
                <i class="fas {{ $item['icon'] ?? 'fa-link' }}"></i>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="quick-actions-block">
        <span class="quick-actions-title">Quick Actions</span>
        <div class="quick-actions-grid">
            <a href="{{ route('shop') }}" class="quick-action-btn">
                <i class="fas fa-store"></i>
                <span>View Shop</span>
            </a>
            <a href="{{ route('profile.show') }}" class="quick-action-btn">
                <i class="fas fa-user-circle"></i>
                <span>My Profile</span>
            </a>
            <a href="{{ route('editor.settings') }}" class="quick-action-btn" style="grid-column: span 2;">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </div>
    </div>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Sign Out</span>
            </button>
        </form>
    </div>
</aside>
