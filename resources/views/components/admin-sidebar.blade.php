@php
    $navMain = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => ['admin.dashboard']],
        ['label' => 'Products', 'route' => 'admin.products.index', 'active' => ['admin.products.*', 'admin.products.categories']],
        ['label' => 'Orders', 'route' => 'admin.orders.index', 'active' => ['admin.orders.*']],
        ['label' => 'Inventory', 'route' => 'admin.inventory', 'active' => ['admin.inventory']],
        ['label' => 'Users', 'route' => 'admin.users.index', 'active' => ['admin.users.*']],
    ];
    $navReports = [
        ['label' => 'Sales Reports', 'route' => 'admin.reports.sales', 'active' => ['admin.reports.sales']],
        ['label' => 'Receipts', 'route' => 'admin.receipts', 'active' => ['admin.receipts']],
        ['label' => 'Audit Logs', 'route' => 'admin.audit-logs', 'active' => ['admin.audit-logs']],
    ];
@endphp
<aside class="fixed left-0 top-0 z-40 flex h-screen w-64 flex-col border-r border-border bg-card">
    <div class="border-b border-border p-6">
        <a href="{{ route('admin.dashboard') }}" class="inline-block">
            <x-storefront-logo class="h-8 w-auto" />
        </a>
    </div>
    <nav class="flex-1 space-y-1 overflow-y-auto p-4">
        <p class="mb-2 px-3 text-xs font-medium uppercase tracking-wider text-muted-foreground">Main Menu</p>
        @foreach ($navMain as $item)
            @php($active = collect($item['active'])->contains(fn ($p) => request()->routeIs($p)))
            <a href="{{ route($item['route']) }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ $active ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-muted hover:text-foreground' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
        <div class="my-4 border-t border-border"></div>
        <p class="mb-2 px-3 text-xs font-medium uppercase tracking-wider text-muted-foreground">Reports</p>
        @foreach ($navReports as $item)
            @php($active = collect($item['active'])->contains(fn ($p) => request()->routeIs($p)))
            <a href="{{ route($item['route']) }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ $active ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-muted hover:text-foreground' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
    <div class="space-y-1 border-t border-border p-4">
        <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.settings') ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-muted hover:text-foreground' }}">Settings</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left text-sm font-medium text-red-600 transition-colors hover:bg-red-50">Sign Out</button>
        </form>
    </div>
</aside>
