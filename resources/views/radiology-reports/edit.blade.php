@extends('layouts.app')

@section('title', 'Edit Radiology Report')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">Edit Radiology Report</h1>
            <p class="page-subtitle">{{ $radiologyReport->report_name }}</p>
        </div>
        <a href="{{ route('radiology-reports.index') }}" class="mdc-button mdc-button--outlined">
            Back to List
        </a>
    </div>
</div>

<div class="card">
    <form action="{{ route('radiology-reports.update', $radiologyReport) }}" method="POST" class="form" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-section">
            <h3 class="form-section-title">Report Information</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="patient_id" class="form-label">Patient <span class="required">*</span></label>
                    <select id="patient_id" name="patient_id" class="form-select" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id', $radiologyReport->patient_id) == $patient->id ? 'selected' : '' }}>
                                {{ $patient->full_name }} ({{ $patient->hospital_id }})
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="report_name" class="form-label">Report Name <span class="required">*</span></label>
                    <input type="text" id="report_name" name="report_name" class="form-input" value="{{ old('report_name', $radiologyReport->report_name) }}" required>
                    @error('report_name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="report_date" class="form-label">Report Date <span class="required">*</span></label>
                    <input type="date" id="report_date" name="report_date" class="form-input" value="{{ old('report_date', $radiologyReport->report_date->format('Y-m-d')) }}" required>
                    @error('report_date')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        @if($radiologyReport->files && count($radiologyReport->files) > 0)
        <div class="form-section">
            <h3 class="form-section-title">Existing Files</h3>
            <div class="existing-files-grid">
                @foreach($radiologyReport->files as $index => $file)
                    @php
                        $fileUrl = Storage::disk('public')->url($file);
                        $extension = pathinfo($file, PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                        $fileName = basename($file);
                    @endphp
                    <div class="existing-file-item">
                        @if($isImage)
                            <img src="{{ $fileUrl }}" alt="{{ $fileName }}" class="file-thumbnail">
                        @else
                            <div class="file-icon">
                                <span class="material-symbols-outlined">description</span>
                            </div>
                        @endif
                        <div class="file-info">
                            <p class="file-name">{{ $fileName }}</p>
                            <div class="file-actions-small">
                                <a href="{{ $fileUrl }}" target="_blank" class="btn-small btn-view">View</a>
                                <form action="{{ route('radiology-reports.files.delete', [$radiologyReport, $index]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this file?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-small btn-delete">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="form-section">
            <h3 class="form-section-title">Add More Files</h3>
            <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="files" class="form-label">Files (Images/PDF)</label>
                    <input type="file" id="files" name="files[]" class="form-file" accept="image/*,.pdf" multiple>
                    <p class="form-hint">You can upload additional files (JPEG, PNG, JPG, GIF, PDF). Maximum file size: 10MB per file.</p>
                    @error('files')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    @error('files.*')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    <div id="file-preview" class="file-preview" style="display: none; margin-top: 16px;">
                        <div class="file-preview-title">New Files to Upload:</div>
                        <div id="file-list" class="file-list"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('radiology-reports.index') }}" class="mdc-button mdc-button--outlined">Cancel</a>
            <button type="submit" class="mdc-button">Update Report</button>
        </div>
    </form>
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

    .card {
        background: var(--md-sys-color-surface);
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--md-sys-color-outline);
    }

    .form-section {
        margin-bottom: 40px;
    }

    .form-section:last-of-type {
        margin-bottom: 32px;
    }

    .form-section-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 24px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--md-sys-color-outline);
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 24px;
        margin-bottom: 24px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        font-size: 14px;
        font-weight: 500;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 8px;
    }

    .required {
        color: #C62828;
    }

    .form-select {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid var(--md-sys-color-outline-variant);
        border-radius: 12px;
        font-size: 15px;
        font-family: 'Roboto', sans-serif;
        color: var(--md-sys-color-on-surface);
        background-color: var(--md-sys-color-surface);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }

    .form-select:focus {
        outline: none;
        border-color: var(--md-sys-color-primary);
        box-shadow: 0px 0px 0px 4px rgba(13, 38, 141, 0.1);
    }

    .form-file {
        width: 100%;
        padding: 14px 18px;
        border: 2px dashed var(--md-sys-color-outline);
        border-radius: 12px;
        font-size: 15px;
        font-family: 'Roboto', sans-serif;
        color: var(--md-sys-color-on-surface);
        background-color: var(--md-sys-color-surface-variant);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }

    .form-file:hover {
        border-color: var(--md-sys-color-primary);
        background-color: var(--md-sys-color-primary-container);
    }

    .form-file:focus {
        outline: none;
        border-color: var(--md-sys-color-primary);
        box-shadow: 0px 0px 0px 4px rgba(13, 38, 141, 0.1);
    }

    .form-hint {
        font-size: 12px;
        color: var(--md-sys-color-on-surface-variant);
        margin-top: 6px;
        line-height: 1.5;
    }

    .form-error {
        display: block;
        font-size: 12px;
        color: #C62828;
        margin-top: 6px;
        line-height: 1.5;
        font-weight: 500;
    }

    .existing-files-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }

    .existing-file-item {
        background: var(--md-sys-color-surface-variant);
        border-radius: 12px;
        padding: 12px;
        border: 1px solid var(--md-sys-color-outline);
    }

    .file-thumbnail {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 8px;
    }

    .file-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 150px;
        background: var(--md-sys-color-surface);
        border-radius: 8px;
        margin-bottom: 8px;
    }

    .file-icon .material-symbols-outlined {
        font-size: 48px;
        color: var(--md-sys-color-primary);
    }

    .file-info {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .file-name {
        font-size: 12px;
        color: var(--md-sys-color-on-surface);
        margin: 0;
        word-break: break-all;
    }

    .file-actions-small {
        display: flex;
        gap: 4px;
    }

    .btn-small {
        flex: 1;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 500;
        text-decoration: none;
        text-align: center;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-small.btn-view {
        background: var(--md-sys-color-primary-container);
        color: var(--md-sys-color-on-primary-container);
    }

    .btn-small.btn-delete {
        background: #FFEBEE;
        color: #C62828;
    }

    .file-preview {
        padding: 16px;
        background: var(--md-sys-color-surface-variant);
        border-radius: 12px;
        border: 1px solid var(--md-sys-color-outline);
    }

    .file-preview-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 12px;
    }

    .file-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .file-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 12px;
        background: var(--md-sys-color-surface);
        border-radius: 8px;
        font-size: 13px;
        color: var(--md-sys-color-on-surface);
    }

    .file-item-name {
        flex: 1;
    }

    .file-item-size {
        color: var(--md-sys-color-on-surface-variant);
        margin-left: 12px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid var(--md-sys-color-outline);
    }

    .mdc-button--outlined {
        background: transparent;
        border: 2px solid var(--md-sys-color-outline);
        color: var(--md-sys-color-on-surface);
    }

    .mdc-button--outlined:hover {
        background: var(--md-sys-color-surface-variant);
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('files').addEventListener('change', function(e) {
        const files = e.target.files;
        const preview = document.getElementById('file-preview');
        const fileList = document.getElementById('file-list');
        
        if (files.length > 0) {
            preview.style.display = 'block';
            fileList.innerHTML = '';
            
            Array.from(files).forEach((file, index) => {
                const fileItem = document.createElement('div');
                fileItem.className = 'file-item';
                
                const fileName = document.createElement('span');
                fileName.className = 'file-item-name';
                fileName.textContent = file.name;
                
                const fileSize = document.createElement('span');
                fileSize.className = 'file-item-size';
                fileSize.textContent = formatFileSize(file.size);
                
                fileItem.appendChild(fileName);
                fileItem.appendChild(fileSize);
                fileList.appendChild(fileItem);
            });
        } else {
            preview.style.display = 'none';
        }
    });

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }
</script>
@endpush

