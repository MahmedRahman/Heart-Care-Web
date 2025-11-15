@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">App Settings</h1>
            <p class="page-subtitle">Manage application settings and configurations</p>
        </div>
    </div>
</div>

<div class="settings-grid">
    <div class="settings-card">
        <div class="settings-card-icon" style="background: linear-gradient(135deg, #0D268D 0%, #1E3FA8 100%);">
            <span class="material-symbols-outlined">account_circle</span>
        </div>
        <div class="settings-card-content">
            <h3 class="settings-card-title">Account Settings</h3>
            <p class="settings-card-description">Update your account information and preferences</p>
            <a href="#" class="settings-card-link">Manage Account</a>
        </div>
    </div>

    <div class="settings-card">
        <div class="settings-card-icon" style="background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);">
            <span class="material-symbols-outlined">slideshow</span>
        </div>
        <div class="settings-card-content">
            <h3 class="settings-card-title">Onboarding</h3>
            <p class="settings-card-description">Manage onboarding screens with images, titles, and text</p>
            <a href="{{ route('onboardings.index') }}" class="settings-card-link">Manage Onboarding</a>
        </div>
    </div>

    <div class="settings-card">
        <div class="settings-card-icon" style="background: linear-gradient(135deg, #F57C00 0%, #FF9800 100%);">
            <span class="material-symbols-outlined">notifications</span>
        </div>
        <div class="settings-card-content">
            <h3 class="settings-card-title">Notifications</h3>
            <p class="settings-card-description">Configure notification preferences and settings</p>
            <a href="#" class="settings-card-link">Configure</a>
        </div>
    </div>

    <div class="settings-card">
        <div class="settings-card-icon" style="background: linear-gradient(135deg, #C62828 0%, #E53935 100%);">
            <span class="material-symbols-outlined">medical_services</span>
        </div>
        <div class="settings-card-content">
            <h3 class="settings-card-title">Diagnoses</h3>
            <p class="settings-card-description">Manage diagnosis lookup table for primary, secondary, and tertiary diagnoses</p>
            <a href="{{ route('diagnoses.index') }}" class="settings-card-link">Manage Diagnoses</a>
        </div>
    </div>

    <div class="settings-card">
        <div class="settings-card-icon" style="background: linear-gradient(135deg, #7B1FA2 0%, #9C27B0 100%);">
            <span class="material-symbols-outlined">security</span>
        </div>
        <div class="settings-card-content">
            <h3 class="settings-card-title">Security</h3>
            <p class="settings-card-description">Manage security settings and password policies</p>
            <a href="#" class="settings-card-link">Security Settings</a>
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

    .settings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 24px;
    }

    .settings-card {
        background: var(--md-sys-color-surface);
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--md-sys-color-outline);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .settings-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .settings-card-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .settings-card-icon .material-symbols-outlined {
        color: white;
        font-size: 32px;
    }

    .settings-card-content {
        flex: 1;
    }

    .settings-card-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 8px;
    }

    .settings-card-description {
        font-size: 14px;
        color: var(--md-sys-color-on-surface-variant);
        margin-bottom: 16px;
        line-height: 1.6;
    }

    .settings-card-link {
        display: inline-block;
        color: var(--md-sys-color-primary);
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .settings-card-link:hover {
        color: var(--md-sys-color-secondary);
        text-decoration: underline;
    }
</style>
@endpush
