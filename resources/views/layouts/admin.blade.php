<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#B57EDC">
    <title>@yield('title', 'Admin - Lavender Pharmacy')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen bg-muted/30 font-sans text-foreground antialiased">
    <x-admin-sidebar />
    <div class="ml-64 min-h-screen">
        @if (session('success'))
            <div class="border-b border-primary/20 bg-primary/10 px-6 py-3 text-sm text-foreground">{{ session('success') }}</div>
        @endif
        <div class="p-6">
            @yield('content')
        </div>
    </div>
    @stack('scripts')
</body>
</html>
