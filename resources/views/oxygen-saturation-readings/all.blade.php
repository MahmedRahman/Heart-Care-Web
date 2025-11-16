@extends('layouts.app')

@section('title', 'All Oxygen Saturation Readings')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">All Oxygen Saturation Readings</h1>
            <p class="page-subtitle">View all oxygen saturation readings from all patients</p>
        </div>
        <a href="{{ route('patients.index') }}" class="mdc-button mdc-button--outlined">
            View Patients
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="search-box">
            <input type="text" placeholder="Search readings..." id="search-input">
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Oxygen Saturation</th>
                    <th>Delivery Method</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($readings as $reading)
                    <tr>
                        <td>
                            <div class="table-title">
                                <a href="{{ route('patients.show', $reading->patient) }}" style="color: var(--md-sys-color-primary); text-decoration: none;">
                                    {{ $reading->patient->full_name }}
                                </a>
                            </div>
                            <div class="table-text">{{ $reading->patient->hospital_id }}</div>
                        </td>
                        <td>{{ $reading->date->format('M d, Y') }}</td>
                        <td>{{ date('h:i A', strtotime($reading->time)) }}</td>
                        <td>
                            <span class="badge-oxygen">{{ $reading->oxygen_saturation }} {{ $reading->oxygen_saturation_unit }}</span>
                        </td>
                        <td>
                            @if($reading->oxygen_delivery_method)
                                <span class="delivery-method">
                                    {{ $reading->oxygen_delivery_method }}
                                    @if($reading->oxygen_delivery_method_unit)
                                        ({{ $reading->oxygen_delivery_method_unit }})
                                    @endif
                                </span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('patients.oxygen-saturation-readings.edit', [$reading->patient, $reading]) }}" class="btn-icon btn-edit" title="Edit">
                                    Edit
                                </a>
                                <form action="{{ route('patients.oxygen-saturation-readings.destroy', [$reading->patient, $reading]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this reading?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon btn-delete" title="Delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <p>No oxygen saturation readings found</p>
                            <a href="{{ route('patients.index') }}" class="mdc-button" style="margin-top: 16px;">
                                View Patients
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($readings->hasPages())
        <div class="pagination-container">
            {{ $readings->links() }}
        </div>
    @endif
</div>
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

    .table-title {
        font-weight: 600;
        color: var(--md-sys-color-on-surface);
        font-size: 15px;
        margin-bottom: 4px;
    }

    .table-text {
        color: var(--md-sys-color-on-surface-variant);
        font-size: 12px;
    }

    .badge-oxygen {
        background: linear-gradient(135deg, #00BCD4 0%, #00ACC1 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .delivery-method {
        color: var(--md-sys-color-on-surface);
        font-size: 14px;
    }

    .text-muted {
        color: var(--md-sys-color-on-surface-variant);
        font-style: italic;
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

