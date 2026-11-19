@extends('dashboard.layouts.master')

@section('title', 'Edit Menu Item - Ponnus')

@section('content')
<div class="container-fluid p-0">
    <!-- Breadcrumb & Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('menu.create') }}" class="text-decoration-none">Menu Items</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Menu Item</li>
                </ol>
            </nav>
            <h3 class="fw-bold text-dark mb-0">Edit Menu Item: {{ $menu->name }}</h3>
        </div>
        <div>
            <a href="{{ route('menu.create') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Menu List
            </a>
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="row">
        <div class="col-lg-8 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-pencil-square text-primary me-2"></i> Update Dish Information
                    </h5>
                    <span class="badge bg-secondary">ID #{{ $menu->id }}</span>
                </div>

                <div class="card-body p-4">
                    <!-- Form submitting with PUT method via @method('PUT') -->
                    <form method="POST" action="{{ route('menu.update', $menu->id) }}">
                        <!-- CSRF Token -->
                        @csrf
                        <!-- Method Spoofing for HTTP PUT -->
                        @method('PUT')

                        <!-- Item Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold text-dark">
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
                                <label for="category" class="form-label fw-semibold text-dark">
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
                            <label for="availability" class="form-label fw-semibold text-dark">
                                Availability Status <span class="text-danger">*</span>
                            </label>
                            @php
                                $currentAvailability = old('availability', $menu->availability);
                            @endphp
                            <select class="form-select @error('availability') is-invalid @enderror" id="availability" name="availability" required>
                                <option value="Available" {{ $currentAvailability == 'Available' ? 'selected' : '' }}>
                                    Available (Active and ready for ordering)
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
                            <label for="description" class="form-label fw-semibold text-dark">
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

                        <!-- Form Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary fw-semibold px-4 shadow-sm">
                                <i class="bi bi-save me-1"></i> Update Menu Item
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
                        <i class="bi bi-arrow-repeat text-primary me-2"></i> How Update Works in Laravel
                    </h6>
                    <ul class="list-unstyled small text-muted mb-0">
                        <li class="mb-2">
                            <strong>1. Method Spoofing:</strong> HTML forms only support <code>GET</code> and <code>POST</code>. The <code>@method('PUT')</code> directive outputs a hidden <code>_method</code> field instructing Laravel's router to treat this request as an HTTP <code>PUT</code>.
                        </li>
                        <li class="mb-2">
                            <strong>2. Model Retrieval:</strong> The controller calls <code>Menu::findOrFail($id)</code> to retrieve the exact row. If the record does not exist, Laravel aborts with a 404 response.
                        </li>
                        <li class="mb-2">
                            <strong>3. Populating Forms:</strong> The <code>old('field', $model->field)</code> helper checks for previously failed validation input; if none exists, it defaults to the existing database record.
                        </li>
                        <li class="mb-0">
                            <strong>4. Database Update:</strong> The controller updates individual properties and executes <code>$menu->save()</code>, which issues an SQL <code>UPDATE menus SET ... WHERE id = ?</code> query.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
