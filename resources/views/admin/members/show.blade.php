@extends('layouts.app')

@section('title', 'Member Details')

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
            <div class="flex items-center">
                <a href="{{ route('admin.members.index') }}" class="text-primary hover:text-primary-dark mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-bold text-charcoal">Member Details</h1>
            </div>
        </div>

        <div class="p-6">
            <div class="grid lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Personal Information -->
                    <div class="card p-6">
                        <h2 class="text-xl font-bold text-charcoal mb-4">Personal Information</h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-medium mb-1">Full Name</p>
                                <p class="font-semibold text-charcoal">John Doe</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-medium mb-1">CNIC</p>
                                <p class="font-semibold text-charcoal">12345-1234567-1</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-medium mb-1">Email</p>
                                <p class="font-semibold text-charcoal">john@example.com</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-medium mb-1">Phone</p>
                                <p class="font-semibold text-charcoal">0300-1234567</p>
                            </div>
                        </div>
                    </div>

                    <!-- Documents -->
                    <div class="card p-6">
                        <h2 class="text-xl font-bold text-charcoal mb-4">Documents</h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="border-2 border-dashed border-gray-300 rounded-input p-4 text-center hover:border-primary transition-colors cursor-pointer">
                                <i class="fas fa-file-image text-3xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-medium mb-2">CNIC Front</p>
                                <button class="text-primary text-sm hover:text-primary-dark font-medium">View</button>
                            </div>
                            <div class="border-2 border-dashed border-gray-300 rounded-input p-4 text-center hover:border-primary transition-colors cursor-pointer">
                                <i class="fas fa-file-image text-3xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-medium mb-2">CNIC Back</p>
                                <button class="text-primary text-sm hover:text-primary-dark font-medium">View</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions Sidebar -->
                <div class="lg:col-span-1">
                    <div class="card p-6 sticky top-4">
                        <h3 class="text-lg font-bold text-charcoal mb-4">Actions</h3>
                        
                        <div class="space-y-3">
                            <button class="btn-success w-full">
                                <i class="fas fa-check mr-2"></i>
                                Approve Application
                            </button>
                            
                            <button class="btn-danger w-full" x-data="{ showReject: false }" @click="showReject = true">
                                <i class="fas fa-times mr-2"></i>
                                Reject Application
                            </button>
                        </div>

                        <!-- Reject Modal -->
                        <div x-show="showReject" x-cloak class="mt-4 p-4 bg-red-50 rounded-input border border-red-200" style="display: none;">
                            <label class="block text-sm font-semibold text-charcoal mb-2">Rejection Reason <span class="text-red-500">*</span></label>
                            <textarea class="form-input w-full mb-3" rows="3" placeholder="Enter reason for rejection..."></textarea>
                            <div class="flex space-x-2">
                                <button @click="showReject = false" class="btn-secondary flex-1 text-sm">Cancel</button>
                                <button class="btn-danger flex-1 text-sm">Confirm Reject</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
