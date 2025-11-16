@extends('layouts.app')

@section('title', 'Add New Prescription')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">Add New Prescription</h1>
            <p class="page-subtitle">{{ $patient->full_name }}</p>
        </div>
        <a href="{{ route('patients.prescriptions.index', $patient) }}" class="mdc-button mdc-button--outlined">
            Back to Prescriptions
        </a>
    </div>
</div>

<div class="card">
    <form action="{{ route('patients.prescriptions.store', $patient) }}" method="POST" class="form" enctype="multipart/form-data" id="prescription-form">
        @csrf

        <div class="form-section">
            <h3 class="form-section-title">Prescription Information</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="doctor_name" class="form-label">Doctor Name <span class="required">*</span></label>
                    <input type="text" id="doctor_name" name="doctor_name" class="form-input" value="{{ old('doctor_name') }}" required>
                    @error('doctor_name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="prescription_date" class="form-label">Prescription Date <span class="required">*</span></label>
                    <input type="date" id="prescription_date" name="prescription_date" class="form-input" value="{{ old('prescription_date', date('Y-m-d')) }}" required>
                    @error('prescription_date')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="section-header">
                <h3 class="form-section-title">Medicines</h3>
                <button type="button" onclick="addMedicine()" class="btn-add-medicine">
                    <span class="material-symbols-outlined">add</span>
                    Add Medicine
                </button>
            </div>
            <div id="medicines-container">
                <!-- Medicines will be added here dynamically -->
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('patients.prescriptions.index', $patient) }}" class="mdc-button mdc-button--outlined">Cancel</a>
            <button type="submit" class="mdc-button">Create Prescription</button>
        </div>
    </form>
</div>

<!-- Medicine Template (Hidden) -->
<template id="medicine-template">
    <div class="medicine-card" data-medicine-index="">
        <div class="medicine-card-header">
            <h4 class="medicine-card-title">Medicine <span class="medicine-number"></span></h4>
            <button type="button" onclick="removeMedicine(this)" class="btn-remove-medicine">
                <span class="material-symbols-outlined">delete</span>
            </button>
        </div>
        <div class="medicine-card-body">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Medicine Name</label>
                    <select name="medicines[INDEX][medicine_name]" class="form-select medicine-name-select" onchange="toggleOtherMedicine(this)">
                        <option value="">Select Medicine</option>
                        <option value="Aspirin">Aspirin</option>
                        <option value="Paracetamol">Paracetamol</option>
                        <option value="Ibuprofen">Ibuprofen</option>
                        <option value="Amoxicillin">Amoxicillin</option>
                        <option value="Metformin">Metformin</option>
                        <option value="Atorvastatin">Atorvastatin</option>
                        <option value="Lisinopril">Lisinopril</option>
                        <option value="Amlodipine">Amlodipine</option>
                        <option value="Omeprazole">Omeprazole</option>
                        <option value="Levothyroxine">Levothyroxine</option>
                        <option value="OTHER">Other</option>
                    </select>
                </div>
                <div class="form-group other-medicine-group" style="display: none;">
                    <label class="form-label">Add Other Medicine</label>
                    <input type="text" name="medicines[INDEX][other_medicine_name]" class="form-input" placeholder="Enter medicine name">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Medicine Image</label>
                    <input type="file" name="medicines[INDEX][medicine_image]" class="form-file" accept="image/*">
                </div>
                <div class="form-group">
                    <label class="form-label">Dose</label>
                    <select name="medicines[INDEX][dose]" class="form-select">
                        <option value="">Select Dose</option>
                        <option value="50mg">50mg</option>
                        <option value="100mg">100mg</option>
                        <option value="250mg">250mg</option>
                        <option value="500mg">500mg</option>
                        <option value="1g">1g</option>
                        <option value="5mg">5mg</option>
                        <option value="10mg">10mg</option>
                        <option value="20mg">20mg</option>
                        <option value="25mg">25mg</option>
                        <option value="50mg/ml">50mg/ml</option>
                        <option value="100mg/ml">100mg/ml</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Form</label>
                    <select name="medicines[INDEX][form]" class="form-select">
                        <option value="">Select Form</option>
                        <option value="Tablet">Tablet</option>
                        <option value="Capsule">Capsule</option>
                        <option value="Syrup">Syrup</option>
                        <option value="Injection">Injection</option>
                        <option value="Cream">Cream</option>
                        <option value="Ointment">Ointment</option>
                        <option value="Drops">Drops</option>
                        <option value="Spray">Spray</option>
                        <option value="Inhaler">Inhaler</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Route</label>
                    <select name="medicines[INDEX][route]" class="form-select">
                        <option value="">Select Route</option>
                        <option value="Oral">Oral</option>
                        <option value="Topical">Topical</option>
                        <option value="Intravenous">Intravenous</option>
                        <option value="Intramuscular">Intramuscular</option>
                        <option value="Subcutaneous">Subcutaneous</option>
                        <option value="Inhalation">Inhalation</option>
                        <option value="Nasal">Nasal</option>
                        <option value="Ophthalmic">Ophthalmic</option>
                        <option value="Otic">Otic</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Frequency</label>
                    <select name="medicines[INDEX][frequency]" class="form-select">
                        <option value="">Select Frequency</option>
                        <option value="Once daily">Once daily</option>
                        <option value="Twice daily">Twice daily</option>
                        <option value="Three times daily">Three times daily</option>
                        <option value="Four times daily">Four times daily</option>
                        <option value="Every 6 hours">Every 6 hours</option>
                        <option value="Every 8 hours">Every 8 hours</option>
                        <option value="Every 12 hours">Every 12 hours</option>
                        <option value="As needed">As needed</option>
                        <option value="Before meals">Before meals</option>
                        <option value="After meals">After meals</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Time (Multi-select)</label>
                    <div class="time-checkboxes">
                        <label class="checkbox-label">
                            <input type="checkbox" name="medicines[INDEX][time][]" value="08:00"> 8:00 AM
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="medicines[INDEX][time][]" value="12:00"> 12:00 PM
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="medicines[INDEX][time][]" value="18:00"> 6:00 PM
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="medicines[INDEX][time][]" value="22:00"> 10:00 PM
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Duration Value</label>
                    <input type="number" name="medicines[INDEX][duration_value]" class="form-input" min="1" placeholder="e.g., 7">
                </div>
                <div class="form-group">
                    <label class="form-label">Duration Unit</label>
                    <select name="medicines[INDEX][duration_unit]" class="form-select">
                        <option value="">Select Unit</option>
                        <option value="Days">Days</option>
                        <option value="Weeks">Weeks</option>
                        <option value="Months">Months</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="medicines[INDEX][start_date]" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Renewal Date</label>
                    <input type="date" name="medicines[INDEX][renewal_date]" class="form-input">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label class="form-label">Description</label>
                    <textarea name="medicines[INDEX][description]" class="form-textarea" rows="3" placeholder="Enter description..."></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label class="form-label">Special Instruction</label>
                    <input type="text" name="medicines[INDEX][special_instruction]" class="form-input" placeholder="Enter special instructions...">
                </div>
            </div>
        </div>
    </div>
