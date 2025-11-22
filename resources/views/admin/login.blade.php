@extends('layouts.app')

@section('title', 'Admin Login')

@push('styles')
<style>
    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    
    .login-card {
        width: 100%;
        max-width: 450px;
        background: var(--bg-white);
        border-radius: var(--radius-xl);
        padding: 3rem;
        box-shadow: var(--shadow-2xl);
        position: relative;
        overflow: hidden;
    }
    
    .login-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-green), var(--accent-gold));
    }
    
    .login-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    
    .login-title {
        font-family: var(--font-serif);
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 0.5rem;
    }
    
    .login-subtitle {
        color: var(--text-gray);
        font-size: 0.875rem;
    }
    
    .alert {
        padding: 1rem;
        border-radius: var(--radius-md);
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .alert-error {
        background: rgba(255, 107, 107, 0.1);
        color: var(--accent-coral);
        border: 1px solid rgba(255, 107, 107, 0.3);
    }
    
    .alert-success {
        background: rgba(30, 77, 43, 0.1);
        color: var(--primary-green);
        border: 1px solid rgba(30, 77, 43, 0.3);
    }
</style>
@endpush

@section('content')
<div class="login-container" style="background: linear-gradient(135deg, var(--bg-cream-white) 0%, var(--bg-pearl-white) 50%, var(--bg-platinum-gray) 100%); position: relative; overflow: hidden;">
    <!-- Floating 3D Shapes Background -->
    <div class="floating-shapes-3d">
        <div class="shape-3d shape-1 gold-glass"></div>
        <div class="shape-3d shape-2 emerald-glass"></div>
        <div class="shape-3d shape-3 pearl-glass"></div>
    </div>
    
    <div class="login-card luxury-card glass-card-3d" style="position: relative; z-index: 1;">
        <div class="login-header">
            <h1 class="login-title">Admin Login</h1>
            <p class="login-subtitle">Sign in to access the admin panel</p>
        </div>
        
        @if(session('error'))
            <div class="alert alert-error">
                <i data-lucide="alert-circle" style="width: 20px; height: 20px; vertical-align: middle; margin-right: 0.5rem;"></i>
                {{ session('error') }}
            </div>
        @endif
        
        @if(session('success'))
            <div class="alert alert-success">
                <i data-lucide="check-circle" style="width: 20px; height: 20px; vertical-align: middle; margin-right: 0.5rem;"></i>
                {{ session('success') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            
            <div class="input-group-3d">
                <div class="input-container glass-input">
                    <input type="email" name="email" id="email" class="glass-input-field text-sharp" value="{{ old('email') }}" placeholder=" " required autofocus>
                    <label for="email" class="glass-input-label text-sharp">
                        <span class="label-icon">📧</span>
                        Email Address <span class="required">*</span>
                    </label>
                    <div class="input-border-3d"></div>
                    <div class="gold-focus-glow"></div>
                </div>
            </div>
            
            <div class="input-group-3d">
                <div class="input-container glass-input">
                    <input type="password" name="password" id="password" class="glass-input-field text-sharp" placeholder=" " required>
                    <label for="password" class="glass-input-label text-sharp">
                        <span class="label-icon">🔒</span>
                        Password <span class="required">*</span>
                    </label>
                    <div class="input-border-3d"></div>
                    <div class="gold-focus-glow"></div>
                </div>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" class="mr-2 w-4 h-4 accent-green-600">
                    <span style="font-size: 0.875rem; color: var(--text-gray);">Remember me</span>
                </label>
            </div>
            
            <button type="submit" class="gold-glass-btn" style="width: 100%; margin-bottom: 1.5rem;">
                <span class="btn-content text-sharp">
                    <span class="btn-icon">🔐</span>
                    Sign In
                </span>
                <div class="btn-shine-3d"></div>
                <div class="btn-reflection"></div>
            </button>
            
            <div style="text-align: center;">
                <a href="{{ route('home') }}" style="color: var(--text-gray); font-size: 0.875rem; text-decoration: none;">
                    <i data-lucide="arrow-left" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 0.25rem;"></i>
                    Back to Home
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    lucide.createIcons();
    
    // Initialize floating labels for existing values
    document.querySelectorAll('.premium-input').forEach(field => {
        if (field.value) {
            field.classList.add('has-value');
        }
        
        field.addEventListener('input', function() {
            if (this.value) {
                this.classList.add('has-value');
            } else {
                this.classList.remove('has-value');
            }
        });
    });
</script>
@endpush
@endsection

