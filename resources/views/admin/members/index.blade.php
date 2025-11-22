@extends('layouts.app')

@section('title', 'Membership Applications')

@section('content')
<div class="flex min-h-screen bg-gray-soft">
    <!-- Sidebar -->
    <aside class="sidebar w-64 min-h-screen sticky top-0">
        <div class="p-6">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-3 shadow-green">
                    <i class="fas fa-user-cog text-white text-2xl"></i>
                </div>
                <h3 class="font-bold text-white">{{ auth()->user()->name ?? 'Admin' }}</h3>
                <p class="text-sm text-gray-400">Administrator</p>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item">
                    <i class="fas fa-home mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.members.index') }}" class="sidebar-item active">
                    <i class="fas fa-users mr-3"></i>
                    Applications
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1">
        <div class="bg-white border-b border-gray-200 px-6 py-4">
            <h1 class="text-2xl font-bold text-charcoal">Membership Applications</h1>
        </div>

        <div class="p-6">
            <!-- Filters -->
            <div class="card p-6 mb-6">
                <div class="flex flex-wrap items-center gap-4">
                    <select class="form-input" style="width: auto; min-width: 150px;">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                    <input type="text" placeholder="Search by name, email, or CNIC..." class="form-input flex-1" style="min-width: 200px;">
                    <button class="btn-primary">Search</button>
                    <button class="btn-secondary">Reset</button>
                </div>
            </div>

            <!-- Applications Table -->
            <div class="card p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-soft">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-medium uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-medium uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-medium uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-medium uppercase">CNIC</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-medium uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-medium uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-medium uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($members ?? [] as $member)
                            <tr class="hover:bg-gray-soft transition-colors">
                                <td class="px-6 py-4 text-sm text-charcoal">#{{ str_pad($member->id ?? 1, 3, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-charcoal">{{ $member->full_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-medium">{{ $member->email ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-medium">{{ $member->cnic ?? 'N/A' }}</td>
                                <td class="px-6 py-4"><x-status-badge status="{{ $member->status ?? 'pending' }}" /></td>
                                <td class="px-6 py-4 text-sm text-gray-medium">{{ $member->created_at?->format('M d, Y') ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.members.show', $member->id ?? 1) }}" class="text-primary hover:text-primary-dark" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.members.approve', $member->id ?? 1) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-primary hover:text-primary-dark" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <button class="text-red-500 hover:text-red-600" title="Reject" x-data @click="$dispatch('open-reject-modal', { id: {{ $member->id ?? 1 }} })">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-medium">
                                    <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                                    <p>No applications found</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Reject Modal -->
<div x-data="{ show: false, memberId: null }" @open-reject-modal.window="show = true; memberId = $event.detail.id" x-show="show" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" style="display: none;">
    <div class="bg-white rounded-card p-6 max-w-md w-full mx-4 shadow-strong" @click.away="show = false">
        <h3 class="text-xl font-bold text-charcoal mb-4">Reject Application</h3>
        <form method="POST" :action="`/admin/members/${memberId}/reject`">
            @csrf
            <label class="block text-sm font-semibold text-charcoal mb-2">Rejection Reason <span class="text-red-500">*</span></label>
            <textarea name="rejection_reason" rows="4" class="form-input w-full mb-4" required placeholder="Enter reason for rejection..."></textarea>
            <div class="flex space-x-3">
                <button type="button" @click="show = false" class="btn-secondary flex-1">Cancel</button>
                <button type="submit" class="btn-danger flex-1">Confirm Reject</button>
            </div>
        </form>
    </div>
</div>
@endsection
