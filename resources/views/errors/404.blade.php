<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - One at a time</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg: #0a0a0a;
            --red: #ff2d2d;
            --dim: #1a1a1a;
            --muted: #444;
            --text: #f0f0f0;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Mono', monospace;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Noise grain overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 10;
            opacity: 0.4;
        }

        /* Big decorative 404 behind everything */
        .bg-number {
            position: fixed;
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(200px, 40vw, 500px);
            color: var(--dim);
            line-height: 1;
            user-select: none;
            letter-spacing: -10px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
            animation: flicker 6s infinite;
        }

        @keyframes flicker {
            0%, 95%, 100% { opacity: 1; }
            96%            { opacity: 0.4; }
            97%            { opacity: 1; }
            98%            { opacity: 0.2; }
            99%            { opacity: 1; }
        }

        .container {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 2rem;
        }

        .tag {
            display: inline-block;
            font-size: 0.7rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--red);
            border: 1px solid var(--red);
            padding: 4px 12px;
            margin-bottom: 2rem;
            animation: fadeUp 0.6s ease both;
        }

        .message {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(2.5rem, 8vw, 6rem);
            line-height: 1.05;
            letter-spacing: 0.02em;
            animation: fadeUp 0.6s 0.15s ease both;
        }

        .message span {
            color: var(--red);
            display: inline-block;
            animation: shake 0.4s 1s ease both;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25%       { transform: translateX(-6px) rotate(-1deg); }
            75%       { transform: translateX(6px) rotate(1deg); }
        }

        .sub {
            margin-top: 1.5rem;
            font-size: 0.75rem;
            letter-spacing: 0.15em;
            color: var(--muted);
            text-transform: uppercase;
            animation: fadeUp 0.6s 0.3s ease both;
        }

        .divider {
            width: 40px;
            height: 2px;
            background: var(--red);
            margin: 1.5rem auto;
            animation: expand 0.6s 0.45s ease both;
            transform-origin: left;
        }

        @keyframes expand {
            from { transform: scaleX(0); opacity: 0; }
            to   { transform: scaleX(1); opacity: 1; }
        }

        .back-btn {
            display: inline-block;
            margin-top: 2rem;
            font-family: 'DM Mono', monospace;
            font-size: 0.75rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--text);
            text-decoration: none;
            border: 1px solid var(--muted);
            padding: 10px 24px;
            transition: all 0.2s ease;
            animation: fadeUp 0.6s 0.5s ease both;
        }

        .back-btn:hover {
            border-color: var(--red);
            color: var(--red);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="bg-number">404</div>

    <div class="container">
        <div class="tag">Error 404</div>

        <div class="message">
            {{ $exception->getMessage() ?: 'Not Found' }}
        </div>

        <div class="divider"></div>

        <p class="sub">You can only be in one accommodation at a time.</p>

        <a href="{{ route('Home') }}" class="back-btn">← Go Home</a>
    </div>

</body>
</html>