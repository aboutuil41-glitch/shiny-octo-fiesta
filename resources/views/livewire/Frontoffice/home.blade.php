<div>
    <x-slot name="header">
        <div class="page-title-block">
            <h1 class="page-title">Home</h1>
            <span class="page-subtitle">Welcome back, {{ Auth::user()->name }}</span>
        </div>
    </x-slot>

    <style>

    </style>

    @php
        $repMax   = max($reputation, 1);
        $repPct   = min(round(($reputation / max($repMax, 50)) * 100), 100);
        $stars     = min(5, max(1, ceil($reputation / 5)));
        $repTier  = $reputation >= 40 ? 'Elite' : ($reputation >= 20 ? 'Trusted' : ($reputation >= 5 ? 'Active' : 'Newcomer'));
    @endphp

    <div class="home-grid">

        {{-- ① Reputation ─────────────────────────────── --}}
        <div class="h-card rep-card">
            <div class="card-label">
                <i class="fa-solid fa-star-half-stroke"></i> Reputation
            </div>

            <div class="rep-ring" style="--pct: {{ $repPct }}">
                <span class="rep-number">{{ $reputation }}</span>
            </div>

            <div class="rep-stars">
                @for($s = 1; $s <= 5; $s++)
                    <i class="fa-{{ $s <= $stars ? 'solid' : 'regular' }} fa-star"></i>
                @endfor
            </div>

            <span class="rep-badge">{{ $repTier }}</span>

            <div class="rep-label" style="margin-top:.5rem">
                Based on expenses paid
            </div>
        </div>

        {{-- ② Total expenses ──────────────────────────── --}}
        <div class="h-card total-card">
            <div class="card-label">
                <i class="fa-solid fa-wallet"></i> Total Spent
            </div>
            <div class="total-amount">
                <span>€</span>{{ number_format($totalExpenses, 2) }}
            </div>
            <div class="total-sub">Across all your accommodations</div>
            <div class="total-bar"><div class="total-bar-fill"></div></div>
        </div>

        {{-- ③ Accommodations ───────────────────────────── --}}
        <div class="h-card acc-card">
            <div class="card-label">
                <i class="fa-solid fa-house-chimney"></i> Your Accommodations
            </div>

            @if($accommodations->isEmpty())
                <div class="acc-empty">
                    <i class="fa-solid fa-door-open" style="display:block;font-size:1.6rem;margin-bottom:.5rem;opacity:.4"></i>
                    You haven't joined any accommodation yet.
                </div>
            @else
                <div class="acc-list">
                    @foreach($accommodations as $acc)
                        <div class="acc-item">
                            <div class="acc-icon">
                                <i class="fa-solid fa-house"></i>
                            </div>
                            <div class="acc-info">
                                <div class="acc-name">{{ $acc->name }}</div>
                                <div class="acc-state">{{ $acc->description }}</div>
                            </div>
                            <span class="acc-role {{ $acc->pivot->role === 'admin' ? 'admin' : 'member' }}">
                                {{ $acc->pivot->role }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ④ Expense history ─────────────────────────── --}}
        <div class="h-card hist-card">
            <div class="card-label">
                <i class="fa-solid fa-clock-rotate-left"></i> Expense History
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
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenseHistory as $expense)
                            <tr>
                                <td>{{ $expense->title }}</td>
                                <td>
                                    @if($expense->category)
                                        <span class="hist-cat">{{ $expense->category->name }}</span>
                                    @else
                                        <span style="color:var(--muted)">—</span>
                                    @endif
                                </td>
                                <td style="color:var(--muted)">
                                    {{ $expense->accommodation->name ?? '—' }}
                                </td>
                                <td style="color:var(--muted);font-size:.78rem">
                                    {{ \Carbon\Carbon::parse($expense->created_at)->format('d M Y') }}
                                </td>
                                <td class="hist-amount">€{{ number_format($expense->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
</div>