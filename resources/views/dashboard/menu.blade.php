@extends('dashboard.layouts.master')

@section('title', 'Menu Items - Ponnus')

@section('content')
<div class="container-fluid p-0">
    <!-- Breadcrumb & Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Menu Items</li>
                </ol>
            </nav>
            <h3 class="fw-bold text-dark mb-0">Restaurant Menu</h3>
        </div>
        <div>
            <a href="{{ route('menu.index') }}" class="btn btn-brand shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Add New Menu Item
            </a>
        </div>
    </div>

    <!-- Balanced & Clean Menu Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark small text-uppercase" style="letter-spacing: 0.5px;">
                <i class="bi bi-card-checklist text-primary me-2"></i> All Dishes & Beverages
            </h5>
            <span class="badge bg-light text-muted border small">Total Items: {{ count($menus) }}</span>
        </div>

        <div class="card-body p-0">
            @if ($menus->isEmpty())
                <div class="text-center py-5">
                    <div class="text-muted mb-3"><i class="bi bi-egg-fried display-3 text-secondary opacity-50"></i></div>
                    <h5 class="fw-bold text-secondary">No Menu Items Found</h5>
                    <p class="text-muted small">Start by creating your first restaurant food or beverage item.</p>
                    <a href="{{ route('menu.index') }}" class="btn btn-brand btn-sm">
                        <i class="bi bi-plus-lg me-1"></i> Add Menu Item
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted small text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                            <tr>
                                <th scope="col" class="ps-4 py-3" style="width: 70px;">#ID</th>
                                <th scope="col" class="py-3">Dish / Item</th>
                                <th scope="col" class="py-3">Category</th>
                                <th scope="col" class="py-3">Price</th>
                                <th scope="col" class="py-3">Status</th>
                                <th scope="col" class="text-end pe-4 py-3" style="width: 220px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @foreach ($menus as $item)
                                <tr>
                                    <td class="ps-4 fw-semibold text-muted small">#{{ $item->id }}</td>
                                    <td>
                                        <a href="{{ route('menu.show', $item->id) }}" class="text-decoration-none fw-bold text-dark hover-primary">
                                            {{ $item->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge px-2.5 py-1.5 fw-medium" style="background-color: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; font-size: 0.75rem;">
                                            {{ $item->category }}
                                        </span>
                                    </td>
                                    <td class="fw-bold text-dark">
                                        UGX {{ number_format($item->price, 0) }}
                                    </td>
                                    <td>
                                        @if ($item->availability === 'Available')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                                <i class="bi bi-check-circle me-1"></i> Available
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">
                                                <i class="bi bi-slash-circle me-1"></i> Unavailable
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-inline-flex gap-1" role="group">
                                            <!-- View Details Button -->
                                            <a href="{{ route('menu.show', $item->id) }}" class="btn btn-sm btn-outline-secondary" title="View full details">
                                                <i class="bi bi-eye"></i> View
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="{{ route('menu.edit', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Edit this item">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>

                                            <!-- Delete Button (triggers modal) -->
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger btn-delete" 
                                                    data-id="{{ $item->id }}" 
                                                    data-name="{{ $item->name }}"
                                                    data-url="{{ route('menu.destroy', $item->id) }}"
                                                    title="Delete this item">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
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
