<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation — {{ $invitation->accommodation->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #0e0f11;
            --bg-2:      #141518;
            --bg-3:      #1b1d21;
            --bg-4:      #222428;
            --border:    #2a2d33;
            --border-2:  #353840;
            --text:      #f0f0f2;
            --text-2:    #9a9da6;
            --text-3:    #5c6070;
            --accent:    #f5a623;
            --accent-2:  #e8943a;
            --accent-dim:#f5a62322;
            --danger:    #ef4444;
            --success:   #22c55e;
            --radius:    12px;
            --radius-sm: 7px;
            --font:      'Syne', sans-serif;
            --mono:      'Space Mono', monospace;
        }

        html, body {
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
            font-family: var(--font);
            -webkit-font-smoothing: antialiased;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        /* ── Noise texture overlay ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        /* ── Glow orb ── */
        body::after {
            content: '';
            position: fixed;
            top: -200px;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(245,166,35,.07) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* ── Card ── */
        .inv-card {
            position: relative;
            z-index: 1;
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            width: 100%;
            max-width: 440px;
            overflow: hidden;
            animation: cardIn .5s cubic-bezier(.16,1,.3,1) both;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(20px) scale(.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* top accent bar */
        .inv-card::before {
            content: '';
            display: block;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent-2));
        }

        /* ── Header ── */
        .inv-header {
            padding: 32px 32px 24px;
            text-align: center;
            border-bottom: 1px solid var(--border);
        }

        .inv-icon-wrap {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: var(--accent-dim);
            border: 1px solid rgba(245,166,35,.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
            color: var(--accent);
            animation: iconPop .5s cubic-bezier(.16,1,.3,1) .15s both;
        }

        @keyframes iconPop {
            from { opacity: 0; transform: scale(.7); }
            to   { opacity: 1; transform: scale(1); }
        }

        .inv-eyebrow {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--accent);
            font-family: var(--mono);
            margin-bottom: 8px;
        }

        .inv-title {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -.4px;
            color: var(--text);
            margin-bottom: 6px;
        }

        .inv-subtitle {
            font-size: 13px;
            color: var(--text-3);
            font-family: var(--mono);
        }

        /* ── Body ── */
        .inv-body {
            padding: 24px 32px;
            border-bottom: 1px solid var(--border);
        }

        .inv-acc-row {
            display: flex;
            align-items: center;
            gap: 14px;
            background: var(--bg-3);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            margin-bottom: 20px;
        }

        .inv-acc-ico {
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

        .inv-acc-name {
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
        }

        .inv-acc-sub {
            font-size: 11.5px;
            color: var(--text-3);
            font-family: var(--mono);
            margin-top: 2px;
        }

        .inv-meta {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .inv-meta-row {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 12.5px;
            color: var(--text-3);
            font-family: var(--mono);
        }
        .inv-meta-row i {
            width: 14px;
            text-align: center;
            color: var(--accent);
            font-size: 11px;
            opacity: .7;
        }

        /* ── Actions ── */
        .inv-actions {
            padding: 20px 32px 28px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .inv-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 700;
            font-family: var(--font);
            border: none;
            cursor: pointer;
            transition: opacity .15s, transform .12s;
            text-decoration: none;
        }
        .inv-btn:hover  { opacity: .88; transform: translateY(-1px); }
        .inv-btn:active { transform: translateY(0); }

        .inv-btn-accept {
            background: var(--accent);
            color: #000;
        }

        .inv-btn-decline {
            background: var(--bg-3);
            color: var(--text-3);
            border: 1px solid var(--border-2);
        }
        .inv-btn-decline:hover { color: var(--danger); border-color: rgba(239,68,68,.3); background: rgba(239,68,68,.05); opacity: 1; }

        /* ── Expired / used state ── */
        .inv-dead {
            padding: 32px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
        .inv-dead-icon {
            font-size: 32px;
            color: var(--text-3);
            opacity: .3;
            margin-bottom: 4px;
        }
        .inv-dead-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-2);
        }
        .inv-dead-sub {
            font-size: 12px;
            color: var(--text-3);
            font-family: var(--mono);
        }
    </style>
</head>
<body>

    <div class="inv-card">

        <div class="inv-header">
            <div class="inv-icon-wrap">
                <i class="fa-solid fa-envelope-open-text"></i>
            </div>
            <p class="inv-eyebrow">You've been invited</p>
            <h1 class="inv-title">Join the accommodation</h1>
            <p class="inv-subtitle">Someone wants you in their space</p>
        </div>

        <div class="inv-body">
            <div class="inv-acc-row">
                <div class="inv-acc-ico">
                    <i class="fa-solid fa-house"></i>
                </div>
                <div>
                    <div class="inv-acc-name">{{ $invitation->accommodation->name }}</div>
                    @if($invitation->accommodation->description)
                        <div class="inv-acc-sub">{{ $invitation->accommodation->description }}</div>
                    @endif
                </div>
            </div>

            <div class="inv-meta">
                <div class="inv-meta-row">
                    <i class="fa-solid fa-user"></i>
                    Invited as <strong style="color:var(--text-2);margin-left:4px">member</strong>
                </div>
                <div class="inv-meta-row">
                    <i class="fa-solid fa-clock"></i>
                    Expires {{ $invitation->expires_at->diffForHumans() }}
                </div>
                <div class="inv-meta-row">
                    <i class="fa-solid fa-envelope"></i>
                    Sent to {{ $invitation->email }}
                </div>
            </div>
        </div>

        <div class="inv-actions">
            <form method="POST" action="{{ route('invitation.accept', $invitation->token) }}">
                @csrf
                <button type="submit" class="inv-btn inv-btn-accept" style="width:100%">
                    <i class="fa-solid fa-check"></i> Accept Invitation
                </button>
            </form>
            <form method="POST" action="{{ route('invitation.decline', $invitation->token) }}">
                @csrf
                <button type="submit" class="inv-btn inv-btn-decline" style="width:100%">
                    <i class="fa-solid fa-xmark"></i> Decline
                </button>
            </form>
        </div>

    </div>

</body>
</html>