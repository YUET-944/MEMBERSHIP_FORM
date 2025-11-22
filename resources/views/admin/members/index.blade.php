@extends('layouts.app')

@section('title', 'Member Management')

@push('styles')
<style>
    .members-container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .page-title {
        font-family: var(--font-serif);
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-green);
        margin: 0;
    }
    
    .filters-bar {
        background: var(--bg-white);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        margin-bottom: 2rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .filter-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-gray);
    }
    
    .filter-select {
        padding: 0.75rem 1rem;
        border: 2px solid var(--border-light);
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        background: var(--bg-white);
        color: var(--text-charcoal);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .filter-select:focus {
        border-color: var(--primary-green);
        outline: none;
        box-shadow: 0 0 0 3px rgba(30, 77, 43, 0.1);
    }
    
    .search-input {
        padding: 0.75rem 1rem;
        border: 2px solid var(--border-light);
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        background: var(--bg-white);
        color: var(--text-charcoal);
        min-width: 300px;
        transition: all 0.3s ease;
    }
    
    .search-input:focus {
        border-color: var(--primary-green);
        outline: none;
        box-shadow: 0 0 0 3px rgba(30, 77, 43, 0.1);
    }
    
    .members-table-container {
        background: var(--bg-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
    }
    
    .members-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .members-table thead {
        background: var(--bg-light-gray);
    }
    
    .members-table th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--text-charcoal);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .members-table td {
        padding: 1rem;
        border-top: 1px solid var(--border-light);
        color: var(--text-charcoal);
    }
    
    .members-table tbody tr {
        transition: all 0.2s ease;
    }
    
    .members-table tbody tr:hover {
        background: rgba(30, 77, 43, 0.02);
    }
    
    .member-name {
        font-weight: 600;
        color: var(--primary-green);
    }
    
    .member-id {
        font-family: var(--font-mono);
        font-size: 0.875rem;
        color: var(--text-gray);
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-view {
        padding: 0.5rem 1rem;
        background: var(--primary-green);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }
    
    .btn-view:hover {
        background: var(--secondary-green);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        margin-top: 2rem;
        padding: 1rem;
    }
    
    .pagination a,
    .pagination span {
        padding: 0.5rem 1rem;
        border: 2px solid var(--border-light);
        border-radius: var(--radius-md);
        text-decoration: none;
        color: var(--text-charcoal);
        transition: all 0.3s ease;
    }
    
    .pagination a:hover {
        border-color: var(--primary-green);
        background: rgba(30, 77, 43, 0.05);
    }
    
    .pagination .active {
        background: var(--primary-green);
        color: white;
        border-color: var(--primary-green);
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-gray);
    }
    
    .empty-state-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        color: var(--text-gray);
        opacity: 0.5;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, var(--bg-cream) 0%, var(--bg-white) 50%, var(--bg-light-gray) 100%);">
    <div class="members-container">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Member Management</h1>
                <p class="dashboard-subtitle">Manage and review all registered members</p>
            </div>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Back to Dashboard</a>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="filters-bar">
            <div class="filter-group" style="flex: 1; min-width: 200px;">
                <label class="filter-label">Search</label>
                <input type="text" class="search-input" id="searchInput" placeholder="Search by name, ID, email...">
            </div>
            <div class="filter-group" style="min-width: 150px;">
                <label class="filter-label">Status</label>
                <select class="filter-select" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
            <div class="filter-group" style="min-width: 150px;">
                <label class="filter-label">Sort By</label>
                <select class="filter-select" id="sortFilter">
                    <option value="latest">Latest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="name">Name A-Z</option>
                    <option value="name_desc">Name Z-A</option>
                </select>
            </div>
        </div>
        
        <!-- Members Table -->
        <div class="members-table-container">
            <table class="members-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Membership ID</th>
                        <th>Status</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="membersTableBody">
                    @php
                        $status = request('status');
                        $query = \App\Models\Member::query();
                        if ($status) {
                            $query->where('status', $status);
                        }
                        $members = $query->latest()->paginate(20);
                    @endphp
                    @forelse($members as $member)
                        <tr>
                            <td>
                                <div class="member-name">{{ $member->full_name }}</div>
                                <div class="member-id">{{ $member->email }}</div>
                            </td>
                            <td>
                                <div class="member-id">{{ $member->membership_id }}</div>
                            </td>
                            <td>
                                <span class="status-badge {{ $member->status }}">{{ ucfirst($member->status) }}</span>
                            </td>
                            <td>
                                <div style="font-size: 0.875rem; color: var(--text-gray);">
                                    {{ $member->created_at->format('M d, Y') }}
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.members.show', $member->id) }}" class="btn-view">View Details</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i data-lucide="users" class="empty-state-icon"></i>
                                    <p style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">No members found</p>
                                    <p>Try adjusting your filters or search criteria</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($members->hasPages())
            <div class="pagination">
                @if($members->onFirstPage())
                    <span style="opacity: 0.5; cursor: not-allowed;">Previous</span>
                @else
                    <a href="{{ $members->previousPageUrl() }}">Previous</a>
                @endif
                
                @foreach($members->getUrlRange(1, $members->lastPage()) as $page => $url)
                    @if($page == $members->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
                
                @if($members->hasMorePages())
                    <a href="{{ $members->nextPageUrl() }}">Next</a>
                @else
                    <span style="opacity: 0.5; cursor: not-allowed;">Next</span>
                @endif
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    lucide.createIcons();
    
    // Filter functionality
    document.getElementById('statusFilter')?.addEventListener('change', function() {
        const status = this.value;
        const url = new URL(window.location);
        if (status) {
            url.searchParams.set('status', status);
        } else {
            url.searchParams.delete('status');
        }
        window.location = url;
    });
</script>
@endpush
@endsection

