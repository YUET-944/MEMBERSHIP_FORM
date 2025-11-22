@extends('layouts.app')

@section('title', 'My Profile')

@push('styles')
<style>
    .profile-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    .page-header {
        margin-bottom: 2rem;
    }
    
    .page-title {
        font-family: var(--font-serif);
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 0.5rem;
    }
    
    .profile-form {
        background: var(--bg-white);
        border-radius: var(--radius-lg);
        padding: 2.5rem;
        box-shadow: var(--shadow-lg);
    }
    
    .form-section-title {
        font-family: var(--font-serif);
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--border-light);
    }
    
    .read-only-field {
        background: var(--bg-light-gray);
        color: var(--text-gray);
        cursor: not-allowed;
    }
    
    .read-only-field:focus {
        border-color: var(--border-light);
        box-shadow: none;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, var(--bg-cream) 0%, var(--bg-white) 50%, var(--bg-light-gray) 100%);">
    <div class="profile-container">
        <div class="page-header">
            <h1 class="page-title">My Profile</h1>
            <p class="dashboard-subtitle">Update your personal information and preferences</p>
        </div>
        
        <div class="profile-form">
            <form method="POST" action="{{ route('member.profile.update') }}">
                @csrf
                
                <!-- Personal Information -->
                <h2 class="form-section-title">Personal Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="premium-form-group">
                        <input type="text" name="first_name" id="first_name" class="premium-input" value="{{ $member->first_name ?? '' }}" placeholder=" " required>
                        <label class="floating-label">First Name <span class="required">*</span></label>
                    </div>
                    
                    <div class="premium-form-group">
                        <input type="text" name="last_name" id="last_name" class="premium-input" value="{{ $member->last_name ?? '' }}" placeholder=" " required>
                        <label class="floating-label">Last Name <span class="required">*</span></label>
                    </div>
                    
                    <div class="premium-form-group md:col-span-2">
                        <input type="email" class="premium-input read-only-field" value="{{ $member->email ?? '' }}" placeholder=" " readonly>
                        <label class="floating-label">Email Address (Read-only)</label>
                    </div>
                    
                    <div class="premium-form-group">
                        <input type="text" name="profession" id="profession" class="premium-input" value="{{ $member->profession ?? '' }}" placeholder=" ">
                        <label class="floating-label">Profession</label>
                    </div>
                    
                    <div class="premium-form-group">
                        <select name="education" id="education" class="premium-select">
                            <option value="">Select Education</option>
                            <option value="matric" {{ ($member->education ?? '') === 'matric' ? 'selected' : '' }}>Matric</option>
                            <option value="intermediate" {{ ($member->education ?? '') === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="bachelor" {{ ($member->education ?? '') === 'bachelor' ? 'selected' : '' }}>Bachelor</option>
                            <option value="master" {{ ($member->education ?? '') === 'master' ? 'selected' : '' }}>Master</option>
                            <option value="phd" {{ ($member->education ?? '') === 'phd' ? 'selected' : '' }}>PhD</option>
                            <option value="other" {{ ($member->education ?? '') === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        <label class="floating-label">Education</label>
                    </div>
                </div>
                
                <!-- Account Information -->
                <h2 class="form-section-title">Account Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="premium-form-group">
                        <input type="text" class="premium-input read-only-field" value="{{ $member->membership_id ?? 'N/A' }}" placeholder=" " readonly>
                        <label class="floating-label">Membership ID (Read-only)</label>
                    </div>
                    
                    <div class="premium-form-group">
                        <input type="text" class="premium-input read-only-field" value="{{ ucfirst($member->status ?? 'pending') }}" placeholder=" " readonly>
                        <label class="floating-label">Membership Status (Read-only)</label>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('member.dashboard') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    lucide.createIcons();
    
    // Initialize floating labels for existing values
    document.querySelectorAll('.premium-input, .premium-select').forEach(field => {
        if (field.value) {
            field.classList.add('has-value');
        }
    });
</script>
@endpush
@endsection

