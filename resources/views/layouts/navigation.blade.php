<aside class="sidebar" x-data="{ open: false }">
    <!-- Logo -->
    <div class="sidebar-logo">
        <a href="{{ route('dashboard') }}" class="logo-link">
            <span class="logo-icon"><i class="fa-solid fa-bolt"></i></span>
            <span class="logo-text">{{ config('app.name', 'App') }}</span>
        </a>
    </div>

    <!-- Nav Links -->
    <nav class="sidebar-nav">
        <div class="nav-section-label">Main</div>

        <a href="{{ route('dashboard') }}"
           class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high nav-icon"></i>
            <span>...</span>
            @if(request()->routeIs('dashboard'))
                <span class="nav-pip"></span>
            @endif
        </a>
        <a href="{{ route('Home') }}"
           class="nav-item {{ request()->routeIs('Home') ? 'active' : '' }}">
            <i class="fa-solid fa-home nav-icon"></i>
            <span>Home</span>
            @if(request()->routeIs('Home'))
                <span class="nav-pip"></span>
            @endif
        </a>

        <a href="{{ route('add.Accommondation') }}"
           class="nav-item {{ request()->routeIs('add.Accommondation') ? 'active' : '' }}">
            <i class="fa-solid fa-plus nav-icon"></i>
            <span>New Accommodation</span>
            @if(request()->routeIs('add.Accommondation'))
                <span class="nav-pip"></span>
            @endif
        </a>

        {{-- Add more nav items here as needed --}}
        {{-- Example:
        <a href="{{ route('users.index') }}"
           class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="fa-solid fa-users nav-icon"></i>
            <span>Users</span>
        </a>
        --}}
    </nav>

    <!-- User Block -->
    <div class="sidebar-user" x-data="{ dropOpen: false }">
        <button @click="dropOpen = !dropOpen" class="user-trigger">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="user-info">
                <span class="user-name">{{ Auth::user()->name }}</span>
                <span class="user-role">
                    @role('admin')
                        <i class="fa-solid fa-shield-halved"></i> Admin
                    @else
                        <i class="fa-solid fa-user"></i> Member
                    @endrole
                </span>
            </div>
            <i class="fa-solid fa-chevron-up user-caret" :class="{'rotate-180': !dropOpen}"></i>
        </button>

        <div x-show="dropOpen"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-1"
             @click.outside="dropOpen = false"
             class="user-dropdown"
             style="display: none;">

            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                <i class="fa-solid fa-sliders"></i>
                Profile Settings
            </a>
            @role('admin')
            <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                <i class="fa-solid fa-medal"></i>
                Admin Dashboard
            </a>
            @endrole
            <div class="dropdown-divider"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item danger">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    Sign Out
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile Toggle -->
    <button @click="open = !open"
            class="mobile-toggle sm:hidden">
        <i class="fa-solid fa-bars" x-show="!open"></i>
        <i class="fa-solid fa-xmark" x-show="open" style="display:none;"></i>
    </button>
</aside>