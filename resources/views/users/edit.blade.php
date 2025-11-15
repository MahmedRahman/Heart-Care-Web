@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit User</h1>
    <p class="page-subtitle">{{ $user->name }}</p>
</div>

<div class="card">
    <form action="{{ route('users.update', $user) }}" method="POST" class="form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name" class="form-label">Name <span class="required">*</span></label>
            <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email <span class="required">*</span></label>
            <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="user_type" class="form-label">User Type <span class="required">*</span></label>
                <select id="user_type" name="user_type" class="form-select select2-single" required>
                    <option value="">Select User Type</option>
                    <option value="nurse" {{ old('user_type', $user->user_type) == 'nurse' ? 'selected' : '' }}>Nurse</option>
                    <option value="doctor" {{ old('user_type', $user->user_type) == 'doctor' ? 'selected' : '' }}>Doctor</option>
                    <option value="other" {{ old('user_type', $user->user_type) == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('user_type')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" id="phone" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}">
                @error('phone')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="password" class="form-label">Password <span class="form-hint">(Leave blank to keep current password)</span></label>
                <input type="password" id="password" name="password" class="form-input">
                @error('password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input">
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('users.show', $user) }}" class="mdc-button mdc-button--outlined">Cancel</a>
            <button type="submit" class="mdc-button">Update User</button>
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
        margin-bottom: 24px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 400;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 8px;
    }

    .page-subtitle {
        font-size: 14px;
        color: var(--md-sys-color-on-surface-variant);
    }

    .card {
        background-color: var(--md-sys-color-surface);
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.30), 
                    0px 4px 8px 3px rgba(0, 0, 0, 0.15);
    }

    .form {
        max-width: 600px;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 24px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 8px;
    }

    .form-hint {
        font-weight: 400;
        color: var(--md-sys-color-on-surface-variant);
        font-size: 12px;
    }

    .required {
        color: #C62828;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid var(--md-sys-color-outline);
        border-radius: 4px;
        font-size: 14px;
        font-family: 'Roboto', sans-serif;
        color: var(--md-sys-color-on-surface);
        background-color: var(--md-sys-color-surface);
        transition: all 0.2s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--md-sys-color-primary);
        border-width: 2px;
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
        margin-top: 4px;
    }

    .form-actions {
        display: flex;
        gap: 16px;
        justify-content: flex-end;
        margin-top: 32px;
    }

    .mdc-button--outlined {
        background-color: transparent;
        border: 1px solid var(--md-sys-color-primary);
        color: var(--md-sys-color-primary);
        box-shadow: none;
    }

    .mdc-button--outlined:hover {
        background-color: var(--md-sys-color-surface-variant);
        box-shadow: none;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
</script>
@endpush

