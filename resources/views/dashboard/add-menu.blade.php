@extends('dashboard.layouts.master')

@section('title', 'Add Menu Item - Ponnus')

@section('content')
<div class="container-fluid p-0">
    <!-- Breadcrumb & Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('menu.create') }}" class="text-decoration-none">Menu Items</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Menu Item</li>
                </ol>
            </nav>
            <h3 class="fw-bold text-dark mb-0">Create New Menu Item</h3>
        </div>
        <div>
            <a href="{{ route('menu.create') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to Menu List
            </a>
        </div>
    </div>

    <!-- Form Row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase" style="letter-spacing: 0.5px;">
                        <i class="bi bi-plus-circle text-success me-2"></i> Dish Details
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('menu.store') }}">
                        @csrf

                        <!-- Item Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold text-dark small">
                                Item Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="e.g. Chicken Pilau, Beef Burger" 
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
                                    <option value="" disabled {{ old('category') ? '' : 'selected' }}>Select category</option>
                                    <option value="Main Course" {{ old('category') == 'Main Course' ? 'selected' : '' }}>Main Course</option>
                                    <option value="Fast Food" {{ old('category') == 'Fast Food' ? 'selected' : '' }}>Fast Food</option>
                                    <option value="Pizza" {{ old('category') == 'Pizza' ? 'selected' : '' }}>Pizza</option>
                                    <option value="Beverages" {{ old('category') == 'Beverages' ? 'selected' : '' }}>Beverages</option>
                                    <option value="Appetizer" {{ old('category') == 'Appetizer' ? 'selected' : '' }}>Appetizer</option>
                                    <option value="Dessert" {{ old('category') == 'Dessert' ? 'selected' : '' }}>Dessert</option>
                                    <option value="Specialties" {{ old('category') == 'Specialties' ? 'selected' : '' }}>Specialties</option>
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
                                           value="{{ old('price') }}" 
                                           placeholder="e.g. 15000" 
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
                            <select class="form-select @error('availability') is-invalid @enderror" id="availability" name="availability" required>
                                <option value="Available" {{ old('availability', 'Available') == 'Available' ? 'selected' : '' }}>
                                    Available (Active and ready to order)
                                </option>
                                <option value="Unavailable" {{ old('availability') == 'Unavailable' ? 'selected' : '' }}>
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
                                      rows="4" 
                                      placeholder="Ingredients, preparation style, or portion notes...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-brand px-4 shadow-sm">
                                <i class="bi bi-check-lg me-1"></i> Save Menu Item
                            </button>
                            <a href="{{ route('menu.create') }}" class="btn btn-light border px-3">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kitchen Helper Card -->
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ asset('chef.jpg') }}" alt="Ponnus Chef" class="rounded-circle shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Menu Guidelines</h6>
                        <small class="text-muted">Kitchen Standards</small>
                    </div>
                </div>
                <ul class="list-unstyled small text-muted mb-0">
                    <li class="mb-2 pb-2 border-bottom">
                        <strong>Naming:</strong> Use clear, appetizing names familiar to diners.
                    </li>
                    <li class="mb-2 pb-2 border-bottom">
                        <strong>Pricing:</strong> Input amounts in UGX (e.g., <code>15000</code>).
                    </li>
                    <li class="mb-0">
                        <strong>Availability:</strong> Toggle to <em>Unavailable</em> immediately when ingredients run low.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
