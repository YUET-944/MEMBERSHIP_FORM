@extends('layouts.app')

@section('title', 'Member Login')

@push('styles')
<style>
    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        background: linear-gradient(135deg, var(--bg-cream-white) 0%, var(--bg-pearl-white) 50%, var(--bg-platinum-gray) 100%);
    }
    
    .login-card {
        width: 100%;
        max-width: 480px;
        background: var(--bg-pearl-white);
        border-radius: var(--radius-xl);
        padding: 3.5rem;
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
        background: linear-gradient(90deg, var(--emerald-dark), var(--gold-primary));
    }
    
    .login-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    
    .login-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, var(--emerald-dark), var(--emerald-medium));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-lg);
        position: relative;
    }
    
    .login-icon::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--gold-primary), var(--gold-light));
        opacity: 0.3;
        z-index: -1;
        animation: pulse-ring 2s ease-in-out infinite;
    }
    
    .login-title {
        font-family: var(--font-serif);
        font-size: 2.25rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--emerald-dark), var(--gold-primary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
    }
    
    .login-subtitle {
        color: var(--neutral-secondary);
        font-size: 1rem;
    }
    
    .alert {
        padding: 1rem 1.25rem;
        border-radius: var(--radius-md);
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: slide-in 0.3s ease-out;
    }
    
    @keyframes slide-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .alert-error {
        background: rgba(255, 107, 107, 0.1);
        color: var(--coral-deep);
        border: 1px solid rgba(255, 107, 107, 0.3);
    }
    
    .alert-success {
        background: rgba(30, 77, 43, 0.1);
        color: var(--emerald-dark);
        border: 1px solid rgba(30, 77, 43, 0.3);
    }
    
    .divider {
        position: relative;
        margin: 2rem 0;
        text-align: center;
    }
    
    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: var(--neutral-border);
    }
    
    .divider span {
        position: relative;
        background: var(--bg-pearl-white);
        padding: 0 1rem;
        color: var(--neutral-secondary);
        font-size: 0.875rem;
    }
    
    .register-link {
        text-align: center;
        margin-top: 1.5rem;
    }
    
    .register-link a {
        color: var(--emerald-dark);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .register-link a:hover {
        color: var(--gold-primary);
        transform: translateX(4px);
    }
    
    .security-footer {
        text-align: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--neutral-border);
    }
    
    .security-footer p {
        font-size: 0.75rem;
        color: var(--neutral-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="login-container" style="position: relative; overflow: hidden;">
    <!-- Floating 3D Shapes Background -->
    <div class="floating-shapes-3d">
        <div class="shape-3d shape-1 gold-glass"></div>
        <div class="shape-3d shape-2 emerald-glass"></div>
        <div class="shape-3d shape-3 pearl-glass"></div>
    </div>
    
    <div class="login-card luxury-card glass-card-3d" style="position: relative; z-index: 1;">
        <div class="login-header">
            <div class="login-icon">
                <i data-lucide="shield-check" style="width: 40px; height: 40px; color: white;"></i>
            </div>
            <h1 class="login-title">Member Portal</h1>
            <p class="login-subtitle">Sign in to access your membership dashboard</p>
        </div>
        
        @if(session('error'))
            <div class="alert alert-error">
                <i data-lucide="alert-circle" style="width: 20px; height: 20px;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        
        @if(session('success'))
            <div class="alert alert-success">
                <i data-lucide="check-circle" style="width: 20px; height: 20px;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-error">
                <i data-lucide="alert-circle" style="width: 20px; height: 20px;"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif
        
        <form method="POST" action="{{ route('member.login.post') }}">
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
                    <button type="button" class="password-toggle glass-btn" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: transparent; border: none; cursor: pointer; z-index: 3;">
                        <span class="toggle-icon text-sharp">👁️</span>
                    </button>
                </div>
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" class="mr-2 w-4 h-4 accent-green-600">
                    <span style="font-size: 0.875rem; color: var(--neutral-secondary);">Remember me</span>
                </label>
                <a href="#" style="font-size: 0.875rem; color: var(--emerald-dark); text-decoration: none; font-weight: 500; transition: color 0.3s ease;">
                    Forgot password?
                </a>
            </div>
            
            <button type="submit" class="gold-glass-btn" style="width: 100%; margin-bottom: 1.5rem;">
                <span class="btn-content text-sharp">
                    <span class="btn-icon">🚀</span>
                    Sign In to Dashboard
                </span>
                <div class="btn-shine-3d"></div>
                <div class="btn-reflection"></div>
            </button>
        </form>
        
        <div class="divider">
            <span>New to our platform?</span>
        </div>
        
        <div class="register-link">
            <a href="{{ route('membership.register') }}">
                <i data-lucide="user-plus" style="width: 18px; height: 18px;"></i>
                Create Member Account
            </a>
        </div>
        
        <div class="security-footer">
            <p>
                <i data-lucide="shield-check" style="width: 16px; height: 16px; color: var(--emerald-dark);"></i>
                Your information is securely encrypted
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    lucide.createIcons();
    
    // Initialize floating labels for existing values
    document.querySelectorAll('.ultra-input').forEach(field => {
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
        
        // Real-time validation
        field.addEventListener('blur', function() {
            if (this.type === 'email' && this.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailRegex.test(this.value)) {
                    this.classList.add('valid');
                    this.classList.remove('invalid');
                } else {
                    this.classList.add('invalid');
                    this.classList.remove('valid');
                }
            } else if (this.value) {
                this.classList.add('valid');
                this.classList.remove('invalid');
            }
            
            lucide.createIcons();
        });
    });
</script>
@endpush
@endsection

