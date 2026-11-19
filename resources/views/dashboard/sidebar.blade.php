<div class="position-sticky pt-3">
    <!-- Authenticated User Profile Summary Card in Sidebar -->
    @if (Auth::check())
        <div class="px-3 py-2 mb-3 border-bottom border-secondary">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="text-truncate">
                    <div class="text-white fw-bold small text-truncate">{{ Auth::user()->name }}</div>
                    <span class="badge bg-primary badge-role">{{ Auth::user()->role ?? 'Staff' }}</span>
                </div>
            </div>
        </div>
    @endif

    <div class="px-3 pb-2 text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 1px;">
        Main Navigation
    </div>

    <ul class="nav flex-column mb-auto">
        <!-- Dashboard Link -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Menu Management Subheader -->
        <li class="nav-item mt-3">
            <div class="px-3 pb-2 text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 1px;">
                Menu Management
            </div>
        </li>

        <!-- View Menu Items Table (teaching convention route: menu.create -> /menu/list) -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('menu.create') ? 'active' : '' }}" href="{{ route('menu.create') }}">
                <i class="bi bi-card-checklist"></i>
                <span>Menu Items List</span>
            </a>
        </li>

        <!-- Add Menu Item Form (teaching convention route: menu.index -> /menu/create) -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('menu.index') ? 'active' : '' }}" href="{{ route('menu.index') }}">
                <i class="bi bi-plus-circle"></i>
                <span>Add New Item</span>
            </a>
        </li>

        <!-- Jetstream Account Settings -->
        <li class="nav-item mt-3">
            <div class="px-3 pb-2 text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 1px;">
                Account
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('profile.show') ? 'active' : '' }}" href="{{ route('profile.show') }}">
                <i class="bi bi-person-gear"></i>
                <span>User Profile</span>
            </a>
        </li>

        <!-- Logout Action -->
        <li class="nav-item mt-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100 text-start">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Log Out</span>
                </button>
            </form>
        </li>
    </ul>
</div>
