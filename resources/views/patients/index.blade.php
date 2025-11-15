@extends('layouts.app')

@section('title', 'Patients')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">Patients Management</h1>
            <p class="page-subtitle">Manage and monitor all patient records</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <button type="button" onclick="openQuickAddModal()" class="mdc-button" style="background: var(--md-sys-color-primary-container); color: var(--md-sys-color-on-primary-container);">
                Quick Add
            </button>
            <a href="{{ route('patients.create') }}" class="mdc-button">
                Add New Patient
            </a>
        </div>
    </div>
</div>

<!-- Quick Add Modal -->
<div id="quick-add-modal" class="modal" style="display: none;">
    <div class="modal-overlay" onclick="closeQuickAddModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Quick Add Patient</h2>
            <button type="button" class="modal-close" onclick="closeQuickAddModal()">&times;</button>
        </div>
        <form id="quick-add-form" action="{{ route('patients.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-row-modal">
                    <div class="form-group-modal">
                        <label for="quick_first_name" class="form-label-modal">First Name <span class="required">*</span></label>
                        <input type="text" id="quick_first_name" name="first_name" class="form-input-modal" required>
                    </div>
                    <div class="form-group-modal">
                        <label for="quick_last_name" class="form-label-modal">Last Name <span class="required">*</span></label>
                        <input type="text" id="quick_last_name" name="last_name" class="form-input-modal" required>
                    </div>
                </div>
                <div class="form-row-modal">
                    <div class="form-group-modal">
                        <label for="quick_email" class="form-label-modal">Email <span class="required">*</span></label>
                        <input type="email" id="quick_email" name="email" class="form-input-modal" required>
                    </div>
                    <div class="form-group-modal">
                        <label for="quick_mobile_number" class="form-label-modal">Mobile Number <span class="required">*</span></label>
                        <input type="text" id="quick_mobile_number" name="mobile_number" class="form-input-modal" required>
                    </div>
                </div>
                <div class="form-row-modal">
                    <div class="form-group-modal">
                        <label for="quick_hospital_id" class="form-label-modal">Hospital ID <span class="required">*</span></label>
                        <input type="text" id="quick_hospital_id" name="hospital_id" class="form-input-modal" required>
                    </div>
                    <div class="form-group-modal">
                        <label for="quick_password" class="form-label-modal">Password <span class="required">*</span></label>
                        <input type="password" id="quick_password" name="password" class="form-input-modal" required>
                    </div>
                </div>
                <div class="form-group-modal">
                    <label for="quick_password_confirmation" class="form-label-modal">Confirm Password <span class="required">*</span></label>
                    <input type="password" id="quick_password_confirmation" name="password_confirmation" class="form-input-modal" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdc-button mdc-button--outlined" onclick="closeQuickAddModal()">Cancel</button>
                <button type="submit" class="mdc-button">Add Patient</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="search-box">
            <input type="text" placeholder="Search patients..." id="search-input">
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Hospital ID</th>
                    <th>Profile Completion</th>
                    <th>Email Status</th>
                    <th>Mobile Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                    <tr>
                        <td><span class="badge-id">#{{ $patient->id }}</span></td>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar-small">{{ strtoupper(substr($patient->first_name, 0, 1)) }}</div>
                                <div>
                                    <div class="user-name">{{ $patient->full_name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $patient->email }}</td>
                        <td>{{ $patient->mobile_number }}</td>
                        <td><span class="badge-info">{{ $patient->hospital_id }}</span></td>
                        <td>
                            <div class="profile-completion">
                                <div class="progress-bar-container">
                                    <div class="progress-bar" style="width: {{ $patient->profile_completion_percentage }}%"></div>
                                </div>
                                <span class="completion-percentage">{{ $patient->profile_completion_percentage }}%</span>
                            </div>
                        </td>
                        <td>
                            @if($patient->email_verified)
                                <span class="badge badge-success">
                                    Verified
                                </span>
                            @else
                                <span class="badge badge-warning">
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($patient->mobile_verified)
                                <span class="badge badge-success">
                                    Verified
                                </span>
                            @else
                                <span class="badge badge-warning">
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('patients.show', $patient) }}" class="btn-icon btn-view" title="View">
                                    View
                                </a>
                                <a href="{{ route('patients.edit', $patient) }}" class="btn-icon btn-edit" title="Edit">
                                    Edit
                                </a>
                                <button type="button" onclick="deletePatient({{ $patient->id }}, '{{ $patient->full_name }}')" class="btn-icon btn-delete" title="Delete">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="empty-state">
                            <p>No patients found</p>
                            <a href="{{ route('patients.create') }}" class="mdc-button" style="margin-top: 16px;">
                                Add First Patient
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($patients->hasPages())
        <div class="pagination-container">
            {{ $patients->links() }}
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

    .mdc-button {
        text-decoration: none !important;
    }

    .mdc-button:hover {
        text-decoration: none !important;
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
        background: white;
        padding: 12px 20px;
        border-radius: 12px;
        border: 1px solid var(--md-sys-color-outline);
        max-width: 400px;
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
        transition: background-color 0.2s ease;
    }

    .data-table tbody tr:hover {
        background: var(--md-sys-color-surface-variant);
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

    .badge-info {
        background: #E3F2FD;
        color: #1976D2;
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

    /* Profile Completion Styles */
    .profile-completion {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 150px;
    }

    .progress-bar-container {
        flex: 1;
        height: 8px;
        background: var(--md-sys-color-surface-variant);
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }

    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, var(--md-sys-color-primary) 0%, var(--md-sys-color-secondary) 100%);
        border-radius: 10px;
        transition: width 0.3s ease;
        position: relative;
    }

    .progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }
        100% {
            transform: translateX(100%);
        }
    }

    .completion-percentage {
        font-size: 13px;
        font-weight: 600;
        color: var(--md-sys-color-on-surface);
        min-width: 45px;
        text-align: right;
    }

    /* Modal Styles */
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }

    .modal-content {
        position: relative;
        background: var(--md-sys-color-surface);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        z-index: 1001;
        border: 1px solid var(--md-sys-color-outline);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px;
        border-bottom: 1px solid var(--md-sys-color-outline);
    }

    .modal-title {
        font-size: 24px;
        font-weight: 600;
        color: var(--md-sys-color-on-surface);
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 32px;
        color: var(--md-sys-color-on-surface-variant);
        cursor: pointer;
        padding: 0;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .modal-close:hover {
        background: var(--md-sys-color-surface-variant);
        color: var(--md-sys-color-on-surface);
    }

    .modal-body {
        padding: 24px;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding: 24px;
        border-top: 1px solid var(--md-sys-color-outline);
    }

    .form-row-modal {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 16px;
    }

    .form-group-modal {
        margin-bottom: 16px;
    }

    .form-group-modal:last-child {
        margin-bottom: 0;
    }

    .form-label-modal {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 8px;
    }

    .form-input-modal {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--md-sys-color-outline);
        border-radius: 12px;
        font-size: 14px;
        font-family: 'Roboto', sans-serif;
        color: var(--md-sys-color-on-surface);
        background-color: var(--md-sys-color-surface);
        transition: all 0.2s ease;
    }

    .form-input-modal:focus {
        outline: none;
        border-color: var(--md-sys-color-primary);
        box-shadow: 0 0 0 4px rgba(13, 38, 141, 0.15);
    }

    @media (max-width: 768px) {
        .form-row-modal {
            grid-template-columns: 1fr;
        }

        .modal-content {
            width: 95%;
            max-height: 95vh;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function deletePatient(id, name) {
        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to delete patient: <strong>${name}</strong><br>This action cannot be undone!`,
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
                form.action = `/patients/${id}`;
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

    // Quick Add Modal Functions
    function openQuickAddModal() {
        document.getElementById('quick-add-modal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeQuickAddModal() {
        document.getElementById('quick-add-modal').style.display = 'none';
        document.body.style.overflow = '';
        document.getElementById('quick-add-form').reset();
    }

    // Handle form submission
    document.getElementById('quick-add-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Adding Patient...',
            text: 'Please wait while we add the patient',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        this.submit();
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeQuickAddModal();
        }
    });
</script>
@endpush
