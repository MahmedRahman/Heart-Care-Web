@extends('layouts.app')

@section('title', 'Patient Details')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">Patient Details</h1>
            <p class="page-subtitle">{{ $patient->full_name }}</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('patients.heart-rate-readings.index', $patient) }}" class="mdc-button btn-heart-rate" style="background: linear-gradient(135deg, #C62828 0%, #E53935 100%); text-decoration: none;">
                <span class="material-symbols-outlined">favorite</span>
                Heart Rate Readings
            </a>
            <a href="{{ route('patients.edit', $patient) }}" class="mdc-button btn-edit-patient" style="text-decoration: none;">
                <span class="material-symbols-outlined">edit</span>
                Edit Patient
            </a>
            <a href="{{ route('patients.index') }}" class="mdc-button mdc-button--outlined btn-back" style="text-decoration: none;">
                <span class="material-symbols-outlined">arrow_back</span>
                Back
            </a>
        </div>
    </div>
</div>

<!-- Patient Profile Header -->
<div class="patient-profile-header">
    <div class="patient-avatar-section">
        <div class="patient-avatar-large">
            @if($patient->profile_image)
                <img src="{{ Storage::url($patient->profile_image) }}" alt="{{ $patient->full_name }}" class="profile-image">
            @else
                <div class="avatar-initials">{{ strtoupper(substr($patient->first_name, 0, 1)) }}{{ strtoupper(substr($patient->last_name, 0, 1)) }}</div>
            @endif
        </div>
        <div class="profile-completion-card">
            <div class="completion-header">
                <span class="material-symbols-outlined">task_alt</span>
                <span>Profile Completion</span>
            </div>
            <div class="completion-progress">
                <div class="progress-bar-wrapper">
                    <div class="progress-bar-fill" style="width: {{ $patient->profile_completion_percentage }}%"></div>
                </div>
                <span class="completion-percentage">{{ $patient->profile_completion_percentage }}%</span>
            </div>
        </div>
    </div>
    <div class="patient-info-header">
        <h2>{{ $patient->full_name }}</h2>
        <p class="patient-email">{{ $patient->email }}</p>
        <div class="patient-badges">
            <span class="badge badge-info">
                <span class="material-symbols-outlined">badge</span>
                {{ $patient->hospital_id }}
            </span>
            @if($patient->email_verified && $patient->mobile_verified)
                <span class="badge badge-success">
                    <span class="material-symbols-outlined">verified</span>
                    Fully Verified
                </span>
            @else
                <span class="badge badge-warning">
                    <span class="material-symbols-outlined">pending</span>
                    Pending Verification
                </span>
            @endif
        </div>
    </div>
</div>

<!-- Details Grid -->
<div class="details-grid">
    <!-- Personal Information -->
    <div class="card">
        <div class="card-header-section">
            <h3 class="card-title">
                <span class="material-symbols-outlined">person</span>
                Personal Information
            </h3>
        </div>
        <div class="detail-grid">
            <div class="detail-item">
                <label class="detail-label">First Name</label>
                <p class="detail-value">{{ $patient->first_name }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Last Name</label>
                <p class="detail-value">{{ $patient->last_name }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Date of Birth</label>
                <p class="detail-value">{{ $patient->date_of_birth ? $patient->date_of_birth->format('M d, Y') : 'N/A' }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Gender</label>
                <p class="detail-value">{{ $patient->gender ? ucfirst($patient->gender) : 'N/A' }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Age</label>
                <p class="detail-value">{{ $patient->age ?? 'N/A' }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Race</label>
                <p class="detail-value">{{ $patient->race ? ucfirst(str_replace('_', ' ', $patient->race)) : 'N/A' }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Marital State</label>
                <p class="detail-value">{{ $patient->marital_state ? ucfirst($patient->marital_state) : 'N/A' }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Language</label>
                <p class="detail-value">{{ $patient->language ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="card">
        <div class="card-header-section">
            <h3 class="card-title">
                <span class="material-symbols-outlined">contact_mail</span>
                Contact Information
            </h3>
        </div>
        <div class="detail-grid">
            <div class="detail-item">
                <label class="detail-label">Email Address</label>
                <p class="detail-value">{{ $patient->email }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Mobile Number</label>
                <p class="detail-value">{{ $patient->mobile_number }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Hospital ID</label>
                <p class="detail-value">{{ $patient->hospital_id }}</p>
            </div>
        </div>
    </div>

    <!-- Verification Status -->
    <div class="card">
        <div class="card-header-section">
            <h3 class="card-title">
                <span class="material-symbols-outlined">verified</span>
                Verification Status
            </h3>
        </div>
        <div class="detail-grid">
            <div class="detail-item">
                <label class="detail-label">Email Verification</label>
                <div>
                    @if($patient->email_verified)
                        <span class="badge badge-success">
                            <span class="material-symbols-outlined">check_circle</span>
                            Verified
                        </span>
                        @if($patient->email_verified_at)
                            <p class="detail-meta">Verified on: {{ $patient->email_verified_at->format('M d, Y H:i') }}</p>
                        @endif
                    @else
                        <span class="badge badge-warning">
                            <span class="material-symbols-outlined">cancel</span>
                            Not Verified
                        </span>
                    @endif
                </div>
            </div>
            <div class="detail-item">
                <label class="detail-label">Mobile Verification</label>
                <div>
                    @if($patient->mobile_verified)
                        <span class="badge badge-success">
                            <span class="material-symbols-outlined">check_circle</span>
                            Verified
                        </span>
                        @if($patient->mobile_verified_at)
                            <p class="detail-meta">Verified on: {{ $patient->mobile_verified_at->format('M d, Y H:i') }}</p>
                        @endif
                    @else
                        <span class="badge badge-warning">
                            <span class="material-symbols-outlined">cancel</span>
                            Not Verified
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Address Information -->
    <div class="card">
        <div class="card-header-section">
            <h3 class="card-title">
                <span class="material-symbols-outlined">home</span>
                Address Information
            </h3>
        </div>
        <div class="detail-grid">
            <div class="detail-item">
                <label class="detail-label">Country</label>
                <p class="detail-value">{{ $patient->country ?? 'N/A' }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">City</label>
                <p class="detail-value">{{ $patient->city ?? 'N/A' }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Address Area</label>
                <p class="detail-value">{{ $patient->address_area ?? 'N/A' }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Address Street</label>
                <p class="detail-value">{{ $patient->address_street ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Physical Measurements -->
    <div class="card">
        <div class="card-header-section">
            <h3 class="card-title">
                <span class="material-symbols-outlined">monitor_weight</span>
                Physical Measurements
            </h3>
        </div>
        <div class="detail-grid">
            <div class="detail-item">
                <label class="detail-label">Weight (kg)</label>
                <p class="detail-value">{{ $patient->weight ?? 'N/A' }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Height (cm)</label>
                <p class="detail-value">{{ $patient->height ?? 'N/A' }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">BSA</label>
                <p class="detail-value">{{ $patient->bsa ?? 'N/A' }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">BMI</label>
                <p class="detail-value">{{ $patient->bmi ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Health Information -->
    <div class="card">
        <div class="card-header-section">
            <h3 class="card-title">
                <span class="material-symbols-outlined">medical_services</span>
                Health Information
            </h3>
        </div>
        <div class="detail-grid">
            <div class="detail-item" style="grid-column: 1 / -1;">
                <label class="detail-label">Primary Diagnosis</label>
                <p class="detail-value">{{ $patient->primary_diagnosis ?? 'N/A' }}</p>
            </div>
            <div class="detail-item" style="grid-column: 1 / -1;">
                <label class="detail-label">Secondary Diagnosis</label>
                <div class="chips-display">
                    @if($patient->secondary_diagnosis && is_array($patient->secondary_diagnosis) && count($patient->secondary_diagnosis) > 0)
                        @foreach($patient->secondary_diagnosis as $diagnosis)
                            <span class="chip-display">{{ $diagnosis }}</span>
                        @endforeach
                    @else
                        <p class="detail-value">N/A</p>
                    @endif
                </div>
            </div>
            <div class="detail-item" style="grid-column: 1 / -1;">
                <label class="detail-label">Tertiary Diagnosis</label>
                <div class="chips-display">
                    @if($patient->tertiary_diagnosis && is_array($patient->tertiary_diagnosis) && count($patient->tertiary_diagnosis) > 0)
                        @foreach($patient->tertiary_diagnosis as $diagnosis)
                            <span class="chip-display">{{ $diagnosis }}</span>
                        @endforeach
                    @else
                        <p class="detail-value">N/A</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Hospital & Care Team -->
    <div class="card">
        <div class="card-header-section">
            <h3 class="card-title">
                <span class="material-symbols-outlined">local_hospital</span>
                Hospital & Care Team
            </h3>
        </div>
        <div class="detail-grid">
            <div class="detail-item">
                <label class="detail-label">Clinic Name</label>
                <p class="detail-value">{{ $patient->clinic_name ?? 'N/A' }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Physician/Team Name</label>
                <p class="detail-value">{{ $patient->physician_team_name ?? 'N/A' }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Nurse Name</label>
                <p class="detail-value">{{ $patient->nurse_name ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Next of Kin -->
    <div class="card">
        <div class="card-header-section">
            <h3 class="card-title">
                <span class="material-symbols-outlined">emergency</span>
                Next of Kin
            </h3>
        </div>
        <div class="detail-grid">
            <div class="detail-item">
                <label class="detail-label">Name</label>
                <p class="detail-value">{{ $patient->next_of_kin ?? 'N/A' }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Phone</label>
                <p class="detail-value">{{ $patient->next_of_kin_phone ?? 'N/A' }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Email</label>
                <p class="detail-value">{{ $patient->next_of_kin_email ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Account Information -->
    <div class="card">
        <div class="card-header-section">
            <h3 class="card-title">
                <span class="material-symbols-outlined">schedule</span>
                Account Information
            </h3>
        </div>
        <div class="detail-grid">
            <div class="detail-item">
                <label class="detail-label">Patient ID</label>
                <p class="detail-value">#{{ $patient->id }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Created At</label>
                <p class="detail-value">{{ $patient->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Last Updated</label>
                <p class="detail-value">{{ $patient->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>
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

    /* Patient Profile Header */
    .patient-profile-header {
        background: linear-gradient(135deg, #0D268D 0%, #1E3A8A 100%);
        border-radius: 24px;
        padding: 40px;
        margin-bottom: 32px;
        display: flex;
        align-items: flex-start;
        gap: 32px;
        box-shadow: 0 8px 32px rgba(13, 38, 141, 0.3);
        position: relative;
        overflow: hidden;
    }

    .patient-profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        pointer-events: none;
    }

    .patient-avatar-section {
        display: flex;
        flex-direction: column;
        gap: 20px;
        position: relative;
        z-index: 1;
    }

    .patient-avatar-large {
        width: 120px;
        height: 120px;
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: 700;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        border: 3px solid rgba(255, 255, 255, 0.3);
    }

    .patient-avatar-large .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-initials {
        font-size: 48px;
        font-weight: 700;
        color: white;
    }

    .profile-completion-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 16px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        min-width: 200px;
    }

    .completion-header {
        display: flex;
        align-items: center;
        gap: 8px;
        color: white;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .completion-header .material-symbols-outlined {
        font-size: 20px;
    }

    .completion-progress {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .progress-bar-wrapper {
        flex: 1;
        height: 8px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #4CAF50 0%, #8BC34A 100%);
        border-radius: 10px;
        transition: width 0.3s ease;
        box-shadow: 0 2px 8px rgba(76, 175, 80, 0.4);
    }

    .completion-percentage {
        color: white;
        font-size: 16px;
        font-weight: 700;
        min-width: 45px;
    }

    .patient-info-header {
        flex: 1;
        position: relative;
        z-index: 1;
    }

    .patient-info-header h2 {
        color: white;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .patient-email {
        color: rgba(255, 255, 255, 0.9);
        font-size: 16px;
        margin-bottom: 20px;
    }

    .patient-badges {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    /* Details Grid */
    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
        gap: 24px;
    }

    .card {
        background: var(--md-sys-color-surface);
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--md-sys-color-outline);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    }

    .card-header-section {
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid var(--md-sys-color-outline);
    }

    .card-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--md-sys-color-on-surface);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card-title .material-symbols-outlined {
        font-size: 24px;
        color: var(--md-sys-color-primary);
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 24px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .detail-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--md-sys-color-on-surface-variant);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 16px;
        font-weight: 500;
        color: var(--md-sys-color-on-surface);
        line-height: 1.5;
    }

    .detail-meta {
        font-size: 12px;
        color: var(--md-sys-color-on-surface-variant);
        margin-top: 6px;
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .badge-success {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .badge-warning {
        background: #FFF3E0;
        color: #F57C00;
    }

    .badge-info {
        background: #E3F2FD;
        color: #1976D2;
    }

    .badge .material-symbols-outlined {
        font-size: 18px;
    }

    /* Chips */
    .chips-display {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .chip-display {
        display: inline-block;
        padding: 8px 16px;
        background: var(--md-sys-color-primary-container);
        color: var(--md-sys-color-on-primary-container);
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }

    /* Buttons */
    .mdc-button {
        text-decoration: none !important;
    }

    .mdc-button:hover {
        text-decoration: none !important;
    }

    .btn-heart-rate {
        color: white !important;
        text-decoration: none !important;
    }

    .btn-heart-rate:hover {
        color: white !important;
        text-decoration: none !important;
    }

    .btn-edit-patient {
        text-decoration: none !important;
    }

    .btn-edit-patient:hover {
        text-decoration: none !important;
    }

    .mdc-button--outlined {
        background-color: #1C1B1F;
        border: 2px solid #1C1B1F;
        color: white !important;
        box-shadow: none;
        text-decoration: none !important;
    }

    .mdc-button--outlined:hover {
        background-color: #2C2B2F;
        border-color: #2C2B2F;
        color: white !important;
        box-shadow: none;
        text-decoration: none !important;
    }

    .btn-back {
        color: white !important;
        text-decoration: none !important;
    }

    .btn-back:hover {
        color: white !important;
        text-decoration: none !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .patient-profile-header {
            flex-direction: column;
            text-align: center;
            padding: 32px 24px;
        }

        .patient-avatar-section {
            align-items: center;
        }

        .patient-info-header {
            text-align: center;
        }

        .details-grid {
            grid-template-columns: 1fr;
        }

        .page-header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
