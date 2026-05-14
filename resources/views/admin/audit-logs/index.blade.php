@extends('layouts.admin')

@section('title', 'Audit Logs - Lavender Pharmacy')

@section('content')
    <header class="mb-8 border-b border-border pb-4">
        <h1 class="font-serif text-2xl font-bold text-foreground">Audit logs</h1>
        <p class="mt-1 text-sm text-muted-foreground">System activity trail.</p>
    </header>

    <div class="overflow-hidden rounded-xl border border-border bg-card shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-border text-sm">
                <thead class="bg-secondary/50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">When</th>
                        <th class="px-4 py-3 text-left font-semibold">User</th>
                        <th class="px-4 py-3 text-left font-semibold">Action</th>
                        <th class="px-4 py-3 text-left font-semibold">Table</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse ($logs as $log)
                        <tr>
                            <td class="px-4 py-3 text-muted-foreground">{{ $log->date_logged?->format('M d, Y H:i') }}</td>
                            <td class="px-4 py-3">{{ $log->user->name ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $log->action_performed }}</td>
                            <td class="px-4 py-3 font-mono text-xs">{{ $log->table_name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-muted-foreground">No audit entries.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-border px-4 py-3">{{ $logs->links() }}</div>
    </div>
@endsection
