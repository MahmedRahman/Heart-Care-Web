@extends('layouts.app')

@section('title', 'Add New User')

@section('content')
<div class="page-header">
    <h1 class="page-title">Add New User</h1>
    <p class="page-subtitle">Create a new employee account</p>
</div>

<div class="card">
    <form action="{{ route('users.store') }}" method="POST" class="form" id="user-form">
        @csrf

        <div class="form-section">
            <h3 class="form-section-title">Basic Information</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="name" class="form-label">Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="user_type" class="form-label">User Type <span class="required">*</span></label>
                    <select id="user_type" name="user_type" class="form-select select2-single" required>
                        <option value="">Select User Type</option>
                        <option value="nurse" {{ old('user_type') == 'nurse' ? 'selected' : '' }}>Nurse</option>
                        <option value="doctor" {{ old('user_type') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                        <option value="other" {{ old('user_type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('user_type')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" id="phone" name="phone" class="form-input" value="{{ old('phone') }}">
                    @error('phone')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Security</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="password" class="form-label">Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" class="form-input" required>
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password <span class="required">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('users.index') }}" class="mdc-button mdc-button--outlined" tabindex="-1">Cancel</a>
            <button type="submit" class="mdc-button" tabindex="999">Create User</button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
    .page-header {
        margin-bottom: 32px;
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
        max-width: 900px;
        margin: 0 auto;
    }

    .form {
        width: 100%;
    }

    .form-section {
        margin-bottom: 32px;
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
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 8px;
    }

    .required {
        color: #C62828;
    }

    .form-input {
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

    .form-input:focus {
        outline: none;
        border-color: var(--md-sys-color-primary);
        box-shadow: 0 0 0 4px rgba(13, 38, 141, 0.15);
    }

    .form-select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--md-sys-color-outline);
        border-radius: 12px;
        font-size: 14px;
        font-family: 'Roboto', sans-serif;
        color: var(--md-sys-color-on-surface);
        background-color: var(--md-sys-color-surface);
        transition: all 0.2s ease;
        cursor: pointer;
    }

    /* Select2 Custom Styling */
    .select2-container--bootstrap-5 .select2-selection {
        border: 2px solid var(--md-sys-color-outline);
        border-radius: 12px;
        min-height: 48px;
        padding: 4px;
    }

    .select2-container--bootstrap-5 .select2-selection--single {
        height: 48px;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        line-height: 40px;
        padding-left: 14px;
        padding-right: 14px;
        color: var(--md-sys-color-on-surface);
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
        height: 46px;
        right: 14px;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: var(--md-sys-color-primary);
        box-shadow: 0 0 0 4px rgba(13, 38, 141, 0.15);
    }

    .select2-container--bootstrap-5 .select2-dropdown {
        border: 2px solid var(--md-sys-color-outline);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .select2-container--bootstrap-5 .select2-results__option--selected {
        background-color: var(--md-sys-color-primary-container);
        color: var(--md-sys-color-on-primary-container);
    }

    .select2-container--bootstrap-5 .select2-results__option--highlighted {
        background-color: var(--md-sys-color-primary);
        color: var(--md-sys-color-on-primary);
    }

    .form-error {
        display: block;
        font-size: 12px;
        color: #C62828;
        margin-top: 6px;
    }

    .form-actions {
        display: flex;
        gap: 16px;
        justify-content: flex-end;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid var(--md-sys-color-outline);
    }

    .mdc-button {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 500;
        text-transform: none;
        font-size: 14px;
        letter-spacing: 0;
        min-width: 120px;
    }

    .mdc-button--outlined {
        background-color: #1C1B1F;
        border: 2px solid #1C1B1F;
        color: white;
        box-shadow: none;
    }

    .mdc-button--outlined:hover {
        background-color: #2C2B2F;
        border-color: #2C2B2F;
        box-shadow: none;
    }

    @media (max-width: 768px) {
        .card {
            padding: 32px 24px;
        }

        .form-section {
            padding: 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .mdc-button {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Initialize Select2
    $(document).ready(function() {
        $('.select2-single').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: 'Select an option',
            allowClear: true
        });
    });

    document.getElementById('user-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Creating User...',
            text: 'Please wait while we create the user account',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        this.submit();
    });
</script>
@endpush

