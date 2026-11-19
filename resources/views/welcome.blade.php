<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ponnus - Restaurant Menu Management System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-color: #d9480f;
            --primary-dark: #b83804;
        }
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #f8fafc;
            min-height: 100vh;
        }
        .hero-badge {
            background-color: rgba(217, 72, 15, 0.2);
            color: #ff922b;
            border: 1px solid rgba(217, 72, 15, 0.4);
        }
        .btn-brand {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #ffffff;
            font-weight: 600;
        }
        .btn-brand:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            color: #ffffff;
        }
        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            transition: all 0.2s ease-in-out;
        }
        .feature-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="d-flex flex-column min-h-screen">
    <!-- Header Navigation -->
    <header class="py-3 px-4 border-bottom border-secondary border-opacity-25">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center gap-2 text-white fw-bold fs-4">
                <i class="bi bi-egg-fried text-warning"></i>
                <span>PONNUS</span>
            </a>
            <div>
                @if (Route::has('login'))
                    <nav class="d-flex gap-2 align-items-center">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-warning btn-sm fw-semibold">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm px-3">
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

    <!-- Hero Content -->
    <main class="flex-grow-1 d-flex align-items-center py-5">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-7">
                    <span class="badge hero-badge px-3 py-2 rounded-pill mb-3 fw-semibold">
                        <i class="bi bi-mortarboard-fill me-1"></i> Laravel Practical Learning Project
                    </span>
                    <h1 class="display-4 fw-bold mb-3 text-white">
                        Restaurant Menu <span class="text-warning">Management System</span>
                    </h1>
                    <p class="lead text-light opacity-75 mb-4">
                        Ponnus is an educational web application designed to demonstrate fundamental Laravel MVC concepts:
                        authentication with Laravel Jetstream (Livewire stack), route architectures, controller conventions, and full Eloquent ORM CRUD operations.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-warning btn-lg fw-semibold px-4">
                                <i class="bi bi-speedometer2 me-2"></i> Open Dashboard
                            </a>
                            <a href="{{ route('menu.create') }}" class="btn btn-outline-light btn-lg px-4">
                                <i class="bi bi-card-checklist me-2"></i> View Menu Items
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-warning btn-lg fw-semibold px-4">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Log In to Ponnus
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
                                <i class="bi bi-person-plus me-2"></i> Create Account
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card feature-card p-4">
                        <h5 class="fw-bold text-warning mb-3">
                            <i class="bi bi-key-fill me-2"></i> Seeded Demonstration Accounts
                        </h5>
                        <p class="small text-light opacity-75 mb-3">
                            The database includes 3 pre-seeded demonstration accounts with the shared password: <code>password123</code>
                        </p>
                        <div class="list-group list-group-flush bg-transparent">
                            <div class="list-group-item bg-transparent text-light border-secondary border-opacity-25 px-0 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">Administrator</div>
                                        <small class="text-warning">admin@ponnus.test</small>
                                    </div>
                                    <span class="badge bg-danger">Role: Admin</span>
                                </div>
                            </div>
                            <div class="list-group-item bg-transparent text-light border-secondary border-opacity-25 px-0 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">Restaurant Staff</div>
                                        <small class="text-warning">staff@ponnus.test</small>
                                    </div>
                                    <span class="badge bg-primary">Role: Staff</span>
                                </div>
                            </div>
                            <div class="list-group-item bg-transparent text-light border-secondary border-opacity-25 px-0 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">Restaurant Manager</div>
                                        <small class="text-warning">manager@ponnus.test</small>
                                    </div>
                                    <span class="badge bg-success">Role: Manager</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top border-secondary border-opacity-25 text-center">
                            <a href="{{ route('login') }}" class="btn btn-brand w-100 fw-semibold">
                                <i class="bi bi-arrow-right-circle me-1"></i> Proceed to Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-3 border-top border-secondary border-opacity-25 text-center text-light opacity-50 small">
        <div class="container">
            Ponnus Restaurant Menu Management System &copy; {{ date('Y') }} &bull; Laravel Educational Project
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
