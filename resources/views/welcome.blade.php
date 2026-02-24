<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'App') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=syne:400,500,600,700,800|space-mono:400,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        :root {
            --bg:     #0e0f11;
            --bg-2:   #141518;
            --border: #2a2d33;
            --text:   #f0f0f2;
            --text-2: #9a9da6;
            --text-3: #5c6070;
            --accent: #f5a623;
            --font-display: 'Syne', sans-serif;
            --font-mono: 'Space Mono', monospace;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body {
            height: 100%;
            background: var(--bg);
            color: var(--text);
            font-family: var(--font-display);
            -webkit-font-smoothing: antialiased;
        }

        /* Layout */
        .welcome-shell {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top bar */
        .welcome-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 48px;
            height: 64px;
            border-bottom: 1px solid var(--border);
        }
        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 18px;
            letter-spacing: -0.3px;
        }
        .brand-icon {
            width: 34px;
            height: 34px;
            background: var(--accent);
            color: #000;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .nav-link {
            padding: 8px 18px;
            border-radius: 6px;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
            color: var(--text-2);
        }
        .nav-link:hover { background: #1b1d21; color: var(--text); }
        .nav-link.primary {
            background: var(--accent);
            color: #000;
        }
        .nav-link.primary:hover { background: #e8943a; color: #000; }

        /* Hero */
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 80px 24px;
            position: relative;
            overflow: hidden;
        }
        .hero-bg {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 50% 0%, rgba(245,166,35,0.06) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(245,166,35,0.1);
            border: 1px solid rgba(245,166,35,0.25);
            border-radius: 99px;
            padding: 5px 14px;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 32px;
        }
        .hero-title {
            font-size: clamp(44px, 7vw, 88px);
            font-weight: 800;
            letter-spacing: -2.5px;
            line-height: 1.0;
            max-width: 800px;
            color: var(--text);
            margin-bottom: 24px;
        }
        .hero-title span { color: var(--accent); }
        .hero-desc {
            font-size: 17px;
            color: var(--text-3);
            max-width: 460px;
            line-height: 1.7;
            margin-bottom: 40px;
            font-family: var(--font-mono);
        }
        .hero-cta {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 28px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: transform 0.15s, opacity 0.15s;
            font-family: var(--font-display);
        }
        .cta-btn:hover { transform: translateY(-2px); opacity: 0.9; }
        .cta-btn.solid {
            background: var(--accent);
            color: #000;
        }
        .cta-btn.outline {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-2);
        }
        .cta-btn.outline:hover { border-color: #353840; color: var(--text); }

        /* Footer */
        .welcome-footer {
            padding: 20px 48px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            color: var(--text-3);
            font-family: var(--font-mono);
        }

        @media (max-width: 600px) {
            .welcome-nav { padding: 0 20px; }
            .welcome-footer { flex-direction: column; gap: 6px; text-align: center; }
        }
    </style>
</head>
<body>
    <div class="welcome-shell">
        <!-- Nav -->
        <nav class="welcome-nav">
            <div class="nav-brand">
                <div class="brand-icon"><i class="fa-solid fa-bolt"></i></div>
                {{ config('app.name', 'App') }}
            </div>
            <div class="nav-links">
                @auth
                    <a href="{{ route('dashboard') }}" class="nav-link primary">
                        <i class="fa-solid fa-gauge-high"></i>&nbsp; Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Sign in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-link primary">Get started</a>
                    @endif
                @endauth
            </div>
        </nav>

        <!-- Hero -->
        <section class="hero">
            <div class="hero-bg"></div>
            <div class="hero-eyebrow">
                <i class="fa-solid fa-bolt"></i>
                Laravel &mdash; Powered
            </div>
            <h1 class="hero-title">
                The stack that<br><span>ships fast.</span>
            </h1>
            <p class="hero-desc">A clean, opinionated starting point for your next Laravel project. No fluff, just results.</p>
            <div class="hero-cta">
                @auth
                    <a href="{{ route('dashboard') }}" class="cta-btn solid">
                        <i class="fa-solid fa-gauge-high"></i> Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="cta-btn solid">
                        <i class="fa-solid fa-arrow-right"></i> Get started free
                    </a>
                    <a href="{{ route('login') }}" class="cta-btn outline">
                        <i class="fa-solid fa-right-to-bracket"></i> Sign in
                    </a>
                @endauth
            </div>
        </section>

        <!-- Footer -->
        <footer class="welcome-footer">
            <span>Laravel v{{ Illuminate\Foundation\Application::VERSION }} &middot; PHP v{{ PHP_VERSION }}</span>
            <span>Built with <i class="fa-solid fa-heart" style="color: var(--accent);"></i></span>
        </footer>
    </div>
</body>
</html>