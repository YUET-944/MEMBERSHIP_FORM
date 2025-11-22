@extends('layouts.app')

@section('title', 'Member Dashboard')

@push('styles')
<style>
    .member-dashboard {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .dashboard-title {
        font-family: var(--font-serif);
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-green);
        margin: 0;
    }
    
    .dashboard-subtitle {
        color: var(--text-gray);
        font-size: 1rem;
        margin-top: 0.5rem;
    }
    
    .welcome-card {
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        border-radius: var(--radius-lg);
        padding: 2.5rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-xl);
        position: relative;
        overflow: hidden;
    }
    
    .welcome-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: pulse 3s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }
    
    .welcome-greeting {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .welcome-name {
        font-size: 2rem;
        font-weight: 700;
        font-family: var(--font-serif);
        margin-bottom: 1rem;
    }
    
    .membership-status-card {
        background: var(--bg-white);
        border-radius: var(--radius-lg);
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        margin-bottom: 2rem;
        border-left: 4px solid var(--primary-green);
    }
    
    .status-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .status-title {
        font-family: var(--font-serif);
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-green);
    }
    
    .status-badge-large {
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-xl);
        font-weight: 600;
        font-size: 1rem;
    }
    
    .status-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }
    
    .status-info-item {
        padding: 1rem;
        background: var(--bg-light-gray);
        border-radius: var(--radius-md);
    }
    
    .status-info-label {
        font-size: 0.875rem;
        color: var(--text-gray);
        margin-bottom: 0.5rem;
    }
    
    .status-info-value {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-charcoal);
        font-family: var(--font-mono);
    }
    
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .quick-action-card {
        background: var(--bg-white);
        border-radius: var(--radius-lg);
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        text-decoration: none;
        color: var(--text-charcoal);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 1rem;
    }
    
    .quick-action-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-2xl);
        border-color: var(--primary-green);
    }
    
    .quick-action-icon {
        width: 64px;
        height: 64px;
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(30, 77, 43, 0.1);
        color: var(--primary-green);
    }
    
    .quick-action-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-charcoal);
    }
    
    .quick-action-desc {
        font-size: 0.875rem;
        color: var(--text-gray);
    }
    
    .profile-overview {
        background: var(--bg-white);
        border-radius: var(--radius-lg);
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        margin-bottom: 2rem;
    }
    
    .profile-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid var(--border-light);
    }
    
    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--primary-green);
        box-shadow: var(--shadow-md);
    }
    
    .profile-info h3 {
        font-family: var(--font-serif);
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 0.5rem;
    }
    
    .profile-info p {
        color: var(--text-gray);
        font-size: 0.875rem;
    }
    
    .profile-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    
    .profile-detail-item {
        padding: 1rem;
        background: var(--bg-light-gray);
        border-radius: var(--radius-md);
    }
    
    .profile-detail-label {
        font-size: 0.875rem;
        color: var(--text-gray);
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    
    .profile-detail-value {
        font-size: 1rem;
        color: var(--text-charcoal);
        font-weight: 600;
    }
    
    .certificate-card {
        background: linear-gradient(135deg, var(--accent-gold), #f4d03f);
        border-radius: var(--radius-lg);
        padding: 2rem;
        color: var(--text-charcoal);
        box-shadow: var(--shadow-xl);
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .certificate-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        color: var(--text-charcoal);
    }
    
    .certificate-title {
        font-family: var(--font-serif);
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .certificate-desc {
        font-size: 1rem;
        margin-bottom: 1.5rem;
        opacity: 0.9;
    }
    
    .btn-certificate {
        background: var(--text-charcoal);
        color: white;
        padding: 1rem 2rem;
        border-radius: var(--radius-md);
        border: none;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-certificate:hover {
        background: var(--primary-green);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, var(--bg-cream) 0%, var(--bg-white) 50%, var(--bg-light-gray) 100%);">
    <div class="member-dashboard">
        <!-- Welcome Card -->
        <div class="welcome-card gradient-sweep magnetic-card glass-card-3d">
            <div style="position: relative; z-index: 1;">
                <div class="welcome-greeting">Welcome back!</div>
                <div class="welcome-name" style="background: linear-gradient(135deg, white, rgba(255, 255, 255, 0.9)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ $member->full_name ?? 'Member' }}</div>
                <p style="opacity: 0.9; font-size: 1rem;">Manage your membership profile and access your certificate</p>
            </div>
        </div>
        
        <!-- Membership Status Card -->
        <div class="membership-status-card emerald-corners magnetic-field glass-card-3d">
            <div class="status-header">
                <h2 class="ultra-h2">Membership Status</h2>
                <span class="status-badge-large status-badge {{ $member->status ?? 'pending' }} pulse">
                    {{ ucfirst($member->status ?? 'Pending') }}
                </span>
            </div>
            
            <div class="status-info-grid">
                <div class="status-info-item">
                    <div class="status-info-label">Membership ID</div>
                    <div class="status-info-value">{{ $member->membership_id ?? 'N/A' }}</div>
                </div>
                <div class="status-info-item">
                    <div class="status-info-label">Member Since</div>
                    <div class="status-info-value">{{ $member->created_at ? $member->created_at->format('M d, Y') : 'N/A' }}</div>
                </div>
                <div class="status-info-item">
                    <div class="status-info-label">Registration Date</div>
                    <div class="status-info-value">{{ $member->created_at ? $member->created_at->format('M d, Y') : 'N/A' }}</div>
                </div>
                @if($member->approved_at ?? null)
                <div class="status-info-item">
                    <div class="status-info-label">Approved On</div>
                    <div class="status-info-value">{{ $member->approved_at->format('M d, Y') }}</div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Certificate Card -->
        @if(($member->status ?? 'pending') === 'approved')
        <div class="certificate-card glass-card-3d">
            <i data-lucide="award" class="certificate-icon"></i>
            <h3 class="certificate-title">Membership Certificate</h3>
            <p class="certificate-desc">Download your official membership certificate in PDF format</p>
            <a href="{{ route('member.certificate.download') }}" class="btn-certificate">
                <i data-lucide="download" style="width: 20px; height: 20px; vertical-align: middle; margin-right: 0.5rem;"></i>
                Download Certificate
            </a>
        </div>
        @endif
        
        <!-- Quick Actions -->
        <div class="quick-actions-grid">
            <a href="{{ route('member.profile') }}" class="quick-action-card glass-card-3d">
                <div class="quick-action-icon">
                    <i data-lucide="user"></i>
                </div>
                <div class="quick-action-title">View Profile</div>
                <div class="quick-action-desc">View and update your personal information</div>
            </a>
            
            @if(($member->status ?? 'pending') === 'approved')
            <a href="{{ route('member.certificate.download') }}" class="quick-action-card glass-card-3d">
                <div class="quick-action-icon">
                    <i data-lucide="file-text"></i>
                </div>
                <div class="quick-action-title text-sharp">Certificate</div>
                <div class="quick-action-desc text-sharp">Download your membership certificate</div>
            </a>
            @endif
            
            <a href="{{ route('member.profile') }}" class="quick-action-card glass-card-3d">
                <div class="quick-action-icon">
                    <i data-lucide="settings"></i>
                </div>
                <div class="quick-action-title text-sharp">Settings</div>
                <div class="quick-action-desc text-sharp">Manage account settings and preferences</div>
            </a>
            
            <a href="#" class="quick-action-card glass-card-3d">
                <div class="quick-action-icon">
                    <i data-lucide="help-circle"></i>
                </div>
                <div class="quick-action-title text-sharp">Help & Support</div>
                <div class="quick-action-desc text-sharp">Get help with your membership</div>
            </a>
        </div>
        
        <!-- Profile Overview -->
        <div class="profile-overview glass-card-3d">
            <h2 class="section-header">Profile Overview</h2>
            
            <div class="profile-header">
                @if($member->profile_picture ?? null)
                    <img src="{{ asset('storage/' . $member->profile_picture) }}" alt="Profile" class="profile-avatar">
                @else
                    <div class="profile-avatar" style="background: linear-gradient(135deg, var(--primary-green), var(--accent-gold)); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: 700;">
                        {{ substr($member->first_name ?? 'M', 0, 1) }}{{ substr($member->last_name ?? 'M', 0, 1) }}
                    </div>
                @endif
                <div class="profile-info">
                    <h3>{{ $member->full_name ?? 'Member Name' }}</h3>
                    <p>Member since {{ $member->created_at ? $member->created_at->format('F Y') : 'N/A' }}</p>
                </div>
            </div>
            
            <div class="profile-details">
                <div class="profile-detail-item">
                    <div class="profile-detail-label">Email Address</div>
                    <div class="profile-detail-value">{{ $member->email ?? 'N/A' }}</div>
                </div>
                <div class="profile-detail-item">
                    <div class="profile-detail-label">Phone Number</div>
                    <div class="profile-detail-value">{{ $member->phone ?? 'N/A' }}</div>
                </div>
                <div class="profile-detail-item">
                    <div class="profile-detail-label">Education</div>
                    <div class="profile-detail-value">{{ ucfirst($member->education ?? 'N/A') }}</div>
                </div>
                <div class="profile-detail-item">
                    <div class="profile-detail-label">Profession</div>
                    <div class="profile-detail-value">{{ $member->profession ?? 'N/A' }}</div>
                </div>
                <div class="profile-detail-item">
                    <div class="profile-detail-label">Province</div>
                    <div class="profile-detail-value">{{ $member->province ?? 'N/A' }}</div>
                </div>
                <div class="profile-detail-item">
                    <div class="profile-detail-label">District</div>
                    <div class="profile-detail-value">{{ $member->district ?? 'N/A' }}</div>
                </div>
            </div>
            
            <div style="margin-top: 2rem; text-align: center;">
                <a href="{{ route('member.profile') }}" class="btn-primary">Edit Profile</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    lucide.createIcons();
</script>
@endpush
@endsection

