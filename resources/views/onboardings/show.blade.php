@extends('layouts.app')

@section('title', 'Onboarding Details')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div>
            <h1 class="page-title">Onboarding Details</h1>
            <p class="page-subtitle">{{ $onboarding->title }}</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('onboardings.edit', $onboarding) }}" class="mdc-button">
                Edit
            </a>
            <a href="{{ route('onboardings.index') }}" class="mdc-button mdc-button--outlined">
                Back
            </a>
        </div>
    </div>
</div>

<div class="details-grid">
    <div class="card">
        <div class="card-header-section">
            <h3 class="card-title">Image</h3>
        </div>
        <div class="image-display">
            @if($onboarding->image)
                <img src="{{ Storage::url($onboarding->image) }}" alt="{{ $onboarding->title }}" class="detail-image">
            @else
                <div class="no-image-placeholder">
                    <span class="material-symbols-outlined">image</span>
                    <p>No image uploaded</p>
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header-section">
            <h3 class="card-title">Content Information</h3>
        </div>
        <div class="detail-grid">
            <div class="detail-item">
                <label class="detail-label">Title</label>
                <p class="detail-value">{{ $onboarding->title }}</p>
            </div>
            <div class="detail-item" style="grid-column: 1 / -1;">
                <label class="detail-label">Text</label>
                <p class="detail-value">{{ $onboarding->text }}</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header-section">
            <h3 class="card-title">Settings</h3>
        </div>
        <div class="detail-grid">
            <div class="detail-item">
                <label class="detail-label">Order</label>
                <p class="detail-value">{{ $onboarding->order }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Status</label>
                <div>
                    @if($onboarding->is_active)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-warning">Inactive</span>
                    @endif
                </div>
            </div>
            <div class="detail-item">
                <label class="detail-label">Created At</label>
                <p class="detail-value">{{ $onboarding->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div class="detail-item">
                <label class="detail-label">Last Updated</label>
                <p class="detail-value">{{ $onboarding->updated_at->format('M d, Y H:i') }}</p>
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

    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 24px;
    }

    .card {
        background: var(--md-sys-color-surface);
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--md-sys-color-outline);
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
    }

    .image-display {
        text-align: center;
    }

    .detail-image {
        max-width: 100%;
        max-height: 400px;
        border-radius: 12px;
        border: 1px solid var(--md-sys-color-outline);
        object-fit: contain;
    }

    .no-image-placeholder {
        padding: 60px 20px;
        background: var(--md-sys-color-surface-variant);
        border-radius: 12px;
        border: 2px dashed var(--md-sys-color-outline);
    }

    .no-image-placeholder .material-symbols-outlined {
        font-size: 64px;
        color: var(--md-sys-color-on-surface-variant);
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .no-image-placeholder p {
        color: var(--md-sys-color-on-surface-variant);
        font-size: 14px;
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
        line-height: 1.6;
    }

    .badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
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

    .mdc-button--outlined {
        background-color: #1C1B1F;
        border: 2px solid #1C1B1F;
        color: #FFFFFF;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .mdc-button--outlined:hover {
        background-color: #313033;
        border-color: #313033;
        color: #FFFFFF;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        transform: translateY(-1px);
    }
</style>
@endpush

