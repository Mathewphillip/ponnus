<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Ponnus Restaurant</title>
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
        .auth-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
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
        .form-control:focus {
            border-color: #ea580c;
            box-shadow: 0 0 0 0.25rem rgba(234, 88, 12, 0.15);
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center py-5">
    <div class="container" style="max-width: 440px;">
        <!-- Brand & Chef Logo Header -->
        <div class="text-center mb-4">
            <a href="{{ url('/') }}" class="text-decoration-none">
                <img src="{{ asset('chef.jpg') }}" alt="Ponnus Chef" class="rounded-circle shadow-sm mb-2 border border-2 border-white" style="width: 70px; height: 70px; object-fit: cover;">
                <h3 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">PONNUS</h3>
                <span class="badge px-3 py-1 text-uppercase fw-semibold" style="background-color: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; font-size: 0.7rem;">
                    Restaurant Menu System
                </span>
            </a>
        </div>

        <!-- Auth Card -->
        <div class="auth-card p-4 p-sm-5">
            <h4 class="fw-bold text-dark mb-1">Staff Sign In</h4>
            <p class="text-muted small mb-4">Enter your credentials to access the menu dashboard.</p>

            <!-- Session Status Alert -->
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show small py-2" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Validation Errors Summary -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show small py-2 mb-4" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label small fw-semibold text-dark">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" 
                               class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="name@ponnus.test" 
                               required 
                               autofocus 
                               autocomplete="username">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label small fw-semibold text-dark">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" 
                               class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="••••••••" 
                               required 
                               autocomplete="current-password">
                    </div>
                </div>

                <!-- Remember Me (Forgot Password completely removed) -->
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                        <label class="form-check-label small text-muted" for="remember_me">
                            Remember me
                        </label>
                    </div>
                </div>

                <!-- Sign In Button -->
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-brand py-2 fw-semibold shadow-sm">
                        Sign In <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>
            </form>

            <!-- Register Link -->
            @if (Route::has('register'))
                <div class="text-center pt-3 border-top">
                    <span class="small text-muted">New staff member?</span>
                    <a href="{{ route('register') }}" class="small fw-semibold text-decoration-none ms-1" style="color: var(--primary-color);">
                        Create an account
                    </a>
                </div>
            @endif
        </div>

        <!-- Demonstration Credentials Reference -->
        <div class="text-center mt-4">
            <small class="text-muted d-block mb-1">Demo Accounts (Password: <code>password123</code>)</small>
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <span class="badge bg-light text-muted border">admin@ponnus.test</span>
                <span class="badge bg-light text-muted border">staff@ponnus.test</span>
                <span class="badge bg-light text-muted border">manager@ponnus.test</span>
            </div>
            <div class="mt-3">
                <a href="{{ url('/') }}" class="text-muted small text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Back to Homepage
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
