@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-accent-dark to-gray-800">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-card shadow-strong p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-accent-dark rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-cog text-white text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-charcoal">Admin Login</h2>
                <p class="text-gray-medium mt-2">Secure admin access</p>
            </div>

            <form method="POST" action="{{ route('admin.login.post') }}" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                
                <x-form-input name="email" type="email" label="Email Address" required :error="$errors->first('email')" />
                <x-form-input name="password" type="password" label="Password" required :error="$errors->first('password')" />
                
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                        <span class="ml-2 text-sm text-gray-medium">Remember me</span>
                    </label>
                </div>

                <!-- OTP Field (if 2FA enabled) -->
                <div x-show="false" class="mb-6" style="display: none;">
                    <x-otp-input name="otp" label="Two-Factor Authentication" />
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-accent-dark text-white py-3 rounded-button font-semibold hover:bg-gray-800 transition-colors shadow-medium"
                    :disabled="loading"
                    :class="loading ? 'opacity-75 cursor-not-allowed' : ''"
                >
                    <span x-show="!loading">Login</span>
                    <span x-show="loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        Logging in...
                    </span>
                </button>
            </form>

            <div class="mt-6 text-center">
                <div class="inline-flex items-center space-x-2 text-sm text-gray-medium">
                    <i class="fas fa-shield-alt text-primary"></i>
                    <span>Secure admin portal</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
