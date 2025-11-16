@extends('layouts.app')

@section('title', 'Edit Random Blood Sugar Reading')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">Edit Random Blood Sugar Reading</h1>
            <p class="page-subtitle">{{ $patient->full_name }}</p>
        </div>
        <a href="{{ route('patients.random-blood-sugar-readings.index', $patient) }}" class="mdc-button mdc-button--outlined">
            Back to Readings
        </a>
    </div>
</div>

<div class="card">
    <form action="{{ route('patients.random-blood-sugar-readings.update', [$patient, $randomBloodSugarReading]) }}" method="POST" class="form" id="reading-form">
        @csrf
        @method('PUT')

        <div class="form-section">
            <h3 class="form-section-title">Reading Information</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="date" class="form-label">Date <span class="required">*</span></label>
                    <input type="date" id="date" name="date" class="form-input" value="{{ old('date', $randomBloodSugarReading->date->format('Y-m-d')) }}" required>
                    @error('date')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="time" class="form-label">Time <span class="required">*</span></label>
                    <input type="time" id="time" name="time" class="form-input" value="{{ old('time', date('H:i', strtotime($randomBloodSugarReading->time))) }}" required>
                    @error('time')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Random Blood Sugar</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="random_blood_sugar" class="form-label">Random Blood Sugar <span class="required">*</span></label>
                    <input type="number" id="random_blood_sugar" name="random_blood_sugar" class="form-input" value="{{ old('random_blood_sugar', $randomBloodSugarReading->random_blood_sugar) }}" min="0" max="1000" step="0.01" required>
                    @error('random_blood_sugar')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="random_blood_sugar_unit" class="form-label">Random Blood Sugar Unit <span class="required">*</span></label>
                    <select id="random_blood_sugar_unit" name="random_blood_sugar_unit" class="form-select" required>
                        <option value="mg/dL" {{ old('random_blood_sugar_unit', $randomBloodSugarReading->random_blood_sugar_unit) == 'mg/dL' ? 'selected' : '' }}>mg/dL</option>
                        <option value="mmol/L" {{ old('random_blood_sugar_unit', $randomBloodSugarReading->random_blood_sugar_unit) == 'mmol/L' ? 'selected' : '' }}>mmol/L</option>
                    </select>
                    @error('random_blood_sugar_unit')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Insulin Dose</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="insulin_dose" class="form-label">Insulin Dose</label>
                    <input type="number" id="insulin_dose" name="insulin_dose" class="form-input" value="{{ old('insulin_dose', $randomBloodSugarReading->insulin_dose) }}" min="0" max="1000" step="0.01">
                    @error('insulin_dose')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="insulin_dose_unit" class="form-label">Insulin Dose Unit</label>
                    <select id="insulin_dose_unit" name="insulin_dose_unit" class="form-select">
                        <option value="units" {{ old('insulin_dose_unit', $randomBloodSugarReading->insulin_dose_unit ?? 'units') == 'units' ? 'selected' : '' }}>units</option>
                        <option value="IU" {{ old('insulin_dose_unit', $randomBloodSugarReading->insulin_dose_unit) == 'IU' ? 'selected' : '' }}>IU</option>
                    </select>
                    @error('insulin_dose_unit')
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
                    <textarea id="symptoms" name="symptoms" class="form-textarea" rows="4" placeholder="Enter any symptoms or notes...">{{ old('symptoms', $randomBloodSugarReading->symptoms) }}</textarea>
                    @error('symptoms')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('patients.random-blood-sugar-readings.index', $patient) }}" class="mdc-button mdc-button--outlined" tabindex="-1">Cancel</a>
            <button type="submit" class="mdc-button" tabindex="999">Update Reading</button>
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

