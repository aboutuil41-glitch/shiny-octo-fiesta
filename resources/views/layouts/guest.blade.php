<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'App') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=syne:400,500,600,700,800|space-mono:400,700&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="auth-shell">
        <!-- Left Panel -->
        <div class="auth-panel-left">
            <div class="auth-brand">
                <span class="logo-icon"><i class="fa-solid fa-bolt"></i></span>
                <span class="logo-text">{{ config('app.name', 'App') }}</span>
            </div>
            <div class="auth-tagline">
                <p>Built for people<br>who mean business.</p>
            </div>
            <div class="auth-decoration">
                <div class="deco-grid"></div>
            </div>
        </div>

        <!-- Right Panel / Form -->
        <div class="auth-panel-right">
            <div class="auth-card">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>