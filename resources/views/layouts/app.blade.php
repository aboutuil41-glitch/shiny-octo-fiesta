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
            --sidebar-w:   230px;
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

        /* ── Shell ───────────────────────────────────────────── */
        .app-shell {
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ─────────────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--bg-2);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 50;
            transition: transform .25s ease;
        }

        .sidebar-logo {
            padding: 0 20px;
            height: 60px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }

        .logo-link {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            font-weight: 800;
            font-size: 16px;
            color: var(--text);
            letter-spacing: -.2px;
        }

        .logo-icon {
            width: 30px;
            height: 30px;
            background: var(--accent);
            color: #000;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            flex-shrink: 0;
        }

        /* ── Sidebar nav ─────────────────────────────────────── */
        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 2px;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-3);
            padding: 0 8px;
            margin-bottom: 6px;
            margin-top: 4px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-2);
            text-decoration: none;
            transition: background .12s, color .12s;
            position: relative;
        }

        .nav-item:hover {
            background: var(--bg-3);
            color: var(--text);
        }

        .nav-item.active {
            background: var(--accent-dim);
            color: var(--accent);
        }

        .nav-icon {
            font-size: 13px;
            width: 16px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-pip {
            position: absolute;
            right: 10px;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--accent);
        }

        /* ── Sidebar user block ──────────────────────────────── */
        .sidebar-user {
            border-top: 1px solid var(--border);
            padding: 12px;
            position: relative;
            flex-shrink: 0;
        }

        .user-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px 10px;
            border-radius: var(--radius-sm);
            transition: background .12s;
            color: var(--text);
        }

        .user-trigger:hover { background: var(--bg-3); }

        .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: calc(var(--radius-sm) - 1px);
            background: var(--accent-dim);
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
            flex-shrink: 0;
        }

        .user-info {
            flex: 1;
            min-width: 0;
            text-align: left;
        }

        .user-name {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            display: block;
            font-size: 10.5px;
            color: var(--text-3);
            font-family: var(--font-mono);
        }

        .user-caret {
            font-size: 10px;
            color: var(--text-3);
            transition: transform .2s;
        }

        .user-dropdown {
            position: absolute;
            bottom: calc(100% + 4px);
            left: 12px;
            right: 12px;
            background: var(--bg-3);
            border: 1px solid var(--border-2);
            border-radius: var(--radius-sm);
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,.4);
            z-index: 60;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-2);
            text-decoration: none;
            transition: background .12s, color .12s;
            background: none;
            border: none;
            cursor: pointer;
            width: 100%;
            font-family: var(--font-display);
        }

        .dropdown-item:hover { background: var(--bg-4); color: var(--text); }
        .dropdown-item.danger { color: var(--danger); }
        .dropdown-item.danger:hover { background: rgba(239,68,68,.08); }

        .dropdown-item i { width: 14px; text-align: center; font-size: 12px; }

        .dropdown-divider {
            height: 1px;
            background: var(--border);
            margin: 4px 0;
        }

        /* ── Mobile sidebar toggle ───────────────────────────── */
        .mobile-toggle {
            position: fixed;
            top: 14px;
            left: 14px;
            z-index: 100;
            width: 36px;
            height: 36px;
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text);
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 13px;
        }

        @media (max-width: 768px) {
            .mobile-toggle { display: flex; }
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
        }

        /* ── Main content area ───────────────────────────────── */
        .main-content {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        @media (max-width: 768px) {
            .main-content { margin-left: 0; }
        }

        /* ── Page header ─────────────────────────────────────── */
        .page-header {
            border-bottom: 1px solid var(--border);
            background: var(--bg-2);
            padding: 0 32px;
            height: 64px;
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        .page-header-inner {
            width: 100%;
        }

        .page-title-block {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .page-title {
            font-size: 17px;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -.3px;
        }

        .page-subtitle {
            font-size: 11.5px;
            color: var(--text-3);
            font-family: var(--font-mono);
        }

        /* ── Page main ───────────────────────────────────────── */
        .page-main {
            padding: 28px 32px;
            flex: 1;
        }

        @media (max-width: 640px) {
            .page-header { padding: 0 20px; }
            .page-main   { padding: 20px; }
        }

        /* ── Shared input / select / textarea styles ─────────── */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            background: var(--bg-3);
            border: 1px solid var(--border-2);
            border-radius: var(--radius-sm);
            color: var(--text);
            font-family: var(--font-mono);
            font-size: 13px;
            padding: 10px 12px;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
            -webkit-appearance: none;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-dim);
        }

        input::placeholder,
        textarea::placeholder { color: var(--text-3); }

        textarea { resize: vertical; min-height: 90px; }

        select option { background: var(--bg-3); color: var(--text); }

        /* ── Tabs (dashboard) ────────────────────────────────── */
        .dash-tabs {
            display: flex;
            gap: 4px;
            padding: 0 0 20px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 24px;
        }

        .dash-tab {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            font-family: var(--font-display);
            background: none;
            border: 1px solid transparent;
            color: var(--text-3);
            cursor: pointer;
            transition: background .12s, color .12s, border-color .12s;
        }

        .dash-tab:hover { background: var(--bg-3); color: var(--text-2); }

        .dash-tab.active {
            background: var(--accent-dim);
            color: var(--accent);
            border-color: rgba(245,166,35,.2);
        }

        /* ── Dashboard stat grid ─────────────────────────────── */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 14px;
        }

        .stat-card {
            animation: statIn .4s cubic-bezier(.16,1,.3,1) both;
            animation-delay: calc(var(--i, 0) * 0.07s);
        }

        @keyframes statIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .stat-card-inner {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            position: relative;
            overflow: hidden;
            transition: border-color .18s, transform .18s;
        }

        .stat-card-inner:hover {
            border-color: var(--border-2);
            transform: translateY(-2px);
        }

        .stat-card-inner::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent), var(--accent-2));
        }

        .stat-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.3px;
            text-transform: uppercase;
            color: var(--text-3);
            margin-bottom: 10px;
        }

        .stat-value {
            font-family: var(--font-mono);
            font-size: 2rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -1px;
            line-height: 1;
        }

        .stat-icon {
            position: absolute;
            bottom: 16px;
            right: 16px;
            font-size: 22px;
            color: var(--accent);
            opacity: .12;
        }

        /* ── Users table ─────────────────────────────────────── */
        .users-table-wrap {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            animation: statIn .4s cubic-bezier(.16,1,.3,1) both;
        }

        .users-table {
            width: 100%;
            border-collapse: collapse;
        }

        .users-table th {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: var(--text-3);
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            background: var(--bg-3);
        }

        .users-table td {
            padding: 12px 16px;
            font-size: 13px;
            color: var(--text-2);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .users-table tbody tr:last-child td { border-bottom: none; }
        .users-table tbody tr { transition: background .12s; }
        .users-table tbody tr:hover td { background: var(--bg-3); }
        .users-table tbody tr.row-banned td { opacity: .55; }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .user-avatar-sm {
            width: 28px;
            height: 28px;
            border-radius: calc(var(--radius-sm) - 2px);
            background: var(--accent-dim);
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            flex-shrink: 0;
        }

        .td-name { color: var(--text); font-weight: 600; }
        .td-email { color: var(--text-3); font-family: var(--font-mono); font-size: 12px; }
        .td-date { font-family: var(--font-mono); font-size: 12px; color: var(--text-3); }
        .td-empty { text-align: center; padding: 40px; color: var(--text-3); font-size: 13px; }
        .td-empty i { display: block; font-size: 24px; margin-bottom: 8px; opacity: .25; }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-active  { background: rgba(34,197,94,.1);  color: var(--success); }
        .badge-banned  { background: rgba(239,68,68,.1);  color: var(--danger); }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 600;
            font-family: var(--font-display);
            border: 1px solid transparent;
            cursor: pointer;
            transition: background .12s, transform .1s;
        }

        .action-btn:hover { transform: translateY(-1px); }

        .btn-ban   { background: rgba(239,68,68,.1); color: var(--danger);   border-color: rgba(239,68,68,.2); }
        .btn-unban { background: rgba(34,197,94,.1); color: var(--success);  border-color: rgba(34,197,94,.2); }
        .btn-ban:hover   { background: rgba(239,68,68,.2); }
        .btn-unban:hover { background: rgba(34,197,94,.2); }

        /* ── Accommodation form ───────────────────────────────── */
        .form-wrap {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 8px 0;
        }

        .form-card {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            width: 100%;
            max-width: 520px;
            overflow: hidden;
            animation: statIn .4s cubic-bezier(.16,1,.3,1) both;
        }

        .form-card::before {
            content: '';
            display: block;
            height: 2px;
            background: linear-gradient(90deg, var(--accent), var(--accent-2));
        }

        .form-top {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
        }

        .form-top-icon {
            width: 42px;
            height: 42px;
            border-radius: var(--radius-sm);
            background: var(--accent-dim);
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .form-top-text h2 {
            font-size: 16px;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -.2px;
        }

        .form-top-text p {
            font-size: 12px;
            color: var(--text-3);
            font-family: var(--font-mono);
            margin-top: 2px;
        }

        .form-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .field label {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-3);
        }

        .err-msg {
            font-size: 11px;
            color: var(--danger);
            font-family: var(--font-mono);
        }

        .form-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 4px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            font-weight: 700;
            font-family: var(--font-display);
            border: 1px solid transparent;
            cursor: pointer;
            transition: background .15s, transform .1s;
        }

        .btn:hover { transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }

        .btn-primary { background: var(--accent); color: #000; }
        .btn-primary:hover { background: var(--accent-2); }
        .btn-ghost { background: var(--bg-3); color: var(--text-2); border-color: var(--border-2); }
        .btn-ghost:hover { background: var(--bg-4); color: var(--text); }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="app-shell">
        @include('layouts.navigation')

        <div class="main-content">
            @isset($header)
                <header class="page-header">
                    <div class="page-header-inner">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="page-main">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>