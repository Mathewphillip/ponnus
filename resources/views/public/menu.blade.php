<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Menu — Ponnus Restaurant</title>
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
        .filter-pill {
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #475569;
            border-radius: 50px;
            padding: 0.35rem 1rem;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .filter-pill:hover {
            background: #fff7ed;
            border-color: #fed7aa;
            color: var(--primary-color);
        }
        .filter-pill.active {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #fff;
        }
        .menu-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #fff;
            transition: box-shadow 0.15s ease, transform 0.15s ease;
        }
        .menu-card:hover {
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }
        .category-badge {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.3rem 0.65rem;
            border-radius: 50px;
        }
        .price-tag {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        .navbar-brand-img {
            width: 36px;
            height: 36px;
            object-fit: cover;
        }
        .hero-section {
            background: linear-gradient(135deg, #fff7ed 0%, #fff 100%);
            border-bottom: 1px solid #fed7aa;
            padding: 2.5rem 0 2rem;
        }
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-white border-bottom py-2 px-0">
        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center gap-2 text-decoration-none">
                <img src="{{ asset('chef.jpg') }}" alt="Ponnus Chef" class="navbar-brand-img rounded-circle shadow-sm">
                <span class="fw-bold fs-5 text-dark" style="letter-spacing: -0.3px;">PONNUS</span>
                <span class="badge bg-light text-muted border small ms-1">Restaurant</span>
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary px-3">
                    <i class="bi bi-house me-1"></i> Home
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-brand btn-sm px-3">
                        <i class="bi bi-grid-1x2 me-1"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-brand btn-sm px-3">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Staff Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <div class="hero-section">
        <div class="container text-center">
            <span class="badge px-3 py-2 rounded-pill mb-3 fw-semibold d-inline-flex align-items-center gap-1"
                  style="background-color: #fff7ed; color: #ea580c; border: 1px solid #fed7aa;">
                <i class="bi bi-egg-fried"></i> Today's Menu
            </span>
            <h1 class="fw-bold mb-2 text-dark" style="font-size: 2rem;">What We're Serving</h1>
            <p class="text-secondary mb-0" style="max-width: 480px; margin: 0 auto;">
                Fresh, locally sourced dishes prepared daily by our kitchen team. All prices in Ugandan Shillings.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">

            <!-- Category Filter Pills -->
            <div class="d-flex flex-wrap gap-2 mb-4 justify-content-center">
                <a href="{{ route('public.menu') }}"
                   class="filter-pill {{ ($category === 'All' || !$category) ? 'active' : '' }}">
                    All Dishes
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('public.menu', ['category' => $cat]) }}"
                       class="filter-pill {{ $category === $cat ? 'active' : '' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            <!-- Results Count -->
            <div class="text-muted small mb-3 text-center">
                Showing <strong>{{ $menus->count() }}</strong> {{ Str::plural('dish', $menus->count()) }}
                @if($category && $category !== 'All')
                    in <strong>{{ $category }}</strong>
                @endif
            </div>

            <!-- Menu Grid -->
            @if($menus->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-basket2 fs-1 d-block mb-3 opacity-30"></i>
                    <p class="fs-5 fw-semibold mb-1">No dishes found</p>
                    <p class="small">Try a different category filter.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach($menus as $item)
                        <div class="col-sm-6 col-lg-4">
                            <div class="menu-card p-4 h-100 d-flex flex-column">
                                <!-- Category + Status Row -->
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    @php
                                        $categoryColors = [
                                            'Main Course' => ['bg' => '#eff6ff', 'text' => '#1d4ed8', 'border' => '#bfdbfe'],
                                            'Fast Food'   => ['bg' => '#fefce8', 'text' => '#854d0e', 'border' => '#fde68a'],
                                            'Pizza'       => ['bg' => '#fdf4ff', 'text' => '#7e22ce', 'border' => '#e9d5ff'],
                                            'Beverages'   => ['bg' => '#f0fdf4', 'text' => '#166534', 'border' => '#bbf7d0'],
                                        ];
                                        $colors = $categoryColors[$item->category] ?? ['bg' => '#f8fafc', 'text' => '#475569', 'border' => '#e2e8f0'];
                                    @endphp
                                    <span class="category-badge"
                                          style="background-color: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; border: 1px solid {{ $colors['border'] }};">
                                        {{ $item->category }}
                                    </span>
                                    @if($item->availability === 'Available')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle small">
                                            <i class="bi bi-check-circle me-1"></i>Available
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle small">
                                            <i class="bi bi-x-circle me-1"></i>Unavailable
                                        </span>
                                    @endif
                                </div>

                                <!-- Dish Name -->
                                <h5 class="fw-bold text-dark mb-2" style="font-size: 1rem;">{{ $item->name }}</h5>

                                <!-- Description -->
                                <p class="text-secondary mb-3 flex-grow-1" style="font-size: 0.85rem; line-height: 1.55;">
                                    {{ $item->description ?? 'No description available.' }}
                                </p>

                                <!-- Price -->
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-auto">
                                    <span class="price-tag">UGX {{ number_format($item->price, 0) }}</span>
                                    @if($item->availability === 'Available')
                                        <span class="badge px-3 py-2 rounded-pill fw-semibold"
                                              style="background-color: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; font-size: 0.72rem;">
                                            <i class="bi bi-bag-check me-1"></i>Order Now
                                        </span>
                                    @else
                                        <span class="text-muted small">Not available today</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </main>

    <!-- Footer -->
    <footer class="py-3 bg-white border-top text-center text-muted small mt-5">
        <div class="container">
            Ponnus Restaurant &copy; {{ date('Y') }} &mdash;
            <a href="{{ route('home') }}" class="text-decoration-none" style="color: var(--primary-color);">Home</a>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
