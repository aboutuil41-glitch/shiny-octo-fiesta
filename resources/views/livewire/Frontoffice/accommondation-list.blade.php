<div>
    <x-slot name="header">
        <div class="page-title-block">
            <h1 class="page-title">Accommodations</h1>
            <span class="page-subtitle">All spaces you're part of</span>
        </div>
    </x-slot>

    <style>
        .al-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px; }

        .al-card { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; display: flex; flex-direction: column; transition: border-color .2s, transform .2s; animation: alIn .4s cubic-bezier(.16,1,.3,1) both; text-decoration: none; color: inherit; }
        .al-card:nth-child(1) { animation-delay: .04s; }
        .al-card:nth-child(2) { animation-delay: .09s; }
        .al-card:nth-child(3) { animation-delay: .14s; }
        .al-card:nth-child(4) { animation-delay: .19s; }
        .al-card:nth-child(5) { animation-delay: .24s; }
        .al-card:nth-child(6) { animation-delay: .29s; }
        @keyframes alIn { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }

        .al-card:hover { border-color: var(--border-2); transform: translateY(-3px); }
        .al-card:hover .al-arrow { opacity: 1; transform: translateX(0); }
        .al-card::before { content: ''; display: block; height: 2px; background: linear-gradient(90deg, var(--accent), var(--accent-2)); transform: scaleX(0); transform-origin: left; transition: transform .25s ease; }
        .al-card:hover::before { transform: scaleX(1); }

        .al-body { padding: 20px; flex: 1; display: flex; flex-direction: column; gap: 14px; }
        .al-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; }
        .al-icon-name { display: flex; align-items: center; gap: 12px; min-width: 0; }
        .al-icon { width: 40px; height: 40px; border-radius: var(--radius-sm); background: var(--accent-dim); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; }
        .al-name { font-size: 15px; font-weight: 700; color: var(--text); letter-spacing: -.2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        .al-role { flex-shrink: 0; font-size: 10px; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; padding: 3px 10px; border-radius: 99px; }
        .al-role.owner  { background: var(--accent-dim); color: var(--accent); }
        .al-role.member { background: var(--bg-4); color: var(--text-3); border: 1px solid var(--border-2); }

        .al-meta { display: flex; flex-direction: column; gap: 6px; }
        .al-meta-row { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--text-3); font-family: var(--font-mono); }
        .al-meta-row i { color: var(--accent); font-size: 11px; width: 12px; text-align: center; }

        .al-status { display: inline-flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 600; }
        .al-status.active { color: var(--success); }
        .al-status.active::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: var(--success); box-shadow: 0 0 6px var(--success); }
        .al-status.left { color: var(--text-3); }
        .al-status.left::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: var(--text-3); }
        .al-status.canceled { color: var(--danger); }
        .al-status.canceled::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: var(--danger); }

        .al-footer { padding: 12px 20px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .al-footer-label { font-size: 12px; color: var(--text-3); font-family: var(--font-mono); }
        .al-arrow { display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; color: var(--accent); opacity: 0; transform: translateX(-4px); transition: opacity .2s, transform .2s; }

        .al-empty { grid-column: 1 / -1; display: flex; flex-direction: column; align-items: center; gap: 10px; padding: 64px 0; color: var(--text-3); font-size: 13px; text-align: center; }
        .al-empty i { font-size: 36px; opacity: .25; margin-bottom: 8px; }
        .al-empty strong { color: var(--text-2); font-size: 15px; display: block; }
    </style>

    <div class="al-grid">
        @forelse ($accommondations as $accommodation)
            @php
                $role       = $accommodation->pivot->role ?? 'member';
                $roleClass  = in_array($role, ['owner', 'member']) ? $role : 'member';
                $hasLeft    = !is_null($accommodation->pivot->left_at);
                $isCanceled = $accommodation->state === 'canceled';
            @endphp

            <a href="{{ route('view.Accommondation', $accommodation->id) }}" class="al-card">
                <div class="al-body">
                    <div class="al-top">
                        <div class="al-icon-name">
                            <div class="al-icon">
                                <i class="fa-solid fa-house"></i>
                            </div>
                            <span class="al-name">{{ $accommodation->name }}</span>
                        </div>
                        <span class="al-role {{ $roleClass }}">{{ $role }}</span>
                    </div>

                    <div class="al-meta">
                        <div class="al-meta-row">
                            <i class="fa-solid fa-calendar-plus"></i>
                            Joined {{ optional($accommodation->pivot->created_at)->format('d M Y') ?? '—' }}
                        </div>
                        <div class="al-meta-row">
                            <i class="fa-solid fa-circle-dot"></i>
                            @if($hasLeft)
                                <span class="al-status left">
                                    Left {{ \Carbon\Carbon::parse($accommodation->pivot->left_at)->format('d M Y') }}
                                </span>
                            @elseif($isCanceled)
                                <span class="al-status canceled">Canceled</span>
                            @else
                                <span class="al-status active">Active</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="al-footer">
                    <span class="al-footer-label">View details</span>
                    <span class="al-arrow">Open <i class="fa-solid fa-arrow-right"></i></span>
                </div>
            </a>
        @empty
            <div class="al-empty">
                <i class="fa-solid fa-door-open"></i>
                <strong>No accommodations yet</strong>
                You haven't joined or created any accommodation.
            </div>
        @endforelse
    </div>
</div>