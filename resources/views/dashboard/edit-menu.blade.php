@extends('dashboard.layouts.master')

@section('title', 'Edit ' . $menu->name . ' - Ponnus')

@section('content')
<div class="container-fluid p-0">
    <!-- Breadcrumb & Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('menu.create') }}" class="text-decoration-none">Menu Items</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('menu.show', $menu->id) }}" class="text-decoration-none">{{ $menu->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
            <h3 class="fw-bold text-dark mb-0">Edit Menu Item</h3>
        </div>
        <div>
            <a href="{{ route('menu.create') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to Menu List
            </a>
        </div>
    </div>

    <!-- Edit Form Row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase" style="letter-spacing: 0.5px;">
                        <i class="bi bi-pencil-square text-primary me-2"></i> Update Dish Information
                    </h5>
                    <span class="badge bg-light text-muted border">ID #{{ $menu->id }}</span>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('menu.update', $menu->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Item Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold text-dark small">
                                Item Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $menu->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category & Price in two columns -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label fw-semibold text-dark small">
                                    Category <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                    @php
                                        $currentCat = old('category', $menu->category);
                                        $categories = ['Main Course', 'Fast Food', 'Pizza', 'Beverages', 'Appetizer', 'Dessert', 'Specialties'];
                                    @endphp
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat }}" {{ $currentCat == $cat ? 'selected' : '' }}>
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label fw-semibold text-dark small">
                                    Price (UGX) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">UGX</span>
                                    <input type="number" 
                                           step="100" 
                                           min="0" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           id="price" 
                                           name="price" 
                                           value="{{ old('price', $menu->price) }}" 
                                           required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Availability Status -->
                        <div class="mb-3">
                            <label for="availability" class="form-label fw-semibold text-dark small">
                                Availability Status <span class="text-danger">*</span>
                            </label>
                            @php
                                $currentAvailability = old('availability', $menu->availability);
                            @endphp
                            <select class="form-select @error('availability') is-invalid @enderror" id="availability" name="availability" required>
                                <option value="Available" {{ $currentAvailability == 'Available' ? 'selected' : '' }}>
                                    Available (Active and ready to order)
                                </option>
                                <option value="Unavailable" {{ $currentAvailability == 'Unavailable' ? 'selected' : '' }}>
                                    Unavailable (Out of stock / temporarily paused)
                                </option>
                            </select>
                            @error('availability')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold text-dark small">
                                Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4">{{ old('description', $menu->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-brand px-4 shadow-sm">
                                <i class="bi bi-save me-1"></i> Update Menu Item
                            </button>
                            <a href="{{ route('menu.show', $menu->id) }}" class="btn btn-light border px-3">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kitchen Info Card -->
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ asset('chef.jpg') }}" alt="Ponnus Chef" class="rounded-circle shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                    <div>
                        <h6 class="fw-bold text-dark mb-0">{{ $menu->name }}</h6>
                        <small class="text-muted">Item #{{ $menu->id }}</small>
                    </div>
                </div>
                <ul class="list-group list-group-flush small mb-3">
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Current Status:</span>
                        <span class="fw-semibold {{ $menu->availability === 'Available' ? 'text-success' : 'text-danger' }}">
                            {{ $menu->availability }}
                        </span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Created:</span>
                        <span>{{ $menu->created_at ? $menu->created_at->format('M d, Y') : 'N/A' }}</span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted">Last Updated:</span>
                        <span>{{ $menu->updated_at ? $menu->updated_at->format('M d, Y') : 'N/A' }}</span>
                    </li>
                </ul>
                <a href="{{ route('menu.show', $menu->id) }}" class="btn btn-outline-secondary btn-sm w-100">
                    <i class="bi bi-eye me-1"></i> View Item Page
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
