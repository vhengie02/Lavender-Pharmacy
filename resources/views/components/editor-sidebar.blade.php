@php
    $items = [
        ['label' => 'Dashboard', 'route' => 'editor.dashboard', 'match' => ['editor.dashboard']],
        ['label' => 'Point of Sale', 'route' => 'editor.pos', 'match' => ['editor.pos']],
        ['label' => 'Receipts', 'route' => 'editor.receipts', 'match' => ['editor.receipts']],
        ['label' => 'Products', 'route' => 'editor.products.index', 'match' => ['editor.products.*']],
        ['label' => 'Reports', 'route' => 'editor.reports', 'match' => ['editor.reports']],
        ['label' => 'Settings', 'route' => 'editor.settings', 'match' => ['editor.settings']],
    ];
@endphp
<aside class="flex w-64 flex-col border-r border-border bg-card">
    <div class="flex h-16 items-center justify-between border-b border-border px-4">
        <a href="{{ route('editor.dashboard') }}" class="flex items-center gap-2">
            <x-storefront-logo class="h-8 w-8" />
            <span class="font-serif text-lg font-semibold text-primary">Editor</span>
        </a>
    </div>
    <nav class="flex-1 space-y-1 p-2">
        @foreach ($items as $item)
            @php($active = collect($item['match'])->contains(fn ($p) => request()->routeIs($p)))
            <a href="{{ route($item['route']) }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ $active ? 'bg-primary text-primary-foreground' : 'text-muted-foreground hover:bg-accent hover:text-foreground' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
    <div class="border-t border-border p-2">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-muted-foreground transition-colors hover:bg-destructive/10 hover:text-destructive">Logout</button>
        </form>
    </div>
</aside>
