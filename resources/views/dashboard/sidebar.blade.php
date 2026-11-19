<div class="position-sticky pt-3">
    <!-- User Profile Summary in Sidebar -->
    @if (Auth::check())
        <div class="px-3 pb-3 mb-2 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('chef.jpg') }}" alt="User" class="rounded-circle shadow-sm" style="width: 40px; height: 40px; object-fit: cover;">
                <div class="text-truncate">
                    <div class="text-dark fw-bold small text-truncate">{{ Auth::user()->name }}</div>
                    <span class="badge badge-role" style="background-color: #fff7ed; color: #ea580c; border: 1px solid #fed7aa;">
                        {{ Auth::user()->role ?? 'Staff' }}
                    </span>
                </div>
            </div>
        </div>
    @endif

    <div class="px-3 py-1 text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">
        Menu System
    </div>

    <ul class="nav flex-column mb-auto">
        <!-- Dashboard Link -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid-1x2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- View Menu Items Table -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('menu.create') ? 'active' : '' }}" href="{{ route('menu.create') }}">
                <i class="bi bi-card-checklist"></i>
                <span>Menu Items</span>
            </a>
        </li>

        <!-- Add Menu Item Form -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('menu.index') ? 'active' : '' }}" href="{{ route('menu.index') }}">
                <i class="bi bi-plus-circle"></i>
                <span>Add New Item</span>
            </a>
        </li>

        <!-- Account Section -->
        <li class="nav-item mt-3">
            <div class="px-3 py-1 text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                Settings
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('profile.show') ? 'active' : '' }}" href="{{ route('profile.show') }}">
                <i class="bi bi-person-gear"></i>
                <span>Profile Settings</span>
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
