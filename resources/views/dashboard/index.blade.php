@extends('dashboard.layouts.master')

@section('title', 'Restaurant Dashboard - Ponnus')

@section('content')
<div class="container-fluid p-0">
    <!-- Welcome Header Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
        <div class="card-body p-4 text-white">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <span class="badge bg-warning text-dark mb-2 px-3 py-1 fw-semibold">Ponnus Menu Management</span>
                    <h2 class="fw-bold mb-1">Welcome, {{ Auth::user()->name }}!</h2>
                    <p class="text-light opacity-75 mb-0">
                        You are currently logged in with the role of
                        <span class="badge bg-primary px-2 py-1">{{ Auth::user()->role ?? 'Staff' }}</span>.
                        Manage your restaurant dishes, prices, and daily availability easily below.
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('menu.create') }}" class="btn btn-warning fw-semibold px-4 py-2 me-2 shadow-sm">
                        <i class="bi bi-list-ul me-1"></i> View Menu
                    </a>
                    <a href="{{ route('menu.index') }}" class="btn btn-outline-light px-3 py-2">
                        <i class="bi bi-plus-lg me-1"></i> Add Dish
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards Section -->
    <div class="row g-4 mb-4">
        <!-- Total Menu Items Card -->
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card card-stat border-0 h-100 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                Total Menu Items
                            </span>
                            <h2 class="display-6 fw-bold text-dark mb-0 mt-2">{{ $totalMenus }}</h2>
                            <small class="text-muted">Total dishes registered</small>
                        </div>
                        <div class="rounded-4 bg-primary bg-opacity-10 text-primary p-3 d-flex align-items-center justify-content-center" style="width: 58px; height: 58px;">
                            <i class="bi bi-journal-text fs-3"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-3 pt-0">
                    <a href="{{ route('menu.create') }}" class="text-decoration-none small fw-semibold text-primary">
                        Browse all items <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Available Items Card -->
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card card-stat border-0 h-100 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                Available Items
                            </span>
                            <h2 class="display-6 fw-bold text-success mb-0 mt-2">{{ $availableMenus }}</h2>
                            <small class="text-success fw-medium">Ready for customer ordering</small>
                        </div>
                        <div class="rounded-4 bg-success bg-opacity-10 text-success p-3 d-flex align-items-center justify-content-center" style="width: 58px; height: 58px;">
                            <i class="bi bi-check2-circle fs-3"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-3 pt-0">
                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                        Live on Menu
                    </span>
                </div>
            </div>
        </div>

        <!-- Unavailable Items Card -->
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card card-stat border-0 h-100 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                Unavailable Items
                            </span>
                            <h2 class="display-6 fw-bold text-danger mb-0 mt-2">{{ $unavailableMenus }}</h2>
                            <small class="text-danger fw-medium">Out of stock or paused</small>
                        </div>
                        <div class="rounded-4 bg-danger bg-opacity-10 text-danger p-3 d-flex align-items-center justify-content-center" style="width: 58px; height: 58px;">
                            <i class="bi bi-slash-circle fs-3"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-3 pt-0">
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                        Requires Restock
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Navigation & Demonstration Information -->
    <div class="row g-4">
        <!-- Menu Management Quick Actions Card -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-sliders text-warning me-2"></i> Menu Management Quick Actions
                    </h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4">
                        Perform standard CRUD (Create, Read, Update, Delete) operations on restaurant items using traditional Laravel MVC architecture:
                    </p>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="p-3 border rounded-3 text-center h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="text-primary mb-2"><i class="bi bi-table fs-2"></i></div>
                                    <h6 class="fw-bold">View Menu Table</h6>
                                    <p class="small text-muted mb-3">View all food items, categories, pricing, and availability statuses.</p>
                                </div>
                                <a href="{{ route('menu.create') }}" class="btn btn-outline-primary btn-sm w-100">
                                    Open Menu List
                                </a>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="p-3 border rounded-3 text-center h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="text-success mb-2"><i class="bi bi-plus-square fs-2"></i></div>
                                    <h6 class="fw-bold">Add New Food Item</h6>
                                    <p class="small text-muted mb-3">Register a new meal or beverage with custom category and price.</p>
                                </div>
                                <a href="{{ route('menu.index') }}" class="btn btn-outline-success btn-sm w-100">
                                    Open Add Form
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Demonstration Account Details Card -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-shield-check text-success me-2"></i> Active Session
                    </h5>
                    <!-- Logout button on Dashboard -->
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </div>
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <span class="text-muted">User Name:</span>
                            <span class="fw-bold">{{ Auth::user()->name }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <span class="text-muted">Email Address:</span>
                            <span class="text-dark">{{ Auth::user()->email }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <span class="text-muted">System Role:</span>
                            <span class="badge bg-primary px-3 py-1">{{ Auth::user()->role ?? 'Staff' }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <span class="text-muted">Authentication Guard:</span>
                            <span class="badge bg-secondary">Jetstream / Sanctum</span>
                        </li>
                    </ul>

                    <div class="alert alert-light border small text-muted mb-0">
                        <i class="bi bi-info-circle me-1 text-primary"></i>
                        All three demonstration accounts (Admin, Staff, Manager) have full access to view, add, edit, and delete items in this educational system.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
