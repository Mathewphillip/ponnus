<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ponnus - Restaurant Menu Management</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-color: #ea580c;
            --primary-hover: #c2410c;
            --body-bg: #f8fafc;
        }
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            background-color: var(--body-bg);
            color: #0f172a;
            min-height: 100vh;
        }
        .btn-brand {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #ffffff;
            font-weight: 500;
        }
        .btn-brand:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            color: #ffffff;
        }
    </style>
</head>
<body class="d-flex flex-column min-h-screen">
    <!-- Clean Light Header -->
    <header class="py-3 px-4 bg-white border-bottom">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center gap-2">
                <img src="{{ asset('chef.jpg') }}" alt="Ponnus Chef" class="rounded-circle shadow-sm" style="width: 40px; height: 40px; object-fit: cover;">
                <span class="fw-bold fs-4 text-dark" style="letter-spacing: -0.5px;">PONNUS</span>
                <span class="badge bg-light text-muted border small ms-1">Restaurant</span>
            </a>
            <div>
                @if (Route::has('login'))
                    <nav class="d-flex gap-2 align-items-center">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-brand btn-sm px-3">
                                <i class="bi bi-grid-1x2 me-1"></i> Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm px-3">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-brand btn-sm px-3">
                                    <i class="bi bi-person-plus me-1"></i> Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow-1 d-flex align-items-center py-5">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6">
                    <span class="badge px-3 py-2 rounded-pill mb-3 fw-semibold" style="background-color: #fff7ed; color: #ea580c; border: 1px solid #fed7aa;">
                        <i class="bi bi-egg-fried me-1"></i> Restaurant Menu Management
                    </span>
                    <h1 class="display-4 fw-bold mb-3 text-dark">
                        Simple, Fast & Reliable <span style="color: var(--primary-color);">Menu Control</span>
                    </h1>
                    <p class="lead text-secondary mb-4 fs-6">
                        Welcome to Ponnus. Manage daily food and beverage listings, update item pricing, toggle availability in real-time, and keep kitchen and service staff aligned with an intuitive interface.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-brand btn-lg px-4 shadow-sm">
                                <i class="bi bi-grid-1x2 me-2"></i> Go to Dashboard
                            </a>
                            <a href="{{ route('menu.create') }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="bi bi-card-checklist me-2"></i> View Menu Items
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-brand btn-lg px-4 shadow-sm">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Log In
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="bi bi-person-plus me-2"></i> Register Account
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Realistic Chef Card & Accounts -->
                <div class="col-lg-5 offset-lg-1">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                        <div class="p-4 text-center bg-light border-bottom">
                            <img src="{{ asset('chef.jpg') }}" alt="Ponnus Head Chef" class="rounded-circle shadow mb-3 border border-3 border-white" style="width: 110px; height: 110px; object-fit: cover;">
                            <h5 class="fw-bold text-dark mb-1">Ponnus Kitchen & Staff</h5>
                            <small class="text-muted">Staff Access Portal</small>
                        </div>
                        <div class="card-body p-4">
                            <div class="small text-muted mb-3 fw-semibold">
                                Demonstration Accounts (password: <code class="text-lowercase" style="text-transform: none;">password123</code>)
                            </div>
                            <div class="list-group list-group-flush mb-3">
                                <div class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold text-dark small">Administrator</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">admin@ponnus.test</div>
                                    </div>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Admin</span>
                                </div>
                                <div class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold text-dark small">Restaurant Staff</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">staff@ponnus.test</div>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Staff</span>
                                </div>
                                <div class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold text-dark small">Restaurant Manager</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">manager@ponnus.test</div>
                                    </div>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Manager</span>
                                </div>
                            </div>
                            <a href="{{ route('login') }}" class="btn btn-brand w-100 fw-semibold">
                                Proceed to Login <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Clean Light Footer -->
    <footer class="py-3 bg-white border-top text-center text-muted small">
        <div class="container">
            Ponnus Restaurant Menu Management &copy; {{ date('Y') }}
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
