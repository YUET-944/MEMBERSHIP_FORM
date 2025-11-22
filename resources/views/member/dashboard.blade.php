@extends('layouts.app')

@section('title', 'Member Dashboard')

@section('content')
<div class="flex min-h-screen bg-gray-soft">
    <!-- Sidebar -->
    <aside class="sidebar w-64 min-h-screen sticky top-0">
        <div class="p-6">
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-primary rounded-full flex items-center justify-center mx-auto mb-3 shadow-green">
                    <i class="fas fa-user text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-white">{{ auth()->user()->full_name ?? 'Member' }}</h3>
                <p class="text-sm text-gray-400">{{ auth()->user()->email ?? '' }}</p>
            </div>

            <nav class="space-y-2">
                <a href="#" class="sidebar-item active">
                    <i class="fas fa-home mr-3"></i>
                    Dashboard
                </a>
                <a href="#" class="sidebar-item">
                    <i class="fas fa-user mr-3"></i>
                    Profile
                </a>
                <a href="#" class="sidebar-item">
                    <i class="fas fa-certificate mr-3"></i>
                    Certificate
                </a>
                <a href="#" class="sidebar-item">
                    <i class="fas fa-bell mr-3"></i>
                    Notifications
                </a>
                <a href="#" class="sidebar-item">
                    <i class="fas fa-cog mr-3"></i>
                    Settings
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1">
        <!-- Topbar -->
        <div class="bg-white border-b border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-charcoal">Dashboard</h1>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-medium hover:text-charcoal">
                        <i class="fas fa-bell text-xl"></i>
                    </button>
                    <form method="POST" action="{{ route('member.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn-secondary text-sm">Logout</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="p-6">
            <!-- Welcome Section -->
            <div class="card p-6 mb-6 bg-gradient-to-r from-primary-50 to-white border-l-4 border-primary">
                <h2 class="text-xl font-bold text-charcoal mb-2">Welcome back, {{ auth()->user()->full_name ?? 'Member' }}</h2>
                <p class="text-gray-medium">Manage your membership and access your resources</p>
            </div>

            <!-- Membership Status Card -->
            <div class="card p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-charcoal">Membership Status</h2>
                    <x-status-badge status="{{ auth()->user()->status ?? 'pending' }}" />
                </div>
                
                <div class="grid md:grid-cols-3 gap-4 mt-6">
                    <div class="text-center p-4 bg-gray-soft rounded-input">
                        <i class="fas fa-id-card text-2xl text-primary mb-2"></i>
                        <p class="text-sm text-gray-medium mb-1">Membership ID</p>
                        <p class="font-bold text-charcoal">{{ auth()->user()->membership_id ?? 'N/A' }}</p>
                    </div>
                    <div class="text-center p-4 bg-gray-soft rounded-input">
                        <i class="fas fa-calendar text-2xl text-primary mb-2"></i>
                        <p class="text-sm text-gray-medium mb-1">Joined Date</p>
                        <p class="font-bold text-charcoal">{{ auth()->user()->created_at?->format('M d, Y') ?? 'N/A' }}</p>
                    </div>
                    <div class="text-center p-4 bg-gray-soft rounded-input">
                        <i class="fas fa-shield-check text-2xl text-primary mb-2"></i>
                        <p class="text-sm text-gray-medium mb-1">Verification</p>
                        <p class="font-bold text-charcoal">{{ auth()->user()->email_verified_at ? 'Verified' : 'Pending' }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card p-6 mb-6">
                <h2 class="text-xl font-bold text-charcoal mb-4">Quick Actions</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    <a href="{{ route('member.certificate.download') }}" class="btn-primary flex items-center justify-center py-3">
                        <i class="fas fa-download mr-2"></i>
                        Download Certificate
                    </a>
                    <a href="#" class="btn-secondary flex items-center justify-center py-3">
                        <i class="fas fa-edit mr-2"></i>
                        Update Profile
                    </a>
                </div>
            </div>

            <!-- Notifications -->
            <div class="card p-6">
                <h2 class="text-xl font-bold text-charcoal mb-4">Recent Notifications</h2>
                <div class="space-y-3">
                    <div class="flex items-start p-3 bg-gray-soft rounded-input">
                        <i class="fas fa-info-circle text-primary mt-1 mr-3"></i>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-charcoal">Application Submitted</p>
                            <p class="text-xs text-gray-medium">Your membership application has been received and is under review.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
