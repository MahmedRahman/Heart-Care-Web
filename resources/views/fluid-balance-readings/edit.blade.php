@extends('layouts.app')

@section('title', 'Edit Fluid Balance Reading')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">Edit Fluid Balance Reading</h1>
            <p class="page-subtitle">{{ $patient->full_name }}</p>
        </div>
        <a href="{{ route('patients.fluid-balance-readings.index', $patient) }}" class="mdc-button mdc-button--outlined">
            Back to Readings
        </a>
    </div>
</div>

<div class="card">
    <form action="{{ route('patients.fluid-balance-readings.update', [$patient, $fluidBalanceReading]) }}" method="POST" class="form" id="reading-form">
        @csrf
        @method('PUT')

        <div class="form-section">
            <h3 class="form-section-title">Reading Information</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="date" class="form-label">Date <span class="required">*</span></label>
                    <input type="date" id="date" name="date" class="form-input" value="{{ old('date', $fluidBalanceReading->date->format('Y-m-d')) }}" required>
                    @error('date')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="time" class="form-label">Time <span class="required">*</span></label>
                    <input type="time" id="time" name="time" class="form-input" value="{{ old('time', date('H:i', strtotime($fluidBalanceReading->time))) }}" required>
                    @error('time')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Fluid Intake</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="fluid_intake" class="form-label">Fluid Intake</label>
                    <input type="number" id="fluid_intake" name="fluid_intake" class="form-input" value="{{ old('fluid_intake', $fluidBalanceReading->fluid_intake) }}" min="0" max="10000" step="0.01">
                    @error('fluid_intake')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fluid_intake_unit" class="form-label">Fluid Intake Unit</label>
                    <select id="fluid_intake_unit" name="fluid_intake_unit" class="form-select">
                        <option value="mL" {{ old('fluid_intake_unit', $fluidBalanceReading->fluid_intake_unit ?? 'mL') == 'mL' ? 'selected' : '' }}>mL</option>
                        <option value="L" {{ old('fluid_intake_unit', $fluidBalanceReading->fluid_intake_unit) == 'L' ? 'selected' : '' }}>L</option>
                        <option value="oz" {{ old('fluid_intake_unit', $fluidBalanceReading->fluid_intake_unit) == 'oz' ? 'selected' : '' }}>oz</option>
                    </select>
                    @error('fluid_intake_unit')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Fluid Output</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="fluid_output" class="form-label">Fluid Output</label>
                    <input type="number" id="fluid_output" name="fluid_output" class="form-input" value="{{ old('fluid_output', $fluidBalanceReading->fluid_output) }}" min="0" max="10000" step="0.01">
                    @error('fluid_output')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fluid_output_unit" class="form-label">Fluid Output Unit</label>
                    <select id="fluid_output_unit" name="fluid_output_unit" class="form-select">
                        <option value="mL" {{ old('fluid_output_unit', $fluidBalanceReading->fluid_output_unit ?? 'mL') == 'mL' ? 'selected' : '' }}>mL</option>
                        <option value="L" {{ old('fluid_output_unit', $fluidBalanceReading->fluid_output_unit) == 'L' ? 'selected' : '' }}>L</option>
                        <option value="oz" {{ old('fluid_output_unit', $fluidBalanceReading->fluid_output_unit) == 'oz' ? 'selected' : '' }}>oz</option>
                    </select>
                    @error('fluid_output_unit')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="form-section-title">Net Balance</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="net_balance" class="form-label">Net Balance</label>
                    <input type="number" id="net_balance" name="net_balance" class="form-input" value="{{ old('net_balance', $fluidBalanceReading->net_balance) }}" step="0.01" readonly style="background-color: var(--md-sys-color-surface-variant);">
                    <p class="form-hint">Calculated automatically (Intake - Output)</p>
                    @error('net_balance')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="net_balance_unit" class="form-label">Net Balance Unit</label>
                    <select id="net_balance_unit" name="net_balance_unit" class="form-select">
                        <option value="mL" {{ old('net_balance_unit', $fluidBalanceReading->net_balance_unit ?? 'mL') == 'mL' ? 'selected' : '' }}>mL</option>
                        <option value="L" {{ old('net_balance_unit', $fluidBalanceReading->net_balance_unit) == 'L' ? 'selected' : '' }}>L</option>
                        <option value="oz" {{ old('net_balance_unit', $fluidBalanceReading->net_balance_unit) == 'oz' ? 'selected' : '' }}>oz</option>
                    </select>
                    @error('net_balance_unit')
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
                    <textarea id="symptoms" name="symptoms" class="form-textarea" rows="4" placeholder="Enter any symptoms or notes...">{{ old('symptoms', $fluidBalanceReading->symptoms) }}</textarea>
                    @error('symptoms')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('patients.fluid-balance-readings.index', $patient) }}" class="mdc-button mdc-button--outlined" tabindex="-1">Cancel</a>
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

    .form-hint {
        font-size: 12px;
        color: var(--md-sys-color-on-surface-variant);
        margin-top: 6px;
        line-height: 1.5;
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
    // Auto-calculate net balance
    document.getElementById('fluid_intake')?.addEventListener('input', calculateNetBalance);
    document.getElementById('fluid_output')?.addEventListener('input', calculateNetBalance);
    document.getElementById('fluid_intake_unit')?.addEventListener('change', updateNetBalanceUnit);
    document.getElementById('fluid_output_unit')?.addEventListener('change', updateNetBalanceUnit);

    function calculateNetBalance() {
        const intake = parseFloat(document.getElementById('fluid_intake')?.value) || 0;
        const output = parseFloat(document.getElementById('fluid_output')?.value) || 0;
        const netBalanceInput = document.getElementById('net_balance');

        if (netBalanceInput) {
            const netBalance = intake - output;
            netBalanceInput.value = netBalance.toFixed(2);
        }
    }

    function updateNetBalanceUnit() {
        const intakeUnit = document.getElementById('fluid_intake_unit')?.value;
        const outputUnit = document.getElementById('fluid_output_unit')?.value;
        const netBalanceUnit = document.getElementById('net_balance_unit');

        if (netBalanceUnit) {
            // Use intake unit if available, otherwise use output unit
            netBalanceUnit.value = intakeUnit || outputUnit || 'mL';
        }
    }

    // Calculate on page load
    calculateNetBalance();
</script>
@endpush

