@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard Overview</h1>
        <p class="page-subtitle">Welcome back, {{ Auth::user()->name }}! Here's what's happening today.</p>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card stat-card-primary">
        <div class="stat-icon">
            <span class="material-symbols-outlined">people</span>
        </div>
        <div class="stat-content">
            <h3 class="stat-value">{{ \App\Models\Patient::count() }}</h3>
            <p class="stat-label">Total Patients</p>
            <p class="stat-change positive">
                <span class="material-symbols-outlined">trending_up</span>
                All time
            </p>
        </div>
    </div>

    <div class="stat-card stat-card-success">
        <div class="stat-icon">
            <span class="material-symbols-outlined">person</span>
        </div>
        <div class="stat-content">
            <h3 class="stat-value">{{ \App\Models\User::count() }}</h3>
            <p class="stat-label">Total Users</p>
            <p class="stat-change positive">
                <span class="material-symbols-outlined">trending_up</span>
                Active employees
            </p>
        </div>
    </div>

    <div class="stat-card stat-card-info">
        <div class="stat-icon">
            <span class="material-symbols-outlined">verified</span>
        </div>
        <div class="stat-content">
            <h3 class="stat-value">{{ \App\Models\Patient::where('email_verified', true)->count() }}</h3>
            <p class="stat-label">Verified Patients</p>
            <p class="stat-change positive">
                <span class="material-symbols-outlined">check_circle</span>
                Email verified
            </p>
        </div>
    </div>

    <div class="stat-card stat-card-warning">
        <div class="stat-icon">
            <span class="material-symbols-outlined">pending</span>
        </div>
        <div class="stat-content">
            <h3 class="stat-value">{{ \App\Models\Patient::where('email_verified', false)->orWhere('mobile_verified', false)->count() }}</h3>
            <p class="stat-label">Pending Verifications</p>
            <p class="stat-change negative">
                <span class="material-symbols-outlined">schedule</span>
                Needs attention
            </p>
        </div>
    </div>
</div>

<div class="quick-actions">
    <h2 class="section-title">Quick Actions</h2>
    <div class="actions-grid">
        <a href="{{ route('patients.create') }}" class="action-card">
            <div class="action-icon" style="background: linear-gradient(135deg, #0D268D 0%, #1E3FA8 100%);">
                <span class="material-symbols-outlined">person_add</span>
            </div>
            <h3>Add New Patient</h3>
            <p>Register a new patient to the system</p>
        </a>

        <a href="{{ route('patients.index') }}" class="action-card">
            <div class="action-icon" style="background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);">
                <span class="material-symbols-outlined">people</span>
            </div>
            <h3>View All Patients</h3>
            <p>Browse and manage patient records</p>
        </a>

        <a href="{{ route('users.create') }}" class="action-card">
            <div class="action-icon" style="background: linear-gradient(135deg, #F57C00 0%, #FF9800 100%);">
                <span class="material-symbols-outlined">person_add</span>
            </div>
            <h3>Add New User</h3>
            <p>Create a new employee account</p>
        </a>

        <a href="{{ route('users.index') }}" class="action-card">
            <div class="action-icon" style="background: linear-gradient(135deg, #7B1FA2 0%, #9C27B0 100%);">
                <span class="material-symbols-outlined">person</span>
            </div>
            <h3>Manage Users</h3>
            <p>View and edit employee accounts</p>
        </a>
    </div>
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

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: var(--md-sys-color-surface);
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--md-sys-color-outline);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, var(--md-sys-color-primary) 0%, var(--md-sys-color-secondary) 100%);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .stat-card-primary::before {
        background: linear-gradient(135deg, #0D268D 0%, #1E3FA8 100%);
    }

    .stat-card-success::before {
        background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
    }

    .stat-card-info::before {
        background: linear-gradient(135deg, #1976D2 0%, #2196F3 100%);
    }

    .stat-card-warning::before {
        background: linear-gradient(135deg, #F57C00 0%, #FF9800 100%);
    }

    .stat-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--md-sys-color-primary) 0%, var(--md-sys-color-secondary) 100%);
        flex-shrink: 0;
    }

    .stat-card-primary .stat-icon {
        background: linear-gradient(135deg, #0D268D 0%, #1E3FA8 100%);
    }

    .stat-card-success .stat-icon {
        background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
    }

    .stat-card-info .stat-icon {
        background: linear-gradient(135deg, #1976D2 0%, #2196F3 100%);
    }

    .stat-card-warning .stat-icon {
        background: linear-gradient(135deg, #F57C00 0%, #FF9800 100%);
    }

    .stat-icon .material-symbols-outlined {
        color: white;
        font-size: 32px;
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        font-size: 36px;
        font-weight: 700;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 4px;
        line-height: 1;
    }

    .stat-label {
        font-size: 14px;
        color: var(--md-sys-color-on-surface-variant);
        margin-bottom: 8px;
        font-weight: 500;
    }

    .stat-change {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        font-weight: 600;
    }

    .stat-change.positive {
        color: #2E7D32;
    }

    .stat-change.negative {
        color: #F57C00;
    }

    .stat-change .material-symbols-outlined {
        font-size: 16px;
    }

    .quick-actions {
        margin-top: 40px;
    }

    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 24px;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
    }

    .action-card {
        background: var(--md-sys-color-surface);
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--md-sys-color-outline);
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .action-icon {
        width: 72px;
        height: 72px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .action-icon .material-symbols-outlined {
        color: white;
        font-size: 36px;
    }

    .action-card h3 {
        font-size: 18px;
        font-weight: 600;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 8px;
    }

    .action-card p {
        font-size: 14px;
        color: var(--md-sys-color-on-surface-variant);
    }
</style>
@endpush
