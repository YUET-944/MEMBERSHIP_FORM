@extends('layouts.app')

@section('title', 'Admin Dashboard')

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
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item active">
                    <i class="fas fa-home mr-3"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.members.index') }}" class="sidebar-item">
                    <i class="fas fa-users mr-3"></i>
                    Applications
                </a>
                <a href="#" class="sidebar-item">
                    <i class="fas fa-chart-bar mr-3"></i>
                    Analytics
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
                <h1 class="text-2xl font-bold text-charcoal">Admin Dashboard</h1>
                <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="btn-secondary text-sm">Logout</button>
                </form>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="p-6">
            <!-- Stats Cards -->
            <div class="grid md:grid-cols-4 gap-6 mb-8">
                <div class="card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-medium mb-1">Total Applications</p>
                            <p class="text-2xl font-bold text-charcoal">0</p>
                        </div>
                        <i class="fas fa-file-alt text-3xl text-primary"></i>
                    </div>
                </div>
                <div class="card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-medium mb-1">Pending</p>
                            <p class="text-2xl font-bold text-charcoal">0</p>
                        </div>
                        <i class="fas fa-clock text-3xl text-yellow-500"></i>
                    </div>
                </div>
                <div class="card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-medium mb-1">Approved</p>
                            <p class="text-2xl font-bold text-charcoal">0</p>
                        </div>
                        <i class="fas fa-check-circle text-3xl text-primary"></i>
                    </div>
                </div>
                <div class="card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-medium mb-1">Rejected</p>
                            <p class="text-2xl font-bold text-charcoal">0</p>
                        </div>
                        <i class="fas fa-times-circle text-3xl text-red-500"></i>
                    </div>
                </div>
            </div>

            <!-- Applications Table -->
            <div class="card p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-charcoal">Membership Applications</h2>
                    
                    <!-- Filters -->
                    <div class="flex items-center space-x-3">
                        <select class="form-input" style="width: auto;">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                        <input type="text" placeholder="Search..." class="form-input" style="width: 200px;">
                    </div>
                </div>

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
                            <tr class="hover:bg-gray-soft transition-colors">
                                <td class="px-6 py-4 text-sm text-charcoal">#001</td>
                                <td class="px-6 py-4 text-sm font-semibold text-charcoal">John Doe</td>
                                <td class="px-6 py-4 text-sm text-gray-medium">john@example.com</td>
                                <td class="px-6 py-4 text-sm text-gray-medium">12345-1234567-1</td>
                                <td class="px-6 py-4"><x-status-badge status="pending" /></td>
                                <td class="px-6 py-4 text-sm text-gray-medium">Jan 15, 2024</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.members.show', 1) }}" class="text-primary hover:text-primary-dark" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="text-primary hover:text-primary-dark" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="text-red-500 hover:text-red-600" title="Reject">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
