<div>
    <x-slot name="header">
        <div class="page-title-block">
            <h1 class="page-title">{{ $accommodation->name }}</h1>
            <span class="page-subtitle">{{ $accommodation->description ?? 'Accommodation details' }}</span>
        </div>
    </x-slot>

    <style>
        .av-layout { display: grid; grid-template-columns: 1fr 300px; gap: 18px; align-items: start; }
        @media (max-width: 900px) { .av-layout { grid-template-columns: 1fr; } }
        .av-col { display: flex; flex-direction: column; gap: 18px; }

        .av-card { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; animation: avIn .4s cubic-bezier(.16,1,.3,1) both; }
        .av-card:nth-child(1) { animation-delay: .04s; }
        .av-card:nth-child(2) { animation-delay: .10s; }
        .av-card:nth-child(3) { animation-delay: .16s; }
        @keyframes avIn { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }

        .av-card-head { padding: 14px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .av-card-label { font-size: 10.5px; font-weight: 700; letter-spacing: 1.4px; text-transform: uppercase; color: var(--text-3); display: flex; align-items: center; gap: 7px; }
        .av-card-label i { color: var(--accent); font-size: 11px; }
        .av-card-body { padding: 20px; }

        /* Buttons */
        .av-btn { display: inline-flex; align-items: center; gap: 7px; padding: 9px 16px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 600; font-family: var(--font-display); border: 1px solid transparent; cursor: pointer; transition: background .15s, transform .1s; }
        .av-btn:hover { transform: translateY(-1px); }
        .av-btn:active { transform: translateY(0); }
        .av-btn i { font-size: 12px; }
        .av-btn-primary { background: var(--accent); color: #000; }
        .av-btn-primary:hover { background: var(--accent-2); }
        .av-btn-ghost { background: var(--bg-3); color: var(--text-2); border-color: var(--border-2); }
        .av-btn-ghost:hover { background: var(--bg-4); color: var(--text); }
        .av-btn-danger { background: rgba(239,68,68,.1); color: var(--danger); border-color: rgba(239,68,68,.2); }
        .av-btn-danger:hover { background: rgba(239,68,68,.2); }
        .av-btn-sm { padding: 5px 10px; font-size: 11.5px; }

        .av-actions { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 18px; align-items: center; }
        .av-actions-right { margin-left: auto; }

        /* Members */
        .av-members { display: flex; flex-direction: column; gap: 4px; }
        .av-member-row { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: var(--radius-sm); transition: background .12s; }
        .av-member-row:hover { background: var(--bg-3); }
        .av-member-avatar { width: 32px; height: 32px; border-radius: calc(var(--radius-sm) - 1px); background: var(--accent-dim); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800; flex-shrink: 0; }
        .av-member-name { flex: 1; font-size: 13px; font-weight: 500; color: var(--text); }
        .av-member-role { font-size: 10px; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; padding: 2px 8px; border-radius: 99px; }
        .av-member-role.owner  { background: var(--accent-dim); color: var(--accent); }
        .av-member-role.member { background: var(--bg-4); color: var(--text-3); border: 1px solid var(--border-2); }
        .av-member-left { font-size: 10.5px; color: var(--text-3); font-family: var(--font-mono); }
        .av-member-rep { font-size: 11px; font-family: var(--font-mono); color: var(--text-3); }
        .av-member-rep.pos { color: var(--success); }
        .av-member-rep.neg { color: var(--danger); }

        /* Expenses */
        .av-expense-list { display: flex; flex-direction: column; gap: 2px; }
        .av-expense-row { display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: var(--radius-sm); transition: background .12s; }
        .av-expense-row:hover { background: var(--bg-3); }
        .av-expense-ico { width: 32px; height: 32px; border-radius: var(--radius-sm); background: var(--accent-dim); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0; }
        .av-expense-info { flex: 1; min-width: 0; }
        .av-expense-title { font-size: 13.5px; font-weight: 600; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .av-expense-cat { display: inline-flex; margin-top: 2px; padding: 1px 7px; background: var(--bg-4); border: 1px solid var(--border); border-radius: 4px; font-size: 10.5px; color: var(--text-3); font-family: var(--font-mono); }
        .av-expense-amount { font-family: var(--font-mono); font-size: 14px; font-weight: 700; color: var(--success); flex-shrink: 0; }

        /* Balances */
        .av-balance-row { display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; border-radius: var(--radius-sm); transition: background .12s; gap: 10px; }
        .av-balance-row:hover { background: var(--bg-3); }
        .av-balance-name { font-size: 13px; font-weight: 500; color: var(--text); flex: 1; }
        .av-balance-detail { font-size: 11px; color: var(--text-3); font-family: var(--font-mono); }
        .av-balance-val { font-family: var(--font-mono); font-size: 13px; font-weight: 700; }
        .av-balance-pos { color: var(--success); }
        .av-balance-neg { color: var(--danger); }
        .av-balance-zero { color: var(--text-3); }

        /* Debts */
        .av-debt-row { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: var(--radius-sm); transition: background .12s; }
        .av-debt-row:hover { background: var(--bg-3); }
        .av-debt-text { flex: 1; font-size: 13px; color: var(--text-2); }
        .av-debt-text strong { color: var(--text); }
        .av-debt-amount { font-family: var(--font-mono); font-size: 13px; font-weight: 700; color: var(--danger); }

        /* Empty */
        .av-empty { display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 28px 0; color: var(--text-3); font-size: 12.5px; text-align: center; }
        .av-empty i { font-size: 24px; opacity: .25; margin-bottom: 4px; }

        /* Pills */
        .count-pill { background: var(--bg-4); color: var(--text-3); border: 1px solid var(--border); border-radius: 99px; font-size: 11px; font-weight: 600; font-family: var(--font-mono); padding: 2px 8px; }
        .canceled-pill { background: rgba(239,68,68,.1); color: var(--danger); border: 1px solid rgba(239,68,68,.2); border-radius: 99px; font-size: 11px; font-weight: 700; padding: 3px 10px; font-family: var(--font-mono); }

        /* Modal */
        .av-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.6); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 100; padding: 20px; animation: overlayIn .15s ease both; }
        @keyframes overlayIn { from { opacity:0; } to { opacity:1; } }
        .av-modal { background: var(--bg-2); border: 1px solid var(--border-2); border-radius: var(--radius); width: 100%; max-width: 400px; overflow: hidden; animation: modalIn .2s cubic-bezier(.16,1,.3,1) both; box-shadow: 0 24px 64px rgba(0,0,0,.5); }
        @keyframes modalIn { from { opacity:0; transform:scale(.96) translateY(8px); } to { opacity:1; transform:scale(1) translateY(0); } }
        .av-modal-head { padding: 18px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; }
        .av-modal-icon { width: 36px; height: 36px; border-radius: var(--radius-sm); background: var(--accent-dim); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
        .av-modal-title { font-size: 15px; font-weight: 700; color: var(--text); }
        .av-modal-sub { font-size: 11.5px; color: var(--text-3); font-family: var(--font-mono); margin-top: 2px; }
        .av-modal-body { padding: 20px; display: flex; flex-direction: column; gap: 14px; }
        .av-modal-foot { padding: 14px 20px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 8px; }
        .av-field { display: flex; flex-direction: column; gap: 5px; }
        .av-field-label { font-size: 10.5px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--text-3); }

        /* Invite link */
        .inv-link-box { display: flex; align-items: center; gap: 8px; background: var(--bg-3); border: 1px solid var(--border-2); border-radius: var(--radius-sm); padding: 10px 12px; }
        .inv-link-text { flex: 1; font-size: 11.5px; font-family: var(--font-mono); color: var(--accent); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; min-width: 0; }
        .inv-copy-btn { flex-shrink: 0; display: inline-flex; align-items: center; gap: 5px; padding: 5px 10px; background: var(--bg-4); border: 1px solid var(--border-2); border-radius: calc(var(--radius-sm) - 2px); font-size: 11px; font-weight: 600; color: var(--text-2); cursor: pointer; font-family: var(--font-display); transition: background .15s, color .15s; }
        .inv-copy-btn:hover { background: var(--accent-dim); color: var(--accent); }
        .inv-divider { display: flex; align-items: center; gap: 10px; color: var(--text-3); font-size: 11px; font-family: var(--font-mono); }
        .inv-divider::before, .inv-divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
    </style>

    {{-- ── Action Bar ──────────────────────────────────────── --}}
    @php $userRole = $accommodation->users->firstWhere('id', auth()->id())?->pivot->role; @endphp

    <div class="av-actions">
        @if($accommodation->state === 'active')
            <button wire:click="OpenModelExpense" class="av-btn av-btn-primary">
                <i class="fa-solid fa-plus"></i> Add Expense
            </button>

            @if($userRole === 'owner')
                <button wire:click="OpenModelCata" class="av-btn av-btn-ghost">
                    <i class="fa-solid fa-tag"></i> Add Category
                </button>
                <button wire:click="OpenModelInvite" class="av-btn av-btn-ghost">
                    <i class="fa-solid fa-user-plus"></i> Invite
                </button>
            @endif
        @endif

        @if($accommodation->state === 'active')
            @if($userRole !== 'owner')
                <div class="av-actions-right">
                    <button wire:click="leave" wire:confirm="Are you sure you want to leave this accommodation?"
                            class="av-btn av-btn-danger">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Leave
                    </button>
                </div>
            @else
                <div class="av-actions-right">
                    <button wire:click="cancelAccommodation" wire:confirm="Cancel this accommodation? This will affect all members' reputation."
                            class="av-btn av-btn-danger">
                        <i class="fa-solid fa-ban"></i> Cancel Accommodation
                    </button>
                </div>
            @endif
        @else
            <div class="av-actions-right">
                <span class="canceled-pill"><i class="fa-solid fa-ban"></i> Canceled</span>
            </div>
        @endif
    </div>

    <div class="av-layout">

        {{-- ── Main column ─────────────────────────────────── --}}
        <div class="av-col">

            {{-- Expenses --}}
            <div class="av-card">
                <div class="av-card-head">
                    <span class="av-card-label"><i class="fa-solid fa-receipt"></i> Expenses</span>
                    <div style="display:flex;align-items:center;gap:8px;">
                        @if($accommodation->expenses->isNotEmpty())
                            <span class="count-pill">{{ $filteredExpenses->count() }}</span>
                            <select wire:model.live="filterMonth" style="font-size:11.5px;padding:3px 8px;border-radius:var(--radius-sm);border:1px solid var(--border-2);background:var(--bg-3);color:var(--text-2);">
                                <option value="">All months</option>
                                @foreach($expenseMonths as $month)
                                    <option value="{{ $month }}">{{ \Carbon\Carbon::parse($month)->format('M Y') }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
                <div class="av-card-body">
                    @if($filteredExpenses->isEmpty())
                        <div class="av-empty">
                            <i class="fa-solid fa-receipt"></i>
                            No expenses {{ $filterMonth ? 'for this month' : 'added yet' }}.
                        </div>
                    @else
                        <div class="av-expense-list">
                            @foreach($filteredExpenses as $expense)
                                <div class="av-expense-row">
                                    <div class="av-expense-ico"><i class="fa-solid fa-arrow-up-right-dots"></i></div>
                                    <div class="av-expense-info">
                                        <div class="av-expense-title">{{ $expense->title }}</div>
                                        @if($expense->category)
                                            <span class="av-expense-cat">{{ $expense->category->name }}</span>
                                        @endif
                                    </div>
                                    <span class="av-expense-amount">{{ number_format($expense->amount, 2) }} MAD</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Balances --}}
            <div class="av-card">
                <div class="av-card-head">
                    <span class="av-card-label"><i class="fa-solid fa-scale-balanced"></i> Balances</span>
                </div>
                <div class="av-card-body">
                    @if(empty($balances))
                        <div class="av-empty">
                            <i class="fa-solid fa-scale-balanced"></i>
                            No balances to show yet.
                        </div>
                    @else
                        <div style="display:flex;flex-direction:column;gap:2px;">
                            @foreach($balances as $data)
                                <div class="av-balance-row">
                                    <div style="display:flex;align-items:center;gap:9px;flex:1;">
                                        <div class="av-member-avatar" style="width:28px;height:28px;font-size:11px;">
                                            {{ strtoupper(substr($data['user']->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="av-balance-name">{{ $data['user']->name }}</div>
                                            <div class="av-balance-detail">paid {{ number_format($data['paid'], 2) }} · share {{ number_format($data['share'], 2) }} MAD</div>
                                        </div>
                                    </div>
                                    <span class="av-balance-val {{ $data['balance'] > 0.01 ? 'av-balance-pos' : ($data['balance'] < -0.01 ? 'av-balance-neg' : 'av-balance-zero') }}">
                                        {{ $data['balance'] > 0.01 ? '+' : '' }}{{ number_format($data['balance'], 2) }} MAD
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Who owes whom --}}
            <div class="av-card">
                <div class="av-card-head">
                    <span class="av-card-label"><i class="fa-solid fa-arrow-right-arrow-left"></i> Who Owes Whom</span>
                    @if(!empty($debts))
                        <span class="count-pill">{{ count($debts) }}</span>
                    @endif
                </div>
                <div class="av-card-body">
                    @if(empty($debts))
                        <div class="av-empty">
                            <i class="fa-solid fa-handshake"></i>
                            Everyone is settled up.
                        </div>
                    @else
                        <div style="display:flex;flex-direction:column;gap:2px;">
                            @foreach($debts as $debt)
                                <div class="av-debt-row">
                                    <div class="av-debt-text">
                                        <strong>{{ $debt['from']->name }}</strong> owes <strong>{{ $debt['to']->name }}</strong>
                                    </div>
                                    <span class="av-debt-amount">{{ number_format($debt['amount'], 2) }} MAD</span>
                                    @if(auth()->id() === $debt['from']->id)
                                        <button
                                            wire:click="markAsPaid({{ $debt['from']->id }}, {{ $debt['to']->id }}, {{ $debt['amount'] }})"
                                            wire:confirm="Mark {{ number_format($debt['amount'], 2) }} MAD as paid?"
                                            class="av-btn av-btn-ghost av-btn-sm">
                                            <i class="fa-solid fa-check"></i> Mark paid
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- ── Side column ─────────────────────────────────── --}}
        <div class="av-col">

            {{-- Members --}}
            <div class="av-card">
                <div class="av-card-head">
                    <span class="av-card-label"><i class="fa-solid fa-users"></i> Members</span>
                    <span class="count-pill">{{ $accommodation->users->filter(fn($u) => is_null($u->pivot->left_at))->count() }}</span>
                </div>
                <div class="av-card-body" style="padding:12px;">
                    <div class="av-members">
                        @foreach($accommodation->users as $user)
                            @php
                                $role    = $user->pivot->role ?? 'member';
                                $hasLeft = !is_null($user->pivot->left_at);
                            @endphp
                            <div class="av-member-row" style="{{ $hasLeft ? 'opacity:.45' : '' }}">
                                <div class="av-member-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                                <div style="flex:1;min-width:0;">
                                    <div class="av-member-name">{{ $user->name }}</div>
                                    <div class="av-member-rep {{ $user->reputation >= 0 ? 'pos' : 'neg' }}">
                                        rep {{ $user->reputation >= 0 ? '+' : '' }}{{ $user->reputation }}
                                    </div>
                                </div>
                                @if($hasLeft)
                                    <span class="av-member-left">left</span>
                                @else
                                    <span class="av-member-role {{ $role }}">{{ $role }}</span>
                                    @if($userRole === 'owner' && $role !== 'owner' && $accommodation->state === 'active')
                                        <button
                                            wire:click="removeMember({{ $user->id }})"
                                            wire:confirm="Remove {{ $user->name }}? If they have a debt, it will be charged to you."
                                            class="av-btn av-btn-danger av-btn-sm">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

    </div>

    {{-- ── Invite Modal ────────────────────────────────────── --}}
    @if($Invitemodel)
        <div class="av-overlay" wire:click.self="closeModelInvite">
            <div class="av-modal">
                <div class="av-modal-head">
                    <div class="av-modal-icon"><i class="fa-solid fa-user-plus"></i></div>
                    <div>
                        <div class="av-modal-title">Invite someone</div>
                        <div class="av-modal-sub">to {{ $accommodation->name }}</div>
                    </div>
                </div>
                <div class="av-modal-body">
                    <div class="av-field">
                        <label class="av-field-label">Email address</label>
                        <input type="email" placeholder="friend@example.com" wire:model="inviteEmail">
                        @error('inviteEmail') <span style="font-size:11px;color:var(--danger);font-family:var(--font-mono)">{{ $message }}</span> @enderror
                    </div>
                    @if($generatedLink)
                        <div class="inv-divider">link ready</div>
                        <div class="inv-link-box">
                            <span class="inv-link-text">{{ $generatedLink }}</span>
                            <button class="inv-copy-btn"
                                onclick="navigator.clipboard.writeText('{{ $generatedLink }}').then(() => { this.textContent = 'Copied!'; setTimeout(() => this.innerHTML = '<i class=\'fa-solid fa-copy\'></i> Copy', 2000); })">
                                <i class="fa-solid fa-copy"></i> Copy
                            </button>
                        </div>
                    @endif
                </div>
                <div class="av-modal-foot">
                    <button wire:click="generateLink" class="av-btn av-btn-ghost">
                        <i class="fa-solid fa-link"></i> Get Link
                    </button>
                    <button wire:click="closeModelInvite" class="av-btn av-btn-ghost">Cancel</button>
                    <button wire:click="invite" class="av-btn av-btn-primary">
                        <i class="fa-solid fa-paper-plane"></i> Send
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ── Add Expense Modal ───────────────────────────────── --}}
    @if($Expensemodel)
        <div class="av-overlay" wire:click.self="closeModelExpense">
            <div class="av-modal">
                <div class="av-modal-head">
                    <div class="av-modal-icon"><i class="fa-solid fa-plus"></i></div>
                    <div>
                        <div class="av-modal-title">Add Expense</div>
                        <div class="av-modal-sub">Record a new expense</div>
                    </div>
                </div>
                <div class="av-modal-body">
                    <div class="av-field">
                        <label class="av-field-label">Title</label>
                        <input type="text" placeholder="e.g. Groceries" wire:model="title">
                        @error('title') <span style="font-size:11px;color:var(--danger);font-family:var(--font-mono)">{{ $message }}</span> @enderror
                    </div>
                    <div class="av-field">
                        <label class="av-field-label">Amount (MAD)</label>
                        <input type="number" placeholder="0.00" wire:model="amount" min="0" step="0.01">
                        @error('amount') <span style="font-size:11px;color:var(--danger);font-family:var(--font-mono)">{{ $message }}</span> @enderror
                    </div>
                    <div class="av-field">
                        <label class="av-field-label">Category</label>
                        <select wire:model="category">
                            <option value="">Select a category</option>
                            @foreach($accommodation->categories ?? [] as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                        @error('category') <span style="font-size:11px;color:var(--danger);font-family:var(--font-mono)">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="av-modal-foot">
                    <button wire:click="closeModelExpense" class="av-btn av-btn-ghost">Cancel</button>
                    <button wire:click="addExpense" class="av-btn av-btn-primary">
                        <i class="fa-solid fa-check"></i> Add
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ── Add Category Modal ──────────────────────────────── --}}
    @if($Catamodel)
        <div class="av-overlay" wire:click.self="closeModelCata">
            <div class="av-modal">
                <div class="av-modal-head">
                    <div class="av-modal-icon"><i class="fa-solid fa-tag"></i></div>
                    <div>
                        <div class="av-modal-title">Add Category</div>
                        <div class="av-modal-sub">Create a new expense category</div>
                    </div>
                </div>
                <div class="av-modal-body">
                    <div class="av-field">
                        <label class="av-field-label">Category Name</label>
                        <input type="text" placeholder="e.g. Food, Utilities..." wire:model="cataname">
                        @error('cataname') <span style="font-size:11px;color:var(--danger);font-family:var(--font-mono)">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="av-modal-foot">
                    <button wire:click="closeModelCata" class="av-btn av-btn-ghost">Cancel</button>
                    <button wire:click="addCata" class="av-btn av-btn-primary">
                        <i class="fa-solid fa-check"></i> Create
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>