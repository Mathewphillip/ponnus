<nav class="navbar navbar-expand-lg navbar-light-custom sticky-top px-3 py-2">
    <div class="container-fluid">
        <!-- Brand Link with Chef Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
            <img src="{{ asset('chef.jpg') }}" alt="Ponnus Chef" class="rounded-circle shadow-sm" style="width: 38px; height: 38px; object-fit: cover;">
            <span class="fw-bold fs-5 text-dark" style="letter-spacing: -0.3px;">PONNUS</span>
            <span class="badge bg-light text-muted border small ms-1">Restaurant</span>
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Right Side Nav Items -->
        <div class="d-none d-lg-flex ms-auto align-items-center gap-3">
            @if (Auth::check())
                <!-- User Information -->
                <div class="text-end">
                    <div class="fw-semibold text-dark small">{{ Auth::user()->name }}</div>
                    <span class="badge bg-orange-subtle text-warning-emphasis border border-warning-subtle badge-role" style="background-color: #fff7ed; color: #ea580c;">
                        {{ Auth::user()->role ?? 'Staff' }}
                    </span>
                </div>

                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-light border rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" type="button" id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person text-secondary fs-5"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2" aria-labelledby="userMenuButton" style="border-radius: 0.75rem;">
                        <li class="px-3 py-2 border-bottom mb-1">
                            <div class="fw-bold text-dark small">{{ Auth::user()->name }}</div>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ Auth::user()->email }}</div>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center gap-2 small" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 text-muted"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center gap-2 small" href="{{ route('menu.create') }}">
                                <i class="bi bi-card-checklist text-muted"></i> Menu Items
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center gap-2 small" href="{{ route('profile.show') }}">
                                <i class="bi bi-gear text-muted"></i> Account Settings
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <!-- Jetstream POST Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger d-flex align-items-center gap-2 small">
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
