@extends('layouts.app')

@section('title', 'Lab Report Details')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">Lab Report Details</h1>
            <p class="page-subtitle">{{ $labReport->report_name }}</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('lab-reports.edit', $labReport) }}" class="mdc-button">
                Edit
            </a>
            <a href="{{ route('lab-reports.index') }}" class="mdc-button mdc-button--outlined">
                Back
            </a>
        </div>
    </div>
</div>

<div class="details-grid">
    <div class="card">
        <div class="card-header-section">
            <h3 class="card-title">Report Information</h3>
        </div>
        <div class="detail-grid">
            <div class="detail-item">
                <label class="detail-label">Report Name</label>
                <p class="detail-value">{{ $labReport->report_name }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Patient</label>
                <p class="detail-value">
                    <a href="{{ route('patients.show', $labReport->patient) }}" style="color: var(--md-sys-color-primary); text-decoration: none;">
                        {{ $labReport->patient->full_name }}
                    </a>
                </p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Report Date</label>
                <p class="detail-value">{{ $labReport->report_date->format('Y-m-d') }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Files Count</label>
                <p class="detail-value">{{ count($labReport->files ?? []) }} files</p>
            </div>
        </div>
    </div>

    @if($labReport->files && count($labReport->files) > 0)
    <div class="card">
        <div class="card-header-section">
            <h3 class="card-title">Report Files</h3>
        </div>
        <div class="files-grid">
            @foreach($labReport->files as $index => $file)
                @php
                    $fileUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($file);
                    $fileName = basename($file);
                @endphp
                <div class="file-card">
                    <div class="file-preview-pdf">
                        <span class="material-symbols-outlined" style="font-size: 48px; color: var(--md-sys-color-primary);">description</span>
                        <p>{{ $fileName }}</p>
                    </div>
                    <div class="file-actions">
                        <a href="{{ $fileUrl }}" target="_blank" class="btn-icon btn-view" title="View">
                            View
                        </a>
                        <a href="{{ $fileUrl }}" download class="btn-icon btn-download" title="Download">
                            Download
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
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

    .details-grid {
        display: grid;
        gap: 24px;
    }

    .card {
        background: var(--md-sys-color-surface);
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--md-sys-color-outline);
    }

    .card-header-section {
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid var(--md-sys-color-outline);
    }

    .card-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--md-sys-color-on-surface);
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .detail-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--md-sys-color-on-surface-variant);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 15px;
        color: var(--md-sys-color-on-surface);
        margin: 0;
    }

    .files-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }

    .file-card {
        background: var(--md-sys-color-surface-variant);
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--md-sys-color-outline);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .file-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .file-preview-pdf {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 200px;
        background: var(--md-sys-color-surface);
        padding: 20px;
    }

    .file-preview-pdf p {
        margin-top: 8px;
        font-size: 12px;
        color: var(--md-sys-color-on-surface-variant);
        text-align: center;
        word-break: break-all;
    }

    .file-actions {
        display: flex;
        gap: 8px;
        padding: 12px;
        background: var(--md-sys-color-surface);
        border-top: 1px solid var(--md-sys-color-outline);
    }

    .btn-icon {
        flex: 1;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        text-align: center;
        transition: all 0.2s;
    }

    .btn-view {
        background: var(--md-sys-color-primary-container);
        color: var(--md-sys-color-on-primary-container);
    }

    .btn-view:hover {
        background: var(--md-sys-color-primary);
        color: var(--md-sys-color-on-primary);
    }

    .btn-download {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .btn-download:hover {
        background: #4CAF50;
        color: white;
    }
</style>
@endpush

