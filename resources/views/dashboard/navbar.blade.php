<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm px-3">
    <div class="container-fluid">
        <!-- Brand Link -->
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ route('dashboard') }}">
            <i class="bi bi-egg-fried text-warning fs-4"></i>
            <span class="text-white">PONNUS</span>
            <span class="badge bg-warning text-dark fs-6 ms-1">Restaurant</span>
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Right Side Nav Items -->
        <div class="d-none d-lg-flex ms-auto align-items-center gap-3">
            @if (Auth::check())
                <!-- User Information -->
                <div class="text-end text-light">
                    <div class="fw-semibold">{{ Auth::user()->name }}</div>
                    <small class="badge bg-secondary badge-role">
                        Role: {{ Auth::user()->role ?? 'Staff' }}
                    </small>
                </div>

                <!-- Jetstream Profile Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center gap-2" type="button" id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-5"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userMenuButton">
                        <li class="dropdown-header">
                            <strong>{{ Auth::user()->name }}</strong><br>
                            <span class="text-muted small">{{ Auth::user()->email }}</span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile.show') }}">
                                <i class="bi bi-gear"></i> Jetstream Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('menu.create') }}">
                                <i class="bi bi-menu-button-wide"></i> Menu Items
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <!-- Standard Jetstream POST Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                                    <i class="bi bi-box-arrow-right"></i> Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</nav>
