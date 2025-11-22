@extends('layouts.app')

@section('title', 'Member Login')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-soft">
    <div class="max-w-md w-full">
        <div class="glass-ultra p-8 shadow-strong stagger-reveal">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4 shadow-green magnetic-hover">
                    <i class="fas fa-user-shield text-white text-2xl"></i>
                </div>
                <h2 class="ultra-heading-2">Member Login</h2>
                <p class="ultra-body mt-2">Sign in to your membership account</p>
            </div>

            <form method="POST" action="{{ route('member.login.post') }}" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                
                <x-form-input name="email" type="email" label="Email Address" required :error="$errors->first('email')" />
                <x-form-input name="password" type="password" label="Password" required :error="$errors->first('password')" />
                
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                        <span class="ml-2 text-sm ultra-body">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-primary hover:text-primary-dark font-semibold">Forgot password?</a>
                </div>

                <button 
                    type="submit" 
                    class="ultra-btn-primary w-full py-3.5"
                    :disabled="loading"
                    :class="loading ? 'opacity-75 cursor-not-allowed' : ''"
                >
                    <span x-show="!loading">Login</span>
                    <span x-show="loading" style="display: none;">
                        <span class="ultra-loading mr-2"></span>
                        Logging in...
                    </span>
                </button>

                <!-- 2FA Section (if enabled) -->
                <div x-show="false" class="mt-6" style="display: none;">
                    <x-otp-input name="two_factor_code" label="Two-Factor Authentication Code" />
                    <button type="submit" class="ultra-btn-primary w-full py-3.5 mt-4">Verify & Login</button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm ultra-body">
                    Don't have an account?
                    <a href="{{ route('membership.register') }}" class="text-primary font-semibold hover:text-primary-dark">Register here</a>
                </p>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="mt-6 text-center stagger-reveal">
            <div class="inline-flex items-center space-x-2 text-sm ultra-body">
                <i class="fas fa-lock text-primary"></i>
                <span>Secure login with encryption</span>
            </div>
        </div>
    </div>
</div>
@endsection
