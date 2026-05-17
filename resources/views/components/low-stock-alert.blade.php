@props([
    'count' => 0,
    'detailsUrl' => null,
    'threshold' => 10,
])

@php
    $detailsUrl ??= match (auth()->user()->role ?? null) {
        'admin' => route('admin.products.index', ['stock' => 'low']),
        'editor' => route('editor.products.index', ['stock' => 'low']),
        default => '#',
    };
@endphp

@if ($count > 0)
    <div
        data-low-stock-alert
        {{ $attributes->class('mb-6 flex items-start gap-3 rounded-[10px] border-0 border-l-4 border-amber-500 bg-[#fffbeb] px-4 py-3 shadow-[0_2px_8px_rgba(0,0,0,0.06)]') }}
        role="alert"
    >
        <i class="fas fa-exclamation-triangle mt-0.5 shrink-0 text-amber-600" aria-hidden="true"></i>
        <div class="min-w-0 flex-1">
            <strong>Low Stock Alert!</strong>
            You have <strong>{{ $count }}</strong> product(s) with fewer than {{ $threshold }} units remaining.
            <a href="{{ $detailsUrl }}" class="low-stock-alert__link ms-1">View details →</a>
        </div>
        <button
            type="button"
            class="low-stock-alert__dismiss ms-1 shrink-0 rounded-md p-1 transition"
            aria-label="Dismiss alert"
            onclick="this.closest('[data-low-stock-alert]').remove()"
        >
            <i class="fas fa-times text-sm" aria-hidden="true"></i>
        </button>
    </div>
@endif
