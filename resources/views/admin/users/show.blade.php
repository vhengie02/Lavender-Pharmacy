@extends('layouts.admin')

@section('title', $user->name . ' - Users')

@section('content')
    <header class="mb-8 flex flex-wrap items-center justify-between gap-4 border-b border-border pb-4">
        <div>
            <h1 class="font-serif text-2xl font-bold text-foreground">{{ $user->name }}</h1>
            <p class="mt-1 text-sm text-muted-foreground">{{ $user->email }}</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-primary hover:underline">Back to users</a>
    </header>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
            <h2 class="font-semibold">Profile</h2>
            <dl class="mt-4 space-y-3 text-sm">
                <div><dt class="text-muted-foreground">Role</dt><dd class="font-medium capitalize">{{ $user->role }}</dd></div>
                <div><dt class="text-muted-foreground">Status</dt><dd class="font-medium capitalize">{{ $user->status }}</dd></div>
                <div><dt class="text-muted-foreground">Contact</dt><dd>{{ $user->contact_number ?? '—' }}</dd></div>
                <div><dt class="text-muted-foreground">Address</dt><dd>{{ $user->address ?? '—' }}</dd></div>
            </dl>
        </div>
        <div class="rounded-xl border border-border bg-card p-6 shadow-sm">
            <h2 class="font-semibold">Recent orders</h2>
            <ul class="mt-4 space-y-2 text-sm">
                @forelse ($user->orders->take(8) as $order)
                    <li class="flex justify-between border-b border-border py-2">
                        <span class="font-mono text-xs">#{{ $order->order_id }}</span>
                        <span class="text-muted-foreground">{{ $order->date_ordered?->format('M d, Y') }}</span>
                        <span class="font-medium">₱{{ number_format($order->total_amount, 2) }}</span>
                    </li>
                @empty
                    <li class="text-muted-foreground">No orders.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
