@extends('layouts.app')

@section('title', 'Add New Onboarding')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">Add New Onboarding</h1>
            <p class="page-subtitle">Create a new onboarding screen</p>
        </div>
        <a href="{{ route('onboardings.index') }}" class="mdc-button mdc-button--outlined">
            Back to List
        </a>
    </div>
</div>

<div class="card">
    <form action="{{ route('onboardings.store') }}" method="POST" class="form" id="onboarding-form" enctype="multipart/form-data">
        @csrf

        <div class="form-section">
            <h3 class="form-section-title">Basic Information</h3>
            <div class="form-group">
                <label for="title" class="form-label">Title <span class="required">*</span></label>
                <input type="text" id="title" name="title" class="form-input" value="{{ old('title') }}" required>
                @error('title')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="text" class="form-label">Text <span class="required">*</span></label>
                <textarea id="text" name="text" class="form-textarea" rows="5" required>{{ old('text') }}</textarea>
                @error('text')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Image</h3>
            <div class="form-group">
                <label for="image" class="form-label">Image</label>
                <input type="file" id="image" name="image" class="form-file" accept="image/*">
                <p class="form-hint">Upload an image (JPEG, PNG, JPG, GIF - Max: 2MB)</p>
                @error('image')
                    <span class="form-error">{{ $message }}</span>
                @enderror
                <div id="image-preview" class="image-preview" style="display: none;">
                    <img id="preview-img" src="" alt="Preview">
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Settings</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="order" class="form-label">Order</label>
                    <input type="number" id="order" name="order" class="form-input" value="{{ old('order', 0) }}" min="0">
                    @error('order')
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
                                {{ old('is_active', true) ? 'checked' : '' }}
                            >
                            <div class="mdc-checkbox__background">
                                <span class="mdc-checkbox__checkmark material-symbols-outlined">check</span>
                            </div>
                        </div>
                        <label for="is_active" class="checkbox-label">Active</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('onboardings.index') }}" class="mdc-button mdc-button--outlined">Cancel</a>
            <button type="submit" class="mdc-button">
                Create Onboarding
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
        max-width: 1000px;
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

    .form-section:last-of-type {
        margin-bottom: 0;
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

    .form-input, .form-textarea, .form-file {
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
        min-height: 120px;
    }

    .form-file {
        padding: 12px;
        cursor: pointer;
    }

    .form-input:focus, .form-textarea:focus, .form-file:focus {
        outline: none;
        border-color: var(--md-sys-color-primary);
        box-shadow: 0 0 0 4px rgba(13, 38, 141, 0.1);
    }

    .form-hint {
        font-size: 12px;
        color: var(--md-sys-color-on-surface-variant);
        margin-top: 6px;
    }

    .form-error {
        display: block;
        font-size: 13px;
        color: #C62828;
        margin-top: 8px;
        font-weight: 500;
    }

    .image-preview {
        margin-top: 16px;
        padding: 16px;
        background: var(--md-sys-color-surface);
        border-radius: 12px;
        border: 2px solid var(--md-sys-color-outline);
    }

    .image-preview img {
        max-width: 100%;
        max-height: 300px;
        border-radius: 8px;
        object-fit: contain;
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

@push('scripts')
<script>
    // Image preview
    document.getElementById('image')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('image-preview').style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            document.getElementById('image-preview').style.display = 'none';
        }
    });

    document.getElementById('onboarding-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Creating Onboarding...',
            text: 'Please wait while we create the onboarding item',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        this.submit();
    });
</script>
@endpush

