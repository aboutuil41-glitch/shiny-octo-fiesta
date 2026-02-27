<div>
    <x-slot name="header">
        <div class="page-title-block">
            <h1 class="page-title">Home</h1>
            <span class="page-subtitle">Welcome back, {{ Auth::user()->name }}</span>
        </div>
    </x-slot>

    @php
        $repTier = $reputation >= 40 ? 'Elite' : ($reputation >= 20 ? 'Trusted' : ($reputation >= 5 ? 'Active' : 'Newcomer'));
        $tierColor = match($repTier) {
            'Elite'   => 'var(--accent)',
            'Trusted' => 'var(--success)',
            'Active'  => 'var(--accent-2)',
            default   => 'var(--text-3)',
        };
        $repPct = min(round(($reputation / 50) * 100), 100);
    @endphp

    <style>
        .hg {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        @media (max-width: 700px) { .hg { grid-template-columns: 1fr; } }

        @keyframes hIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Room banner ─────────────────────────────────── */
        .room-banner {
            grid-column: 1 / 3;
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px 28px;
            display: flex;
            align-items: center;
            gap: 20px;
            animation: hIn .4s cubic-bezier(.16,1,.3,1) .04s both;
            text-decoration: none;
            color: inherit;
            transition: border-color .18s, transform .18s;
            position: relative;
            overflow: hidden;
        }
        .room-banner::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent), var(--accent-2));
        }
        .room-banner:hover { border-color: var(--border-2); transform: translateY(-2px); }
        .room-banner-ico {
            width: 52px; height: 52px;
            border-radius: var(--radius-sm);
            background: var(--accent-dim);
            color: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .room-banner-ico.none {
            background: var(--bg-3);
            color: var(--text-3);
        }
        .room-banner-info { flex: 1; min-width: 0; }
        .room-banner-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -.3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .room-banner-desc {
            font-size: 12.5px;
            color: var(--text-3);
            margin-top: 3px;
        }
        .room-banner-none {
            font-size: 14px;
            color: var(--text-3);
        }
        .room-banner-role {
            flex-shrink: 0;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 99px;
        }
        .room-banner-role.owner  { background: var(--accent-dim); color: var(--accent); }
        .room-banner-role.member { background: var(--bg-4); color: var(--text-3); border: 1px solid var(--border-2); }
        .room-banner-arrow {
            color: var(--accent);
            font-size: 14px;
            opacity: 0;
            transform: translateX(-4px);
            transition: opacity .18s, transform .18s;
            flex-shrink: 0;
        }
        .room-banner:hover .room-banner-arrow { opacity: 1; transform: translateX(0); }

        @media (max-width: 700px) { .room-banner { grid-column: 1; } }

        /* ── Stat cards ──────────────────────────────────── */
        .hstat {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px 24px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            animation: hIn .4s cubic-bezier(.16,1,.3,1) both;
        }
        .hstat:nth-child(2) { animation-delay: .09s; }
        .hstat:nth-child(3) { animation-delay: .14s; }

        .hstat-icon {
            width: 36px; height: 36px;
            border-radius: var(--radius-sm);
            background: var(--accent-dim); color: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
        }
        .hstat-label {
            font-size: 10.5px; font-weight: 700;
            letter-spacing: 1.3px; text-transform: uppercase;
            color: var(--text-3);
        }
        .hstat-value {
            font-family: var(--font-mono);
            font-size: 2rem; font-weight: 800;
            color: var(--text); letter-spacing: -1px; line-height: 1;
        }
        .hstat-value span {
            font-size: .95rem; font-weight: 400;
            color: var(--text-3); letter-spacing: 0; margin-left: 3px;
        }
        .hstat-sub { font-size: 11.5px; color: var(--text-3); font-family: var(--font-mono); }

        .rep-bar-track {
            height: 4px; border-radius: 99px;
            background: var(--bg-4); margin-top: 2px; overflow: hidden;
        }
        .rep-bar-fill {
            height: 100%; border-radius: 99px;
            background: linear-gradient(90deg, var(--accent), var(--accent-2));
            width: {{ $repPct }}%;
        }
        .rep-tier {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 2px 10px; border-radius: 99px;
            font-size: 10px; font-weight: 700;
            letter-spacing: .06em; text-transform: uppercase;
            border: 1px solid currentColor; width: fit-content;
        }

        /* ── History panel ───────────────────────────────── */
        .hpanel {
            grid-column: 1 / 3;
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            animation: hIn .4s cubic-bezier(.16,1,.3,1) .18s both;
        }
        @media (max-width: 700px) { .hpanel { grid-column: 1; } }

        .hpanel-head {
            padding: 13px 20px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .hpanel-label {
            font-size: 10.5px; font-weight: 700;
            letter-spacing: 1.3px; text-transform: uppercase;
            color: var(--text-3);
            display: flex; align-items: center; gap: 7px;
        }
        .hpanel-label i { color: var(--accent); font-size: 11px; }

        .count-pill {
            background: var(--bg-4); color: var(--text-3);
            border: 1px solid var(--border); border-radius: 99px;
            font-size: 11px; font-weight: 600;
            font-family: var(--font-mono); padding: 2px 8px;
        }

        .hist-table { width: 100%; border-collapse: collapse; }
        .hist-table th {
            font-size: 10px; font-weight: 700; letter-spacing: 1.2px;
            text-transform: uppercase; color: var(--text-3);
            padding: 0 14px 10px; text-align: left;
            border-bottom: 1px solid var(--border);
        }
        .hist-table td {
            padding: 11px 14px; font-size: 13px;
            color: var(--text-2); border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }
        .hist-table tbody tr:last-child td { border-bottom: none; }
        .hist-table tbody tr { transition: background .12s; }
        .hist-table tbody tr:hover td { background: var(--bg-3); }
        .hist-title-cell { color: var(--text); font-weight: 500; }
        .hist-cat-badge {
            display: inline-flex; padding: 2px 8px;
            background: var(--accent-dim); color: var(--accent);
            border-radius: 5px; font-size: 11px; font-weight: 600;
        }
        .hist-date { font-family: var(--font-mono); font-size: 11.5px; color: var(--text-3); }
        .hist-amount { font-family: var(--font-mono); font-weight: 700; color: var(--success); text-align: right; white-space: nowrap; }
        .hist-empty {
            display: flex; flex-direction: column; align-items: center;
            gap: 8px; padding: 44px 0;
            color: var(--text-3); font-size: 13px;
        }
        .hist-empty i { font-size: 26px; opacity: .25; }
    </style>

    <div class="hg">

        {{-- ① Room banner --}}
        @if($accommodation)
            @php $role = $accommodation->pivot->role ?? 'member'; @endphp
            <a href="{{ route('view.Accommondation', $accommodation->id) }}" class="room-banner">
                <div class="room-banner-ico"><i class="fa-solid fa-house"></i></div>
                <div class="room-banner-info">
                    <div class="room-banner-name">{{ $accommodation->name }}</div>
                    @if($accommodation->description)
                        <div class="room-banner-desc">{{ $accommodation->description }}</div>
                    @endif
                </div>
                <span class="room-banner-role {{ $role }}">{{ $role }}</span>
                <i class="fa-solid fa-arrow-right room-banner-arrow"></i>
            </a>
        @else
            <div class="room-banner" style="cursor:default;">
                <div class="room-banner-ico none"><i class="fa-solid fa-door-open"></i></div>
                <div class="room-banner-info">
                    <div class="room-banner-none">You're not in any accommodation right now.</div>
                </div>
            </div>
        @endif

        {{-- ② Total Spent --}}
        <div class="hstat">
            <div class="hstat-icon"><i class="fa-solid fa-wallet"></i></div>
            <div class="hstat-label">Total Spent</div>
            <div class="hstat-value">{{ number_format($totalExpenses, 2) }}<span>MAD</span></div>
            <div class="hstat-sub">across all accommodations</div>
        </div>

        {{-- ③ Reputation --}}
        <div class="hstat">
            <div class="hstat-icon"><i class="fa-solid fa-star-half-stroke"></i></div>
            <div class="hstat-label">Reputation</div>
            <div class="hstat-value">{{ $reputation }}<span>pts</span></div>
            <div class="rep-bar-track"><div class="rep-bar-fill"></div></div>
            <span class="rep-tier" style="color: {{ $tierColor }}">
                <i class="fa-solid fa-circle" style="font-size:5px"></i> {{ $repTier }}
            </span>
        </div>

        {{-- ④ Expense history --}}
        <div class="hpanel">
            <div class="hpanel-head">
                <span class="hpanel-label"><i class="fa-solid fa-clock-rotate-left"></i> Expense History</span>
                @if($expenseHistory->isNotEmpty())
                    <span class="count-pill">{{ $expenseHistory->count() }}</span>
                @endif
            </div>
            @if($expenseHistory->isEmpty())
                <div class="hist-empty">
                    <i class="fa-solid fa-receipt"></i>
                    No expenses recorded yet.
                </div>
            @else
                <table class="hist-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Accommodation</th>
                            <th>Date</th>
                            <th style="text-align:right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenseHistory as $expense)
                            <tr>
                                <td class="hist-title-cell">{{ $expense->title }}</td>
                                <td>
                                    @if($expense->category)
                                        <span class="hist-cat-badge">{{ $expense->category->name }}</span>
                                    @else
                                        <span style="color:var(--text-3)">—</span>
                                    @endif
                                </td>
                                <td style="color:var(--text-3)">{{ $expense->accommodation->name ?? '—' }}</td>
                                <td class="hist-date">{{ \Carbon\Carbon::parse($expense->created_at)->format('d M Y') }}</td>
                                <td class="hist-amount">{{ number_format($expense->amount, 2) }} MAD</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
</div>