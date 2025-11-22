@extends('layouts.app')

@section('title', 'Admin Dashboard')

@push('styles')
<style>
    .admin-dashboard {
        max-width: 1600px;
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
    
    .header-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .recent-activity-section {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }
    
    @media (max-width: 1024px) {
        .recent-activity-section {
            grid-template-columns: 1fr;
        }
    }
    
    .activity-stream {
        background: var(--bg-white);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-lg);
    }
    
    .activity-item {
        display: flex;
        align-items: start;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-light);
        position: relative;
        padding-left: 2rem;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 1.5rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--accent-gold);
        border: 3px solid var(--bg-white);
        box-shadow: 0 0 0 2px var(--accent-gold);
    }
    
    .activity-item::after {
        content: '';
        position: absolute;
        left: 5px;
        top: 2rem;
        width: 2px;
        height: calc(100% - 0.5rem);
        background: linear-gradient(180deg, var(--accent-gold), transparent);
    }
    
    .activity-item:last-child::after {
        display: none;
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }
    
    .activity-icon.pending {
        background: rgba(255, 193, 7, 0.1);
        color: #f59e0b;
    }
    
    .activity-icon.approved {
        background: rgba(30, 77, 43, 0.1);
        color: var(--primary-green);
    }
    
    .activity-icon.rejected {
        background: rgba(255, 107, 107, 0.1);
        color: var(--accent-coral);
    }
    
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .quick-action-btn {
        padding: 1.5rem;
        background: var(--bg-white);
        border: 2px solid var(--border-light);
        border-radius: var(--radius-md);
        text-align: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        color: var(--text-charcoal);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
    }
    
    .quick-action-btn:hover {
        border-color: var(--primary-green);
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }
    
    .quick-action-btn i {
        width: 32px;
        height: 32px;
        color: var(--primary-green);
    }
    
    .quick-action-btn span {
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .pending-approvals-card {
        background: var(--bg-white);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-lg);
    }
    
    .pending-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: var(--bg-light-gray);
        border-radius: var(--radius-md);
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }
    
    .pending-item:hover {
        background: rgba(30, 77, 43, 0.05);
        transform: translateX(4px);
    }
    
    .pending-item:last-child {
        margin-bottom: 0;
    }
    
    .pending-item-info {
        flex: 1;
    }
    
    .pending-item-name {
        font-weight: 600;
        color: var(--text-charcoal);
        margin-bottom: 0.25rem;
    }
    
    .pending-item-meta {
        font-size: 0.875rem;
        color: var(--text-gray);
    }
    
    .pending-item-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        border-radius: var(--radius-md);
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-approve {
        background: var(--primary-green);
        color: white;
    }
    
    .btn-approve:hover {
        background: var(--secondary-green);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }
    
    .btn-reject {
        background: var(--accent-coral);
        color: white;
    }
    
    .btn-reject:hover {
        background: #ff5252;
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }
    
    .chart-container {
        background: var(--bg-white);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-lg);
        margin-bottom: 2rem;
    }
    
    .chart-placeholder {
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-gray);
        background: var(--bg-light-gray);
        border-radius: var(--radius-md);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, var(--bg-cream) 0%, var(--bg-white) 50%, var(--bg-light-gray) 100%);">
    <div class="admin-dashboard">
        <!-- Header -->
        <div class="dashboard-header">
            <div>
                <h1 class="ultra-h1 gold-signature active">Admin Dashboard</h1>
                <p class="dashboard-subtitle">Welcome back! Here's an overview of your membership system.</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.members.index') }}" class="btn-primary">Manage Members</a>
                <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-secondary">Logout</button>
                </form>
            </div>
        </div>
        
        <!-- Metrics -->
        <div class="metrics-grid">
            <div class="metric-diamond magnetic-card glass-card-3d stagger-reveal">
                <div class="metric-value" id="totalMembers" style="background: linear-gradient(135deg, var(--emerald-dark), var(--gold-primary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ number_format($stats['total_members'] ?? 0) }}</div>
                <div class="metric-label">Total Members</div>
            </div>
            
            <div class="metric-diamond">
                <div class="metric-value" id="pendingApprovals" style="color: #f59e0b;">{{ number_format($stats['pending_members'] ?? 0) }}</div>
                <div class="metric-label">Pending Approvals</div>
            </div>
            
            <div class="metric-diamond">
                <div class="metric-value" id="approvedMembers" style="color: var(--primary-green);">{{ number_format($stats['approved_members'] ?? 0) }}</div>
                <div class="metric-label">Approved Members</div>
            </div>
            
            <div class="metric-diamond">
                <div class="metric-value" id="rejectedMembers" style="color: var(--accent-coral);">{{ number_format($stats['rejected_members'] ?? 0) }}</div>
                <div class="metric-label">Rejected Members</div>
            </div>
        </div>
        
        <!-- Recent Activity & Pending Approvals -->
        <div class="recent-activity-section">
            <!-- Activity Stream -->
            <div class="activity-stream glass-card-3d">
                <h2 class="section-header">Recent Activity</h2>
                <div class="activity-list" id="activityList">
                    @php
                        $recentMembers = \App\Models\Member::latest()->take(5)->get();
                    @endphp
                    @forelse($recentMembers as $member)
                        <div class="activity-item">
                            <div class="activity-icon {{ $member->status }}">
                                <i data-lucide="{{ $member->status === 'approved' ? 'check-circle' : ($member->status === 'rejected' ? 'x-circle' : 'clock') }}"></i>
                            </div>
                            <div style="flex: 1;">
                                <p class="font-semibold text-gray-800">
                                    {{ $member->full_name }} 
                                    <span class="status-badge {{ $member->status }}">{{ ucfirst($member->status) }}</span>
                                </p>
                                <p class="text-sm text-gray-500">
                                    Membership ID: {{ $member->membership_id }} • {{ $member->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="activity-item">
                            <div>
                                <p class="font-semibold text-gray-800">No recent activity</p>
                                <p class="text-sm text-gray-500">Activity will appear here as members register</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Pending Approvals -->
            <div class="pending-approvals-card glass-card-3d">
                <h2 class="section-header">Pending Approvals</h2>
                @php
                    $pendingMembers = \App\Models\Member::where('status', 'pending')->latest()->take(5)->get();
                @endphp
                @forelse($pendingMembers as $member)
                    <div class="pending-item">
                        <div class="pending-item-info">
                            <div class="pending-item-name">{{ $member->full_name }}</div>
                            <div class="pending-item-meta">
                                ID: {{ $member->membership_id }} • {{ $member->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="pending-item-actions">
                            <form action="{{ route('admin.members.approve', $member->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-sm btn-approve">Approve</button>
                            </form>
                            <a href="{{ route('admin.members.show', $member->id) }}" class="btn-sm btn-secondary" style="padding: 0.5rem 1rem; text-decoration: none; background: var(--text-gray); color: white;">View</a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i data-lucide="check-circle" style="width: 48px; height: 48px; margin: 0 auto 1rem; color: var(--accent-green);"></i>
                        <p>No pending approvals</p>
                    </div>
                @endforelse
                
                @if($pendingMembers->count() > 0)
                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.members.index', ['status' => 'pending']) }}" class="btn-primary" style="display: inline-block;">View All Pending</a>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="{{ route('admin.members.index') }}" class="quick-action-btn glass-card-3d">
                <i data-lucide="users"></i>
                <span class="text-sharp">Manage Members</span>
            </a>
            <a href="{{ route('admin.members.index', ['status' => 'pending']) }}" class="quick-action-btn glass-card-3d">
                <i data-lucide="clock"></i>
                <span class="text-sharp">Pending Reviews</span>
            </a>
            <a href="{{ route('admin.members.index', ['status' => 'approved']) }}" class="quick-action-btn glass-card-3d">
                <i data-lucide="check-circle"></i>
                <span class="text-sharp">Approved Members</span>
            </a>
            <a href="#" class="quick-action-btn glass-card-3d">
                <i data-lucide="file-check"></i>
                <span class="text-sharp">Document Verification</span>
            </a>
            <a href="#" class="quick-action-btn glass-card-3d">
                <i data-lucide="bar-chart"></i>
                <span class="text-sharp">Reports & Analytics</span>
            </a>
            <a href="#" class="quick-action-btn glass-card-3d">
                <i data-lucide="settings"></i>
                <span class="text-sharp">System Settings</span>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endpush
@endsection
