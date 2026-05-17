<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#B57EDC">
    <title>@yield('title', 'Lavender Pharmacy')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen bg-background font-sans text-foreground antialiased">
    <x-storefront-nav />

    @if ($errors->any())
        <div class="fixed right-4 top-20 z-50 max-w-md rounded-lg border border-destructive/30 bg-destructive/10 px-4 py-3 text-sm text-destructive shadow-lg" role="alert">
            <p class="font-semibold">Please fix the following:</p>
            <ul class="mt-2 list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="fixed right-4 top-20 z-50 max-w-md rounded-lg border border-primary/30 bg-primary/10 px-4 py-3 text-sm text-foreground shadow-lg" role="status">
            {{ session('success') }}
        </div>
    @endif

    <main class="min-h-screen">
        @yield('content')
    </main>

    <x-storefront-footer />

    @stack('scripts')
</body>
</html>
