@extends('dashboard.layouts.master')

@section('title', $menu->name . ' - Ponnus')

@section('content')
<div class="container-fluid p-0">
    <!-- Breadcrumb & Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('menu.create') }}" class="text-decoration-none">Menu Items</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $menu->name }}</li>
                </ol>
            </nav>
            <h3 class="fw-bold text-dark mb-0">Menu Item Details</h3>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('menu.create') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to Menu
            </a>
            <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-brand btn-sm">
                <i class="bi bi-pencil-square me-1"></i> Edit Item
            </a>
            <button type="button" 
                    class="btn btn-outline-danger btn-sm btn-delete" 
                    data-name="{{ $menu->name }}" 
                    data-url="{{ route('menu.destroy', $menu->id) }}">
                <i class="bi bi-trash me-1"></i> Delete
            </button>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Item Details Card -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
                <div class="card-body p-4 p-md-5">
                    <!-- Category & Availability Header -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <span class="badge px-3 py-2 fs-6 fw-semibold" style="background-color: #fff7ed; color: #ea580c; border: 1px solid #fed7aa;">
                            <i class="bi bi-tag-fill me-1"></i> {{ $menu->category }}
                        </span>

                        @if ($menu->availability === 'Available')
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-6 fw-semibold">
                                <i class="bi bi-check-circle-fill me-1"></i> Available for Ordering
                            </span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 fs-6 fw-semibold">
                                <i class="bi bi-slash-circle-fill me-1"></i> Currently Unavailable
                            </span>
                        @endif
                    </div>

                    <!-- Dish Title & Price -->
                    <div class="d-flex flex-wrap justify-content-between align-items-baseline gap-2 mb-4">
                        <h2 class="display-6 fw-bold text-dark mb-0">{{ $menu->name }}</h2>
                        <span class="display-6 fw-bold text-success">${{ number_format($menu->price, 2) }}</span>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <!-- Description Section -->
                    <h6 class="fw-bold text-dark text-uppercase small mb-2" style="letter-spacing: 0.5px;">Description</h6>
                    <p class="text-secondary lh-lg mb-4">
                        {{ $menu->description ?? 'No extended description has been added for this menu item yet.' }}
                    </p>

                    <hr class="my-4 text-muted opacity-25">

                    <!-- Specifications Grid -->
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-3">
                            <div class="p-3 bg-light rounded-3 text-center">
                                <span class="text-muted small d-block mb-1">Item ID</span>
                                <span class="fw-bold text-dark fs-5">#{{ $menu->id }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="p-3 bg-light rounded-3 text-center">
                                <span class="text-muted small d-block mb-1">Category</span>
                                <span class="fw-bold text-dark fs-6">{{ $menu->category }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="p-3 bg-light rounded-3 text-center">
                                <span class="text-muted small d-block mb-1">Price</span>
                                <span class="fw-bold text-success fs-5">${{ number_format($menu->price, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="p-3 bg-light rounded-3 text-center">
                                <span class="text-muted small d-block mb-1">Availability</span>
                                <span class="fw-bold {{ $menu->availability === 'Available' ? 'text-success' : 'text-secondary' }} fs-6">
                                    {{ $menu->availability }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light border-top px-4 px-md-5 py-3 text-muted small d-flex flex-wrap justify-content-between align-items-center">
                    <span>
                        <i class="bi bi-clock-history me-1"></i>
                        Created: {{ $menu->created_at ? $menu->created_at->format('M d, Y h:i A') : 'N/A' }}
                    </span>
                    <span>
                        <i class="bi bi-arrow-repeat me-1"></i>
                        Last Updated: {{ $menu->updated_at ? $menu->updated_at->format('M d, Y h:i A') : 'N/A' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Kitchen Overview Panel -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ asset('chef.jpg') }}" alt="Ponnus Chef" class="rounded-circle shadow-sm" style="width: 55px; height: 55px; object-fit: cover;">
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Ponnus Kitchen</h6>
                        <small class="text-muted">Item Quick Actions</small>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-brand btn-sm">
                        <i class="bi bi-pencil-square me-2"></i> Edit Dish Details
                    </a>
                    <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-plus-circle me-2"></i> Add Another Item
                    </a>
                    <a href="{{ route('menu.create') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-card-checklist me-2"></i> Return to Menu List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="deleteConfirmModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Item Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-1">Are you sure you want to permanently delete this menu item?</p>
                <div class="alert alert-warning mt-3 mb-0">
                    <strong>Dish Name:</strong> <span id="deleteItemName" class="fw-bold"></span>
                </div>
                <small class="text-muted mt-2 d-block">This action will remove the record from the database.</small>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> Yes, Delete Item
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.btn-delete').on('click', function() {
            var itemName = $(this).data('name');
            var actionUrl = $(this).data('url');

            $('#deleteItemName').text(itemName);
            $('#deleteForm').attr('action', actionUrl);

            var deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            deleteModal.show();
        });
    });
</script>
@endpush
