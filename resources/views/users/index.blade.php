@extends('layouts.app')

@section('title', 'Users (Employees)')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">Users Management</h1>
            <p class="page-subtitle">Manage and monitor all employee accounts</p>
        </div>
        <a href="{{ route('users.create') }}" class="mdc-button">
            <span class="material-symbols-outlined">add</span>
            Add New User
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="search-box">
            <span class="material-symbols-outlined">search</span>
            <input type="text" placeholder="Search users..." id="search-input">
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td><span class="badge-id">#{{ $user->id }}</span></td>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar-small">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <div>
                                    <div class="user-name">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('users.show', $user) }}" class="btn-icon btn-view" title="View">
                                    <span class="material-symbols-outlined">visibility</span>
                                </a>
                                <a href="{{ route('users.edit', $user) }}" class="btn-icon btn-edit" title="Edit">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                                <button type="button" onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')" class="btn-icon btn-delete" title="Delete">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            <span class="material-symbols-outlined">person</span>
                            <p>No users found</p>
                            <a href="{{ route('users.create') }}" class="mdc-button" style="margin-top: 16px;">
                                <span class="material-symbols-outlined">add</span>
                                Add First User
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="pagination-container">
            {{ $users->links() }}
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

    .card-header {
        padding: 24px;
        border-bottom: 1px solid var(--md-sys-color-outline);
        background: var(--md-sys-color-surface-variant);
    }

    .search-box {
        display: flex;
        align-items: center;
        gap: 12px;
        background: white;
        padding: 12px 20px;
        border-radius: 12px;
        border: 1px solid var(--md-sys-color-outline);
        max-width: 400px;
    }

    .search-box .material-symbols-outlined {
        color: var(--md-sys-color-on-surface-variant);
        font-size: 24px;
    }

    .search-box input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 14px;
        color: var(--md-sys-color-on-surface);
        background: transparent;
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
        transition: all 0.2s ease;
    }

    .data-table tbody tr:hover {
        background: var(--md-sys-color-surface-variant);
        transform: scale(1.01);
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar-small {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--md-sys-color-primary) 0%, var(--md-sys-color-secondary) 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 16px;
    }

    .user-name {
        font-weight: 600;
        color: var(--md-sys-color-on-surface);
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
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
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

    .empty-state .material-symbols-outlined {
        font-size: 64px;
        color: var(--md-sys-color-on-surface-variant);
        margin-bottom: 16px;
        opacity: 0.5;
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
    function deleteUser(id, name) {
        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to delete user: <strong>${name}</strong><br>This action cannot be undone!`,
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
                form.action = `/users/${id}`;
                form.submit();
            }
        });
    }

    // Search functionality
    document.getElementById('search-input')?.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('.data-table tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
</script>
@endpush
