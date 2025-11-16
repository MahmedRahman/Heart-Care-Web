@extends('layouts.app')

@section('title', 'Add Blood Pressure Reading')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">Add Blood Pressure Reading</h1>
            <p class="page-subtitle">{{ $patient->full_name }}</p>
        </div>
        <a href="{{ route('patients.blood-pressure-readings.index', $patient) }}" class="mdc-button mdc-button--outlined">
            Back to Readings
        </a>
    </div>
</div>

<div class="card">
    <form action="{{ route('patients.blood-pressure-readings.store', $patient) }}" method="POST" class="form" id="reading-form">
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
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Blood Pressure</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="systolic_bp" class="form-label">Systolic BP <span class="required">*</span></label>
                    <input type="number" id="systolic_bp" name="systolic_bp" class="form-input" value="{{ old('systolic_bp') }}" min="50" max="300" required>
                    @error('systolic_bp')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="systolic_unit" class="form-label">Systolic Unit <span class="required">*</span></label>
                    <select id="systolic_unit" name="systolic_unit" class="form-select" required>
                        <option value="mmHg" {{ old('systolic_unit', 'mmHg') == 'mmHg' ? 'selected' : '' }}>mmHg</option>
                        <option value="kPa" {{ old('systolic_unit') == 'kPa' ? 'selected' : '' }}>kPa</option>
                    </select>
                    @error('systolic_unit')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="diastolic_bp" class="form-label">Diastolic BP <span class="required">*</span></label>
                    <input type="number" id="diastolic_bp" name="diastolic_bp" class="form-input" value="{{ old('diastolic_bp') }}" min="30" max="200" required>
                    @error('diastolic_bp')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="diastolic_unit" class="form-label">Diastolic Unit <span class="required">*</span></label>
                    <select id="diastolic_unit" name="diastolic_unit" class="form-select" required>
                        <option value="mmHg" {{ old('diastolic_unit', 'mmHg') == 'mmHg' ? 'selected' : '' }}>mmHg</option>
                        <option value="kPa" {{ old('diastolic_unit') == 'kPa' ? 'selected' : '' }}>kPa</option>
                    </select>
                    @error('diastolic_unit')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Additional Measurements</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="map" class="form-label">MAP (Mean Arterial Pressure)</label>
                    <input type="number" id="map" name="map" class="form-input" value="{{ old('map') }}" min="40" max="200" step="0.01">
                    @error('map')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="map_unit" class="form-label">MAP Unit</label>
                    <select id="map_unit" name="map_unit" class="form-select">
                        <option value="mmHg" {{ old('map_unit', 'mmHg') == 'mmHg' ? 'selected' : '' }}>mmHg</option>
                        <option value="kPa" {{ old('map_unit') == 'kPa' ? 'selected' : '' }}>kPa</option>
                    </select>
                    @error('map_unit')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="heart_rate" class="form-label">Heart Rate</label>
                    <input type="number" id="heart_rate" name="heart_rate" class="form-input" value="{{ old('heart_rate') }}" min="30" max="250">
                    @error('heart_rate')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="heart_rate_unit" class="form-label">Heart Rate Unit</label>
                    <select id="heart_rate_unit" name="heart_rate_unit" class="form-select">
                        <option value="bpm" {{ old('heart_rate_unit', 'bpm') == 'bpm' ? 'selected' : '' }}>bpm</option>
                    </select>
                    @error('heart_rate_unit')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Symptoms</h3>
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
            <a href="{{ route('patients.blood-pressure-readings.index', $patient) }}" class="mdc-button mdc-button--outlined" tabindex="-1">Cancel</a>
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

    .form-textarea {
        resize: vertical;
        min-height: 100px;
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
        background-color: transparent;
        border: 2px solid var(--md-sys-color-outline);
        color: var(--md-sys-color-on-surface);
        box-shadow: none;
    }

    .mdc-button--outlined:hover {
        background-color: var(--md-sys-color-surface-variant);
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
<script>
    // Auto-calculate MAP if both systolic and diastolic are provided
    document.getElementById('systolic_bp')?.addEventListener('input', calculateMAP);
    document.getElementById('diastolic_bp')?.addEventListener('input', calculateMAP);

    function calculateMAP() {
        const systolic = parseFloat(document.getElementById('systolic_bp')?.value) || 0;
        const diastolic = parseFloat(document.getElementById('diastolic_bp')?.value) || 0;
        const mapInput = document.getElementById('map');

        if (systolic > 0 && diastolic > 0 && mapInput && !mapInput.value) {
            // MAP = (2 × Diastolic + Systolic) / 3
            const map = ((2 * diastolic) + systolic) / 3;
            mapInput.value = map.toFixed(2);
        }
    }
</script>
@endpush

