<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PolCaBot')</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @stack('styles')
</head>
<body class="light-mode">
    @yield('content')
    
    <!-- Scripts -->
    <script src="{{ asset('js/navigation.js') }}"></script>
    <script src="{{ asset('js/darkmode.js') }}"></script>
    @stack('scripts')
</body>
</html>