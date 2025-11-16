@extends('layouts.app')

@section('title', 'Prescriptions')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">Prescriptions</h1>
            <p class="page-subtitle">{{ $patient->full_name }}</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('patients.show', $patient) }}" class="mdc-button mdc-button--outlined">Back to Patient</a>
            <a href="{{ route('patients.prescriptions.create', $patient) }}" class="mdc-button">
                Add New Prescription
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Doctor Name</th>
                    <th>Medicines Count</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prescriptions as $prescription)
                    <tr>
                        <td>{{ $prescription->prescription_date->format('M d, Y') }}</td>
                        <td>{{ $prescription->doctor_name }}</td>
                        <td>
                            <span class="badge badge-info">{{ $prescription->medicines->count() }} medicines</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('patients.prescriptions.show', [$patient, $prescription]) }}" class="btn-icon btn-view" title="View">
                                    View
                                </a>
                                <a href="{{ route('patients.prescriptions.edit', [$patient, $prescription]) }}" class="btn-icon btn-edit" title="Edit">
                                    Edit
                                </a>
                                <button type="button" onclick="deletePrescription({{ $prescription->id }}, '{{ $prescription->prescription_date->format('M d, Y') }}')" class="btn-icon btn-delete" title="Delete">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state">
                            <p>No prescriptions found</p>
                            <a href="{{ route('patients.prescriptions.create', $patient) }}" class="mdc-button" style="margin-top: 16px;">
                                Add First Prescription
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($prescriptions->hasPages())
        <div class="pagination-container">
            {{ $prescriptions->links() }}
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
        border-bottom: 1px solid var(--md-sys-color-outline);
    }

    .data-table tbody tr:hover {
        background: var(--md-sys-color-surface-variant);
    }

    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-info {
        background: var(--md-sys-color-primary-container);
        color: var(--md-sys-color-on-primary-container);
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-icon {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-view {
        background: var(--md-sys-color-primary-container);
        color: var(--md-sys-color-on-primary-container);
    }

    .btn-view:hover {
        background: var(--md-sys-color-primary);
        color: var(--md-sys-color-on-primary);
    }

    .btn-edit {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .btn-edit:hover {
        background: #4CAF50;
        color: white;
    }

    .btn-delete {
        background: #FFEBEE;
        color: #C62828;
    }

    .btn-delete:hover {
        background: #F44336;
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--md-sys-color-on-surface-variant);
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
    function deletePrescription(id, date) {
        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to delete prescription from <strong>${date}</strong><br>This action cannot be undone!`,
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
                form.action = `/patients/{{ $patient->id }}/prescriptions/${id}`;
                form.submit();
            }
        });
    }
</script>
@endpush

