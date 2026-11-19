@extends('dashboard.layouts.master')

@section('title', 'Add New Menu Item - Ponnus')

@section('content')
<div class="container-fluid p-0">
    <!-- Breadcrumb & Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('menu.create') }}" class="text-decoration-none">Menu Items</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Menu Item</li>
                </ol>
            </nav>
            <h3 class="fw-bold text-dark mb-0">Create New Menu Item</h3>
        </div>
        <div>
            <a href="{{ route('menu.create') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Menu List
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-lg-8 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-plus-circle text-success me-2"></i> Menu Item Details Form
                    </h5>
                </div>

                <div class="card-body p-4">
                    <!-- Traditional Laravel POST Form -->
                    <form method="POST" action="{{ route('menu.store') }}">
                        <!-- CSRF Protection Token -->
                        @csrf

                        <!-- Item Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold text-dark">
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
                            <div class="form-text">Enter the full customer-facing dish or drink name.</div>
                        </div>

                        <!-- Category & Price in two columns -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label fw-semibold text-dark">
                                    Category <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                    <option value="" disabled {{ old('category') ? '' : 'selected' }}>Select a category</option>
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
                                <label for="price" class="form-label fw-semibold text-dark">
                                    Price ($ USD) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" 
                                           step="0.01" 
                                           min="0" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           id="price" 
                                           name="price" 
                                           value="{{ old('price') }}" 
                                           placeholder="0.00" 
                                           required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Availability Status -->
                        <div class="mb-3">
                            <label for="availability" class="form-label fw-semibold text-dark">
                                Availability Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('availability') is-invalid @enderror" id="availability" name="availability" required>
                                <option value="Available" {{ old('availability', 'Available') == 'Available' ? 'selected' : '' }}>
                                    Available (Active and ready for ordering)
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
                            <label for="description" class="form-label fw-semibold text-dark">
                                Description
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="Briefly describe ingredients, preparation style, or allergens...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Form Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning fw-semibold px-4 shadow-sm">
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

        <!-- Educational Side Panel -->
        <div class="col-lg-4 col-xl-5 mt-4 mt-lg-0">
            <div class="card border-0 shadow-sm rounded-4 bg-light">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-3">
                        <i class="bi bi-lightbulb text-warning me-2"></i> How This Form Works
                    </h6>
                    <ul class="list-unstyled small text-muted mb-0">
                        <li class="mb-2">
                            <strong>1. HTTP POST:</strong> The form submits to named route <code>menu.store</code> mapping to <code>MenuController@store</code>.
                        </li>
                        <li class="mb-2">
                            <strong>2. CSRF Security:</strong> The <code>@csrf</code> directive inserts a hidden token preventing cross-site request forgery attacks.
                        </li>
                        <li class="mb-2">
                            <strong>3. Validation:</strong> Input values are verified using Laravel's <code>$request->validate()</code>. Errors re-render the form automatically with previous input via <code>old()</code>.
                        </li>
                        <li class="mb-0">
                            <strong>4. Eloquent Persistence:</strong> The controller extracts values via <code>$request->input()</code>, assigns them to a new <code>Menu</code> model instance, and calls <code>$menu->save()</code> to insert the row into MySQL.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
