<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ponnus Restaurant - Menu Management')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-color: #ea580c;
            --primary-hover: #c2410c;
            --body-bg: #f8fafc;
            --surface-bg: #ffffff;
            --border-color: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
        }
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--body-bg);
            color: var(--text-main);
            min-height: 100vh;
        }
        /* Top Navigation - Clean Light Theme */
        .navbar-light-custom {
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-color);
        }
        /* Sidebar - Clean Light Theme */
        .sidebar {
            min-height: calc(100vh - 61px);
            background-color: #ffffff;
            border-right: 1px solid var(--border-color);
        }
        .sidebar .nav-link {
            color: #475569;
            padding: 0.7rem 1.1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.15s ease-in-out;
            border-radius: 0.5rem;
            margin: 0.2rem 0.6rem;
        }
        .sidebar .nav-link:hover {
            color: #0f172a;
            background-color: #f1f5f9;
        }
        .sidebar .nav-link.active {
            color: var(--primary-color);
            background-color: #fff7ed;
            font-weight: 600;
        }
        .card-stat {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            background-color: #ffffff;
            transition: box-shadow 0.15s ease-in-out, transform 0.15s ease-in-out;
        }
        .card-stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
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
        .badge-role {
            font-size: 0.75rem;
            padding: 0.25rem 0.6rem;
            border-radius: 20px;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Top Navigation Bar -->
    @include('dashboard.navbar')

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Navigation -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-0" id="sidebarMenu">
                @include('dashboard.sidebar')
            </nav>

            <!-- Main Content Area -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                {{-- Flash Notifications: Success --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Flash Notifications: Error --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Validation Errors Summary --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <strong><i class="bi bi-x-circle-fill me-2"></i>Please check the errors below:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Dynamic Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
