@extends('layouts.app')

@section('title', 'Edit Diagnosis')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">Edit Diagnosis</h1>
            <p class="page-subtitle">{{ $diagnosis->name }}</p>
        </div>
        <a href="{{ route('diagnoses.index') }}" class="mdc-button mdc-button--outlined">
            Back to List
        </a>
    </div>
</div>

<div class="card">
    <form action="{{ route('diagnoses.update', $diagnosis) }}" method="POST" class="form" id="diagnosis-form">
        @csrf
        @method('PUT')

        <div class="form-section">
            <h3 class="form-section-title">Basic Information</h3>
            <div class="form-group">
                <label for="name" class="form-label">Name <span class="required">*</span></label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $diagnosis->name) }}" required>
                @error('name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="type" class="form-label">Type <span class="required">*</span></label>
                    <select id="type" name="type" class="form-select" required>
                        <option value="">Select Type</option>
                        <option value="primary" {{ old('type', $diagnosis->type) == 'primary' ? 'selected' : '' }}>Primary</option>
                        <option value="secondary" {{ old('type', $diagnosis->type) == 'secondary' ? 'selected' : '' }}>Secondary</option>
                        <option value="tertiary" {{ old('type', $diagnosis->type) == 'tertiary' ? 'selected' : '' }}>Tertiary</option>
                    </select>
                    @error('type')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="order" class="form-label">Order</label>
                    <input type="number" id="order" name="order" class="form-input" value="{{ old('order', $diagnosis->order) }}" min="0">
                    @error('order')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-textarea" rows="4">{{ old('description', $diagnosis->description) }}</textarea>
                @error('description')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <div class="checkbox-group">
                    <div class="mdc-checkbox">
                        <input 
                            type="checkbox" 
                            id="is_active" 
                            name="is_active" 
                            value="1"
                            class="mdc-checkbox__native-control"
                            {{ old('is_active', $diagnosis->is_active) ? 'checked' : '' }}
                        >
                        <div class="mdc-checkbox__background">
                            <span class="mdc-checkbox__checkmark material-symbols-outlined">check</span>
                        </div>
                    </div>
                    <label for="is_active" class="checkbox-label">Active</label>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('diagnoses.show', $diagnosis) }}" class="mdc-button mdc-button--outlined">Cancel</a>
            <button type="submit" class="mdc-button">
                Update Diagnosis
            </button>
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
        padding: 48px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--md-sys-color-outline);
        max-width: 800px;
        margin: 0 auto;
    }

    .form {
        width: 100%;
    }

    .form-section {
        margin-bottom: 36px;
        padding: 28px;
        background: var(--md-sys-color-surface-variant);
        border-radius: 16px;
        border: 1px solid var(--md-sys-color-outline);
    }

    .form-section-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--md-sys-color-primary);
        display: inline-block;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 10px;
    }

    .required {
        color: #C62828;
    }

    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid var(--md-sys-color-outline);
        border-radius: 12px;
        font-size: 15px;
        font-family: 'Roboto', sans-serif;
        color: var(--md-sys-color-on-surface);
        background-color: var(--md-sys-color-surface);
        transition: all 0.3s ease;
    }

    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-select {
        cursor: pointer;
    }

    .form-input:focus, .form-select:focus, .form-textarea:focus {
        outline: none;
        border-color: var(--md-sys-color-primary);
        box-shadow: 0 0 0 4px rgba(13, 38, 141, 0.1);
    }

    .form-error {
        display: block;
        font-size: 13px;
        color: #C62828;
        margin-top: 8px;
        font-weight: 500;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
    }

    .mdc-checkbox {
        position: relative;
        width: 20px;
        height: 20px;
    }

    .mdc-checkbox__native-control {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .mdc-checkbox__background {
        width: 20px;
        height: 20px;
        border: 2px solid var(--md-sys-color-outline);
        border-radius: 4px;
        position: relative;
        transition: all 0.2s ease;
        background: var(--md-sys-color-surface);
    }

    .mdc-checkbox__native-control:checked ~ .mdc-checkbox__background {
        background-color: var(--md-sys-color-primary);
        border-color: var(--md-sys-color-primary);
    }

    .mdc-checkbox__checkmark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        color: white;
        transition: transform 0.2s ease;
        font-size: 16px;
    }

    .mdc-checkbox__native-control:checked ~ .mdc-checkbox__background .mdc-checkbox__checkmark {
        transform: translate(-50%, -50%) scale(1);
    }

    .checkbox-label {
        color: var(--md-sys-color-on-surface);
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
    }

    .form-actions {
        display: flex;
        gap: 16px;
        justify-content: flex-end;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 2px solid var(--md-sys-color-outline);
    }

    .mdc-button--outlined {
        background-color: #1C1B1F;
        border: 2px solid #1C1B1F;
        color: #FFFFFF;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .mdc-button--outlined:hover {
        background-color: #313033;
        border-color: #313033;
        color: #FFFFFF;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .card {
            padding: 24px;
        }

        .page-header-content {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

