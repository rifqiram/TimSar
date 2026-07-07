<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'TimSar'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Global API Configuration -->
    <script>
        window.apiBase = window.location.origin + '{{ request()->getBaseUrl() }}/api';
    </script>
    
    <!-- Auth Service -->
    <script src="{{ asset('js/auth.js') }}"></script>
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50">
    <main>
        @yield('content')
    </main>
    
    @stack('scripts')
</body>
</html>
