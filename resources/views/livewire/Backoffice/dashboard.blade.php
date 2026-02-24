<div>
    <x-slot name="header">
        <div class="page-title-block">
            <h1 class="page-title">Dashboard</h1>
            <span class="page-subtitle">Welcome back, {{ Auth::user()->name }}</span>
        </div>
    </x-slot>

    {{-- Tabs --}}
    <div class="dash-tabs">
        <button wire:click="switchTab('stats')"
                class="dash-tab {{ $tab === 'stats' ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high"></i>
            Overview
        </button>
        <button wire:click="switchTab('users')"
                class="dash-tab {{ $tab === 'users' ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i>
            Users
        </button>
    </div>

    {{-- Stats Tab --}}
    @if($tab === 'stats')
        <div class="dashboard-grid">
            @foreach($stats as $label => $value)
                <div class="stat-card" style="--i: {{ $loop->index }}">
                    <div class="stat-card-inner">
                        <div class="stat-label">{{ $label }}</div>
                        <div class="stat-value">{{ number_format($value) }}</div>
                        <div class="stat-icon">
                            @if(str_contains(strtolower($label), 'ban'))
                                <i class="fa-solid fa-user-slash"></i>
                            @elseif(str_contains(strtolower($label), 'user'))
                                <i class="fa-solid fa-users"></i>
                            @elseif(str_contains(strtolower($label), 'accommodation'))
                                <i class="fa-solid fa-house-chimney"></i>
                            @else
                                <i class="fa-solid fa-layer-group"></i>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    {{-- Users Tab --}}
    @elseif($tab === 'users')
        <div class="users-table-wrap">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr wire:key="user-{{ $user->id }}-{{ $user->is_banned ? 'banned' : 'active' }}"
                            class="{{ $user->is_banned ? 'row-banned' : '' }}">
                            <td class="td-name">
                                <div class="user-pill">
                                    <span class="user-avatar-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td class="td-email">{{ $user->email }}</td>
                            <td class="td-date">
                                {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                            </td>
                            <td>
                                @if($user->is_banned)
                                    <span class="badge badge-banned">
                                        <i class="fa-solid fa-ban"></i> Banned
                                    </span>
                                @else
                                    <span class="badge badge-active">
                                        <i class="fa-solid fa-circle-check"></i> Active
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($user->is_banned)
                                    <button wire:click="unban({{ $user->id }})"
                                            class="action-btn btn-unban">
                                        <i class="fa-solid fa-unlock"></i> Unban
                                    </button>
                                @else
                                    <button wire:click="ban({{ $user->id }})"
                                            class="action-btn btn-ban">
                                        <i class="fa-solid fa-ban"></i> Ban
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="td-empty">
                                <i class="fa-solid fa-inbox"></i> No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>