@extends('layouts.app')

@section('title', 'Onboarding')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">Onboarding Management</h1>
            <p class="page-subtitle">Manage onboarding screens for the application</p>
        </div>
        <a href="{{ route('onboardings.create') }}" class="mdc-button">
            Add New Onboarding
        </a>
    </div>
</div>

<div class="card">
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Text</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($onboardings as $onboarding)
                    <tr>
                        <td><span class="badge-id">{{ $onboarding->order }}</span></td>
                        <td>
                            @if($onboarding->image)
                                <img src="{{ Storage::url($onboarding->image) }}" alt="{{ $onboarding->title }}" class="table-image">
                            @else
                                <span class="no-image">No Image</span>
                            @endif
                        </td>
                        <td>
                            <div class="table-title">{{ $onboarding->title }}</div>
                        </td>
                        <td>
                            <div class="table-text">{{ Str::limit($onboarding->text, 50) }}</div>
                        </td>
                        <td>
                            @if($onboarding->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-warning">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('onboardings.show', $onboarding) }}" class="btn-icon btn-view" title="View">
                                    View
                                </a>
                                <a href="{{ route('onboardings.edit', $onboarding) }}" class="btn-icon btn-edit" title="Edit">
                                    Edit
                                </a>
                                <button type="button" onclick="deleteOnboarding({{ $onboarding->id }}, '{{ $onboarding->title }}')" class="btn-icon btn-delete" title="Delete">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <p>No onboarding items found</p>
                            <a href="{{ route('onboardings.create') }}" class="mdc-button" style="margin-top: 16px;">
                                Add First Onboarding
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($onboardings->hasPages())
        <div class="pagination-container">
            {{ $onboardings->links() }}
        </div>
    @endif
</div>

<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('styles')
<style>
    .page-header {
        margin-bottom: 32px;
    }

    .page-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 24px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .page-subtitle {
        font-size: 15px;
        color: var(--md-sys-color-on-surface-variant);
    }

    .card {
        background: var(--md-sys-color-surface);
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid var(--md-sys-color-outline);
    }

    .table-container {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background: var(--md-sys-color-surface-variant);
    }

    .data-table th {
        padding: 20px 24px;
        text-align: left;
        font-size: 13px;
        font-weight: 600;
        color: var(--md-sys-color-on-surface-variant);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--md-sys-color-outline);
    }

    .data-table td {
        padding: 20px 24px;
        font-size: 14px;
        color: var(--md-sys-color-on-surface);
        border-bottom: 1px solid var(--md-sys-color-outline);
    }

    .data-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .data-table tbody tr:hover {
        background: var(--md-sys-color-surface-variant);
    }

    .table-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--md-sys-color-outline);
    }

    .no-image {
        color: var(--md-sys-color-on-surface-variant);
        font-size: 12px;
        font-style: italic;
    }

    .table-title {
        font-weight: 600;
        color: var(--md-sys-color-on-surface);
    }

    .table-text {
        color: var(--md-sys-color-on-surface-variant);
        font-size: 13px;
    }

    .badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-success {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .badge-warning {
        background: #FFF3E0;
        color: #F57C00;
    }

    .badge-id {
        background: var(--md-sys-color-surface-variant);
        color: var(--md-sys-color-on-surface);
        padding: 4px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-icon {
        padding: 8px 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
    }

    .btn-view {
        background: #E3F2FD;
        color: #1976D2;
    }

    .btn-view:hover {
        background: #1976D2;
        color: white;
        transform: translateY(-2px);
    }

    .btn-edit {
        background: #FFF3E0;
        color: #F57C00;
    }

    .btn-edit:hover {
        background: #F57C00;
        color: white;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: #FFEBEE;
        color: #C62828;
    }

    .btn-delete:hover {
        background: #C62828;
        color: white;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px !important;
    }

    .empty-state p {
        color: var(--md-sys-color-on-surface-variant);
        font-size: 16px;
        margin-bottom: 8px;
    }

    .pagination-container {
        padding: 24px;
        display: flex;
        justify-content: center;
        border-top: 1px solid var(--md-sys-color-outline);
    }
</style>
@endpush

@push('scripts')
<script>
    function deleteOnboarding(id, title) {
        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to delete onboarding: <strong>${title}</strong><br>This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#C62828',
            cancelButtonColor: '#64748B',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form');
                form.action = `/onboardings/${id}`;
                form.submit();
            }
        });
    }
</script>
@endpush

