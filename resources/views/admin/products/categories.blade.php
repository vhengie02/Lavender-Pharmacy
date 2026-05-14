@extends('layouts.admin')

@section('title', 'Categories - Admin')

@section('content')
    <header class="mb-8 border-b border-border pb-4">
        <h1 class="font-serif text-2xl font-bold text-foreground">Categories</h1>
        <p class="mt-1 text-sm text-muted-foreground">Product counts per category.</p>
    </header>

    <div class="overflow-hidden rounded-xl border border-border bg-card shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-border text-sm">
                <thead class="bg-secondary/50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Name</th>
                        <th class="px-4 py-3 text-right font-semibold">Products</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach ($categories as $category)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $category->category_name }}</td>
                            <td class="px-4 py-3 text-right">{{ $category->products_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="border-t border-border px-4 py-3">{{ $categories->links() }}</div>
    </div>
@endsection
