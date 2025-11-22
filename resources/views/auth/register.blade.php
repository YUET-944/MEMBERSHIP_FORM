@extends('layouts.app')

@section('title', 'Create Account')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-soft">
    <div class="max-w-md w-full">
        <div class="glass-ultra p-8 shadow-strong stagger-reveal">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4 shadow-green magnetic-hover">
                    <i class="fas fa-user-plus text-white text-2xl"></i>
                </div>
                <h2 class="ultra-heading-2">Create Account</h2>
                <p class="ultra-body mt-2">Start your membership journey</p>
            </div>

            <form method="POST" action="{{ route('register') }}" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                
                <x-form-input name="full_name" label="Full Name" required :error="$errors->first('full_name')" />
                <x-form-input name="email" type="email" label="Email Address" required :error="$errors->first('email')" />
                <x-form-input name="password" type="password" label="Password" required :error="$errors->first('password')" />
                <x-form-input name="password_confirmation" type="password" label="Confirm Password" required :error="$errors->first('password_confirmation')" />
                
                <button 
                    type="submit" 
                    class="ultra-btn-primary w-full py-3.5 mt-6"
                    :disabled="loading"
                    :class="loading ? 'opacity-75 cursor-not-allowed' : ''"
                >
                    <span x-show="!loading">Create Account</span>
                    <span x-show="loading" style="display: none;">
                        <span class="ultra-loading mr-2"></span>
                        Creating...
                    </span>
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm ultra-body">
                    Already have an account?
                    <a href="{{ route('member.login') }}" class="text-primary font-semibold hover:text-primary-dark">Login here</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
