@extends('dashboard.layouts.master')

@section('title', 'Restaurant Dashboard - Ponnus')

@section('content')
<div class="container-fluid p-0">
    <!-- Clean Light Welcome Banner with Chef Image -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center g-4">
                <div class="col-auto">
                    <img src="{{ asset('chef.jpg') }}" alt="Ponnus Chef" class="rounded-4 shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                </div>
                <div class="col">
                    <span class="badge px-3 py-1 mb-2 fw-semibold" style="background-color: #fff7ed; color: #ea580c; border: 1px solid #fed7aa;">
                        Ponnus Restaurant
                    </span>
                    <h2 class="fw-bold mb-1 text-dark">Welcome back, {{ Auth::user()->name }}</h2>
                    <p class="text-muted mb-0 small">
                        Signed in as <span class="fw-semibold text-dark">{{ Auth::user()->role ?? 'Staff' }}</span> &bull; Manage today's restaurant dishes, prices, and availability.
                    </p>
                </div>
                <div class="col-md-auto text-md-end">
                    <a href="{{ route('menu.index') }}" class="btn btn-brand px-4 py-2 me-2 shadow-sm">
                        <i class="bi bi-plus-lg me-1"></i> Add Dish
                    </a>
                    <a href="{{ route('menu.create') }}" class="btn btn-outline-secondary px-3 py-2">
                        <i class="bi bi-card-checklist me-1"></i> View Menu
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Statistics -->
    <div class="row g-4 mb-4">
        <!-- Total Menu Items Card -->
        <div class="col-12 col-md-4">
            <div class="card card-stat h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                            Total Menu Items
                        </span>
                        <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: #eff6ff; color: #2563eb;">
                            <i class="bi bi-journal-text fs-5"></i>
                        </div>
                    </div>
                    <h2 class="display-6 fw-bold text-dark mb-1">{{ $totalMenus }}</h2>
                    <p class="text-muted small mb-0">Total dishes and drinks on record</p>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-4 pt-0">
                    <a href="{{ route('menu.create') }}" class="text-decoration-none small fw-semibold text-primary">
                        Browse all items <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Available Items Card -->
        <div class="col-12 col-md-4">
            <div class="card card-stat h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                            Available Items
                        </span>
                        <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: #f0fdf4; color: #16a34a;">
                            <i class="bi bi-check2-circle fs-5"></i>
                        </div>
                    </div>
                    <h2 class="display-6 fw-bold text-success mb-1">{{ $availableMenus }}</h2>
                    <p class="text-success small mb-0 fw-medium">Ready for customer orders</p>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-4 pt-0">
                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                        Live on Menu
                    </span>
                </div>
            </div>
        </div>

        <!-- Unavailable Items Card -->
        <div class="col-12 col-md-4">
            <div class="card card-stat h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                            Unavailable Items
                        </span>
                        <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background-color: #fef2f2; color: #dc2626;">
                            <i class="bi bi-slash-circle fs-5"></i>
                        </div>
                    </div>
                    <h2 class="display-6 fw-bold text-danger mb-1">{{ $unavailableMenus }}</h2>
                    <p class="text-danger small mb-0 fw-medium">Out of stock or paused</p>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-4 pt-0">
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                        Needs Restocking
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Operations & Active Session -->
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase" style="letter-spacing: 0.5px;">
                        <i class="bi bi-sliders text-warning me-2"></i> Menu Operations
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="p-4 border rounded-3 text-center h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="text-primary mb-2"><i class="bi bi-table fs-2"></i></div>
                                    <h6 class="fw-bold text-dark">Menu Table</h6>
                                    <p class="small text-muted mb-3">View all dishes, categories, pricing, and availability.</p>
                                </div>
                                <a href="{{ route('menu.create') }}" class="btn btn-outline-primary btn-sm w-100">
                                    Open Menu List
                                </a>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="p-4 border rounded-3 text-center h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="text-success mb-2"><i class="bi bi-plus-circle fs-2"></i></div>
                                    <h6 class="fw-bold text-dark">Add New Dish</h6>
                                    <p class="small text-muted mb-3">Add a new meal, drink, or dessert with category and price.</p>
                                </div>
                                <a href="{{ route('menu.index') }}" class="btn btn-brand btn-sm w-100">
                                    Add New Item
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase" style="letter-spacing: 0.5px;">
                        <i class="bi bi-shield-check text-success me-2"></i> Active Staff Session
                    </h5>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-box-arrow-right me-1"></i> Log Out
                        </button>
                    </form>
                </div>
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush mb-0">
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <span class="text-muted small">User Name:</span>
                            <span class="fw-bold text-dark small">{{ Auth::user()->name }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Email Address:</span>
                            <span class="text-dark small">{{ Auth::user()->email }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Assigned Role:</span>
                            <span class="badge badge-role" style="background-color: #fff7ed; color: #ea580c; border: 1px solid #fed7aa;">
                                {{ Auth::user()->role ?? 'Staff' }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
