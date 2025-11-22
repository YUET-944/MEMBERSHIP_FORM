@extends('layouts.app')

@section('title', 'Member Details')

@push('styles')
<style>
    .member-detail-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .detail-actions {
        display: flex;
        gap: 1rem;
    }
    
    .detail-card {
        background: var(--bg-white);
        border-radius: var(--radius-lg);
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        margin-bottom: 2rem;
    }
    
    .detail-section-title {
        font-family: var(--font-serif);
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--border-light);
    }
    
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    
    .detail-item {
        padding: 1rem;
        background: var(--bg-light-gray);
        border-radius: var(--radius-md);
    }
    
    .detail-label {
        font-size: 0.875rem;
        color: var(--text-gray);
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    
    .detail-value {
        font-size: 1rem;
        color: var(--text-charcoal);
        font-weight: 600;
    }
    
    .masked-value {
        font-family: var(--font-mono);
        color: var(--text-gray);
        font-size: 0.875rem;
    }
    
    .document-list {
        display: grid;
        gap: 1rem;
    }
    
    .document-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: var(--bg-light-gray);
        border-radius: var(--radius-md);
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }
    
    .document-item:hover {
        border-color: var(--primary-green);
        background: rgba(30, 77, 43, 0.05);
    }
    
    .document-info {
        flex: 1;
    }
    
    .document-name {
        font-weight: 600;
        color: var(--text-charcoal);
        margin-bottom: 0.25rem;
    }
    
    .document-meta {
        font-size: 0.875rem;
        color: var(--text-gray);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, var(--bg-cream) 0%, var(--bg-white) 50%, var(--bg-light-gray) 100%);">
    <div class="member-detail-container">
        <!-- Header -->
        <div class="detail-header">
            <div>
                <h1 class="page-title">Member Details</h1>
                <p class="dashboard-subtitle">View and manage member information</p>
            </div>
            <div class="detail-actions">
                <a href="{{ route('admin.members.index') }}" class="btn-secondary">Back to List</a>
                @if($member->status === 'pending')
                    <form action="{{ route('admin.members.approve', $member->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-primary">Approve Member</button>
                    </form>
                    <button type="button" onclick="showRejectModal()" class="btn-coral">Reject Member</button>
                @endif
            </div>
        </div>
        
        <!-- Personal Information -->
        <div class="detail-card">
            <h2 class="detail-section-title">Personal Information</h2>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Full Name</div>
                    <div class="detail-value">{{ $member->full_name ?? 'N/A' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Membership ID</div>
                    <div class="detail-value" style="font-family: var(--font-mono);">{{ $member->membership_id ?? 'N/A' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Email</div>
                    <div class="detail-value masked-value">{{ $member->email ?? 'N/A' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Phone</div>
                    <div class="detail-value masked-value">{{ $member->phone ?? 'N/A' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">CNIC</div>
                    <div class="detail-value masked-value">{{ $member->cnic ?? 'N/A' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Date of Birth</div>
                    <div class="detail-value">{{ $member->date_of_birth ? $member->date_of_birth->format('M d, Y') : 'N/A' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Gender</div>
                    <div class="detail-value">{{ ucfirst($member->gender ?? 'N/A') }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Education</div>
                    <div class="detail-value">{{ ucfirst($member->education ?? 'N/A') }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Profession</div>
                    <div class="detail-value">{{ $member->profession ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
        
        <!-- Address Information -->
        <div class="detail-card">
            <h2 class="detail-section-title">Address Information</h2>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Province</div>
                    <div class="detail-value">{{ $member->province ?? 'N/A' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Division</div>
                    <div class="detail-value">{{ $member->division ?? 'N/A' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">District</div>
                    <div class="detail-value">{{ $member->district ?? 'N/A' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Tehsil/City</div>
                    <div class="detail-value">{{ $member->tehsil_city ?? 'N/A' }}</div>
                </div>
                <div class="detail-item md:col-span-2">
                    <div class="detail-label">Current Address</div>
                    <div class="detail-value">{{ $member->current_address ?? 'N/A' }}</div>
                </div>
                <div class="detail-item md:col-span-2">
                    <div class="detail-label">Permanent Address</div>
                    <div class="detail-value">{{ $member->permanent_address ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
        
        <!-- Membership Status -->
        <div class="detail-card">
            <h2 class="detail-section-title">Membership Status</h2>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        <span class="status-badge {{ $member->status }}">{{ ucfirst($member->status) }}</span>
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Registered On</div>
                    <div class="detail-value">{{ $member->created_at ? $member->created_at->format('M d, Y') : 'N/A' }}</div>
                </div>
                @if($member->approved_at)
                <div class="detail-item">
                    <div class="detail-label">Approved On</div>
                    <div class="detail-value">{{ $member->approved_at->format('M d, Y') }}</div>
                </div>
                @endif
                @if($member->rejection_reason)
                <div class="detail-item md:col-span-2">
                    <div class="detail-label">Rejection Reason</div>
                    <div class="detail-value" style="color: var(--accent-coral);">{{ $member->rejection_reason }}</div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Documents -->
        @if($member->documents && $member->documents->count() > 0)
        <div class="detail-card">
            <h2 class="detail-section-title">Documents</h2>
            <div class="document-list">
                @foreach($member->documents as $document)
                <div class="document-item">
                    <div class="document-info">
                        <div class="document-name">{{ $document->document_type ?? 'Document' }}</div>
                        <div class="document-meta">
                            Uploaded: {{ $document->created_at->format('M d, Y') }} • 
                            Status: <span class="status-badge {{ $document->is_verified ? 'approved' : 'pending' }}">
                                {{ $document->is_verified ? 'Verified' : 'Pending' }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('admin.members.document.view', ['member' => $member->id, 'document' => $document->id]) }}" 
                           class="btn-view" target="_blank">View Document</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: var(--bg-white); border-radius: var(--radius-lg); padding: 2rem; max-width: 500px; width: 90%; box-shadow: var(--shadow-2xl);">
        <h3 style="font-family: var(--font-serif); font-size: 1.5rem; font-weight: 700; color: var(--primary-green); margin-bottom: 1rem;">Reject Member</h3>
        <form action="{{ route('admin.members.reject', $member->id) }}" method="POST">
            @csrf
            <div class="premium-form-group">
                <textarea name="rejection_reason" id="rejection_reason" class="premium-textarea" placeholder=" " rows="4"></textarea>
                <label class="floating-label" style="top: 1.25rem;">Rejection Reason (Optional)</label>
            </div>
            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="button" onclick="hideRejectModal()" class="btn-secondary" style="flex: 1;">Cancel</button>
                <button type="submit" class="btn-coral" style="flex: 1;">Confirm Rejection</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    lucide.createIcons();
    
    function showRejectModal() {
        document.getElementById('rejectModal').style.display = 'flex';
    }
    
    function hideRejectModal() {
        document.getElementById('rejectModal').style.display = 'none';
    }
    
    // Close modal on outside click
    document.getElementById('rejectModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            hideRejectModal();
        }
    });
</script>
@endpush
@endsection

