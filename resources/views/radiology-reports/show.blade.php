@extends('layouts.app')

@section('title', 'Radiology Report Details')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">Radiology Report Details</h1>
            <p class="page-subtitle">{{ $radiologyReport->report_name }}</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('radiology-reports.edit', $radiologyReport) }}" class="mdc-button">
                Edit
            </a>
            <a href="{{ route('radiology-reports.index') }}" class="mdc-button mdc-button--outlined">
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
                <p class="detail-value">{{ $radiologyReport->report_name }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Patient</label>
                <p class="detail-value">
                    <a href="{{ route('patients.show', $radiologyReport->patient) }}" style="color: var(--md-sys-color-primary); text-decoration: none;">
                        {{ $radiologyReport->patient->full_name }}
                    </a>
                </p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Report Date</label>
                <p class="detail-value">{{ $radiologyReport->report_date->format('Y-m-d') }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Files Count</label>
                <p class="detail-value">{{ count($radiologyReport->files ?? []) }} files</p>
            </div>
        </div>
    </div>

    @if($radiologyReport->files && count($radiologyReport->files) > 0)
    <div class="card">
        <div class="card-header-section">
            <h3 class="card-title">Report Files</h3>
        </div>
        <div class="files-grid">
            @foreach($radiologyReport->files as $index => $file)
                @php
                    $filePath = Storage::disk('public')->path($file);
                    $fileUrl = Storage::disk('public')->url($file);
                    $extension = pathinfo($file, PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                    $isPdf = strtolower($extension) === 'pdf';
                @endphp
                <div class="file-card">
                    @if($isImage)
                        <div class="file-preview-image">
                            <img src="{{ $fileUrl }}" alt="Report Image {{ $index + 1 }}" onclick="openImageModal('{{ $fileUrl }}')">
                        </div>
                    @elseif($isPdf)
                        <div class="file-preview-pdf">
                            <span class="material-symbols-outlined" style="font-size: 48px; color: var(--md-sys-color-primary);">description</span>
                            <p>PDF Document</p>
                        </div>
                    @else
                        <div class="file-preview-other">
                            <span class="material-symbols-outlined" style="font-size: 48px; color: var(--md-sys-color-on-surface-variant);">insert_drive_file</span>
                            <p>{{ strtoupper($extension) }}</p>
                        </div>
                    @endif
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

<!-- Image Modal -->
<div id="image-modal" class="image-modal" style="display: none;" onclick="closeImageModal()">
    <div class="image-modal-content" onclick="event.stopPropagation()">
        <button class="image-modal-close" onclick="closeImageModal()">&times;</button>
        <img id="modal-image" src="" alt="Full Size Image">
    </div>
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

    .file-preview-image img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        cursor: pointer;
    }

    .file-preview-pdf,
    .file-preview-other {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 200px;
        background: var(--md-sys-color-surface);
    }

    .file-preview-pdf p,
    .file-preview-other p {
        margin-top: 8px;
        font-size: 12px;
        color: var(--md-sys-color-on-surface-variant);
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

    .image-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .image-modal-content {
        position: relative;
        max-width: 90%;
        max-height: 90%;
        cursor: default;
    }

    .image-modal-content img {
        max-width: 100%;
        max-height: 90vh;
        border-radius: 8px;
    }

    .image-modal-close {
        position: absolute;
        top: -40px;
        right: 0;
        background: none;
        border: none;
        color: white;
        font-size: 40px;
        cursor: pointer;
        line-height: 1;
    }
</style>
@endpush

@push('scripts')
<script>
    function openImageModal(imageUrl) {
        document.getElementById('modal-image').src = imageUrl;
        document.getElementById('image-modal').style.display = 'flex';
    }

    function closeImageModal() {
        document.getElementById('image-modal').style.display = 'none';
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
</script>
@endpush