</template>
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

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .form-section-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--md-sys-color-on-surface);
        padding-bottom: 12px;
        border-bottom: 2px solid var(--md-sys-color-outline);
        display: inline-block;
        width: 100%;
    }

    .btn-add-medicine {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: var(--md-sys-color-primary);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-add-medicine:hover {
        background: var(--md-sys-color-secondary);
        transform: translateY(-2px);
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
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

    .time-checkboxes {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        padding: 12px;
        background: var(--md-sys-color-surface-variant);
        border-radius: 12px;
        border: 2px solid var(--md-sys-color-outline-variant);
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        background: var(--md-sys-color-surface);
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
    }

    .checkbox-label:hover {
        background: var(--md-sys-color-primary-container);
    }

    .checkbox-label input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .form-error {
        display: block;
        font-size: 12px;
        color: #C62828;
        margin-top: 6px;
        line-height: 1.5;
        font-weight: 500;
    }

    .medicine-card {
        background: var(--md-sys-color-surface-variant);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        border: 2px solid var(--md-sys-color-outline);
    }

    .medicine-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--md-sys-color-outline);
    }

    .medicine-card-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--md-sys-color-on-surface);
        margin: 0;
    }

    .btn-remove-medicine {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background: #FFEBEE;
        color: #C62828;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-remove-medicine:hover {
        background: #C62828;
        color: white;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid var(--md-sys-color-outline);
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .card {
            padding: 24px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let medicineIndex = 0;

    function addMedicine() {
        const template = document.getElementById('medicine-template');
        const container = document.getElementById('medicines-container');
        const clone = template.content.cloneNode(true);
        
        // Replace INDEX with actual index
        clone.querySelectorAll('[name*="INDEX"]').forEach(input => {
            input.name = input.name.replace(/INDEX/g, medicineIndex);
        });
        
        clone.querySelector('.medicine-card').setAttribute('data-medicine-index', medicineIndex);
        clone.querySelector('.medicine-number').textContent = medicineIndex + 1;
        
        container.appendChild(clone);
        medicineIndex++;
    }

    function removeMedicine(button) {
        const medicineCard = button.closest('.medicine-card');
        medicineCard.remove();
        updateMedicineNumbers();
    }

    function updateMedicineNumbers() {
        const cards = document.querySelectorAll('.medicine-card');
        cards.forEach((card, index) => {
            card.querySelector('.medicine-number').textContent = index + 1;
        });
    }

    function toggleOtherMedicine(select) {
        const medicineCard = select.closest('.medicine-card');
        const otherGroup = medicineCard.querySelector('.other-medicine-group');
        if (select.value === 'OTHER') {
            otherGroup.style.display = 'block';
        } else {
            otherGroup.style.display = 'none';
            otherGroup.querySelector('input').value = '';
        }
    }

    // Add first medicine on page load
    document.addEventListener('DOMContentLoaded', function() {
        addMedicine();
    });
</script>
@endpush

