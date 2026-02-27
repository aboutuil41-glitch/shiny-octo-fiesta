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

    <style>
        /* ── Design tokens ───────────────────────────────────── */
        :root {
            --bg:          #0e0f11;
            --bg-2:        #141518;
            --bg-3:        #1b1d21;
            --bg-4:        #222428;
            --border:      #2a2d33;
            --border-2:    #353840;
            --text:        #f0f0f2;
            --text-2:      #9a9da6;
            --text-3:      #5c6070;
            --accent:      #f5a623;
            --accent-2:    #e8943a;
            --accent-dim:  #f5a62322;
            --danger:      #ef4444;
            --success:     #22c55e;
            --radius:      12px;
            --radius-sm:   7px;
            --font-display:'Syne', sans-serif;
            --font-mono:   'Space Mono', monospace;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            background: var(--bg);
            color: var(--text);
            font-family: var(--font-display);
            -webkit-font-smoothing: antialiased;
        }

        /* ── Auth shell ──────────────────────────────────────── */
        .auth-shell {
            min-height: 100vh;
            display: flex;
        }

        /* ── Left decorative panel ───────────────────────────── */
        .auth-panel-left {
            flex: 1;
            background: var(--bg-2);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        /* Radial glow */
        .auth-panel-left::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(245,166,35,.07) 0%, transparent 65%);
            pointer-events: none;
        }

        .auth-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 17px;
            letter-spacing: -.2px;
            color: var(--text);
            position: relative;
            z-index: 1;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: var(--accent);
            color: #000;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
        }

        .auth-tagline {
            position: relative;
            z-index: 1;
        }

        .auth-tagline p {
            font-size: clamp(28px, 4vw, 42px);
            font-weight: 800;
            letter-spacing: -1.5px;
            line-height: 1.15;
            color: var(--text);
            opacity: .12;
        }

        .auth-decoration {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .deco-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(var(--border) 1px, transparent 1px),
                linear-gradient(90deg, var(--border) 1px, transparent 1px);
            background-size: 40px 40px;
            opacity: .3;
            mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 0%, transparent 100%);
        }

        @media (max-width: 768px) {
            .auth-panel-left { display: none; }
        }

        /* ── Right form panel ────────────────────────────────── */
        .auth-panel-right {
            width: 480px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 48px;
            flex-shrink: 0;
        }

        @media (max-width: 768px) {
            .auth-panel-right {
                width: 100%;
                padding: 32px 24px;
            }
        }

        /* ── Auth card ───────────────────────────────────────── */
        .auth-card {
            width: 100%;
        }

        /* ── Breeze component overrides ──────────────────────── */

        /* Labels */
        label,
        .block.font-medium.text-sm.text-gray-700 {
            display: block;
            font-size: 10.5px !important;
            font-weight: 700 !important;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-3) !important;
            margin-bottom: 6px;
        }

        /* Inputs */
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            background: var(--bg-3) !important;
            border: 1px solid var(--border-2) !important;
            border-radius: var(--radius-sm) !important;
            color: var(--text) !important;
            font-family: var(--font-mono) !important;
            font-size: 13px !important;
            padding: 10px 12px !important;
            outline: none !important;
            box-shadow: none !important;
            transition: border-color .15s, box-shadow .15s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 3px var(--accent-dim) !important;
        }

        input::placeholder { color: var(--text-3) !important; }

        /* Checkbox */
        input[type="checkbox"] {
            accent-color: var(--accent);
            width: 14px;
            height: 14px;
            border-radius: 3px !important;
        }

        /* Errors */
        .text-sm.text-red-600,
        .text-sm.text-red-600.dark\:text-red-400 {
            font-size: 11px !important;
            color: var(--danger) !important;
            font-family: var(--font-mono) !important;
            margin-top: 4px;
        }

        /* Links */
        a.underline, a.underline.text-sm {
            color: var(--text-3) !important;
            font-size: 12px !important;
            text-decoration: none !important;
            transition: color .15s;
        }

        a.underline:hover { color: var(--accent) !important; }

        /* Primary button */
        button[type="submit"],
        .primary-btn,
        .inline-flex.items-center.px-4.py-2.bg-gray-800 {
            background: var(--accent) !important;
            color: #000 !important;
            border: none !important;
            border-radius: var(--radius-sm) !important;
            font-family: var(--font-display) !important;
            font-size: 13.5px !important;
            font-weight: 700 !important;
            padding: 10px 22px !important;
            cursor: pointer;
            transition: background .15s, transform .1s !important;
            box-shadow: none !important;
            letter-spacing: 0 !important;
        }

        button[type="submit"]:hover,
        .inline-flex.items-center.px-4.py-2.bg-gray-800:hover {
            background: var(--accent-2) !important;
            transform: translateY(-1px);
        }

        /* Remember me label */
        span.ms-2.text-sm {
            color: var(--text-3) !important;
            font-size: 12px !important;
        }

        /* Session status */
        .text-sm.font-medium.text-green-600 {
            color: var(--success) !important;
            font-size: 12px !important;
            font-family: var(--font-mono) !important;
        }

        /* Spacing utilities pass-through */
        .mt-4 { margin-top: 1rem; }
        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .ms-4 { margin-left: 1rem; }
        .ms-3 { margin-left: 0.75rem; }
        .ms-2 { margin-left: 0.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .block { display: block; }
        .w-full { width: 100%; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-end { justify-content: flex-end; }
        .inline-flex { display: inline-flex; }
        .rounded-md { border-radius: var(--radius-sm); }
        .focus\:outline-none:focus { outline: none; }
    </style>
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