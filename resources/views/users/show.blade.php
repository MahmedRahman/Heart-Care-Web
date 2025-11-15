@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">User Details</h1>
            <p class="page-subtitle">{{ $user->name }}</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('users.edit', $user) }}" class="mdc-button">
                <span class="material-symbols-outlined" style="font-size: 20px; margin-right: 8px;">edit</span>
                Edit
            </a>
            <a href="{{ route('users.index') }}" class="mdc-button mdc-button--outlined">Back</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="detail-section">
        <h2 class="detail-section-title">User Information</h2>
        <div class="detail-grid">
            <div class="detail-item">
                <label class="detail-label">Name</label>
                <p class="detail-value">{{ $user->name }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Email</label>
                <p class="detail-value">{{ $user->email }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">User Type</label>
                <p class="detail-value">
                    @if($user->user_type)
                        <span style="text-transform: capitalize;">{{ $user->user_type }}</span>
                    @else
                        N/A
                    @endif
                </p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Phone Number</label>
                <p class="detail-value">{{ $user->phone ?? 'N/A' }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Created At</label>
                <p class="detail-value">{{ $user->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Last Updated</label>
                <p class="detail-value">{{ $user->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
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

    .detail-section {
        margin-bottom: 32px;
    }

    .detail-section-title {
        font-size: 20px;
        font-weight: 500;
        color: var(--md-sys-color-on-surface);
        margin-bottom: 24px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .detail-label {
        font-size: 12px;
        font-weight: 500;
        color: var(--md-sys-color-on-surface-variant);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 16px;
        color: var(--md-sys-color-on-surface);
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
</style>
@endpush

