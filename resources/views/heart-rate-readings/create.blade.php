@extends('layouts.app')

@section('title', 'Add Heart Rate Reading')

@section('content')
<div class="page-header">
    <h1 class="page-title">Add Heart Rate Reading</h1>
    <p class="page-subtitle">{{ $patient->full_name }}</p>
</div>

<div class="card">
    <form action="{{ route('patients.heart-rate-readings.store', $patient) }}" method="POST" class="form" id="reading-form">
        @csrf

        <div class="form-section">
            <h3 class="form-section-title">Reading Information</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="date" class="form-label">Date <span class="required">*</span></label>
                    <input type="date" id="date" name="date" class="form-input" value="{{ old('date', date('Y-m-d')) }}" required>
                    @error('date')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="time" class="form-label">Time <span class="required">*</span></label>
                    <input type="time" id="time" name="time" class="form-input" value="{{ old('time', date('H:i')) }}" required>
                    @error('time')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="heart_rate" class="form-label">Heart Rate (bpm) <span class="required">*</span></label>
                    <input type="number" id="heart_rate" name="heart_rate" class="form-input" value="{{ old('heart_rate') }}" min="30" max="250" required>
                    @error('heart_rate')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="symptoms" class="form-label">Symptoms</label>
                    <textarea id="symptoms" name="symptoms" class="form-textarea" rows="4" placeholder="Enter any symptoms or notes...">{{ old('symptoms') }}</textarea>
                    @error('symptoms')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('patients.heart-rate-readings.index', $patient) }}" class="mdc-button mdc-button--outlined" tabindex="-1">Cancel</a>
            <button type="submit" class="mdc-button" tabindex="999">Add Reading</button>
        </div>
    </form>
</div>
@endsection

@push('styles')
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
        padding: 32px;
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
        margin-bottom: 24px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--md-sys-color-primary);
        display: inline-block;
        width: 100%;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 24px;
    }

    .form-row:last-child {
        margin-bottom: 0;
    }

    .form-group {
        margin-bottom: 0;
        display: flex;
        flex-direction: column;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 8px;
    }

    .required {
        color: #C62828;
    }

    .form-input, .form-textarea {
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

    .form-input:focus, .form-textarea:focus {
        outline: none;
        border-color: var(--md-sys-color-primary);
        box-shadow: 0 0 0 4px rgba(13, 38, 141, 0.15);
    }

    .form-error {
        display: block;
        font-size: 12px;
        color: #C62828;
        margin-top: 6px;
        line-height: 1.5;
        font-weight: 500;
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('reading-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Adding Reading...',
            text: 'Please wait while we add the heart rate reading',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        this.submit();
    });
</script>
@endpush

