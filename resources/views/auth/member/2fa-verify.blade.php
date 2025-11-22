@extends('layouts.app')

@section('title', '2FA Verification')

@push('styles')
<style>
    .verify-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        background: linear-gradient(135deg, var(--bg-cream-white) 0%, var(--bg-pearl-white) 50%, var(--bg-platinum-gray) 100%);
    }
    
    .verify-card {
        width: 100%;
        max-width: 420px;
        background: var(--bg-pearl-white);
        border-radius: var(--radius-xl);
        padding: 3rem;
        box-shadow: var(--shadow-2xl);
        text-align: center;
    }
    
    .verify-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, var(--gold-primary), var(--gold-light));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-gold);
    }
    
    .verify-title {
        font-family: var(--font-serif);
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--emerald-dark);
        margin-bottom: 0.5rem;
    }
    
    .verify-desc {
        color: var(--neutral-secondary);
        font-size: 0.875rem;
        margin-bottom: 2rem;
    }
    
    .code-input {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
        margin-bottom: 1.5rem;
    }
    
    .code-digit {
        width: 50px;
        height: 60px;
        text-align: center;
        font-size: 1.5rem;
        font-weight: 700;
        border: 2px solid var(--neutral-border);
        border-radius: var(--radius-md);
        background: var(--bg-pearl-white);
        transition: all 0.3s ease;
    }
    
    .code-digit:focus {
        border-color: var(--gold-primary);
        box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1);
        outline: none;
    }
</style>
@endpush

@section('content')
<div class="verify-container">
    <div class="verify-card luxury-card glass-ultra">
        <div class="verify-icon">
            <i data-lucide="key" style="width: 40px; height: 40px; color: white;"></i>
        </div>
        <h1 class="verify-title">Two-Factor Authentication</h1>
        <p class="verify-desc">Enter the 6-digit code from your authenticator app</p>
        
        @if(session('error'))
            <div class="alert alert-error" style="margin-bottom: 1.5rem;">
                <i data-lucide="alert-circle" style="width: 20px; height: 20px;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        
        <form method="POST" action="{{ route('member.2fa.verify.post') }}" id="verifyForm">
            @csrf
            
            <input type="hidden" name="code" id="codeInput" required>
            
            <div class="code-input">
                @for($i = 0; $i < 6; $i++)
                    <input type="text" class="code-digit" maxlength="1" pattern="[0-9]" required autocomplete="off" data-index="{{ $i }}">
                @endfor
            </div>
            
            <button type="submit" class="ultra-btn-primary pearl-shine magnetic-hover" style="width: 100%; margin-bottom: 1.5rem;">
                Verify Code
            </button>
        </form>
        
        <a href="{{ route('member.login') }}" style="color: var(--neutral-secondary); text-decoration: none; font-size: 0.875rem;">
            <i data-lucide="arrow-left" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 0.25rem;"></i>
            Back to Login
        </a>
    </div>
</div>

@push('scripts')
<script>
    lucide.createIcons();
    
    // Auto-focus and move to next input
    const codeInputs = document.querySelectorAll('.code-digit');
    const codeInput = document.getElementById('codeInput');
    
    function updateCode() {
        const code = Array.from(codeInputs).map(input => input.value).join('');
        codeInput.value = code;
    }
    
    codeInputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');
            
            updateCode();
            
            if (this.value.length === 1 && index < codeInputs.length - 1) {
                codeInputs[index + 1].focus();
            }
        });
        
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && index > 0) {
                codeInputs[index - 1].focus();
            }
        });
        
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 6);
            pastedData.split('').forEach((char, i) => {
                if (codeInputs[index + i]) {
                    codeInputs[index + i].value = char;
                }
            });
            updateCode();
            codeInputs[Math.min(index + pastedData.length - 1, codeInputs.length - 1)].focus();
        });
    });
    
    // Focus first input on load
    codeInputs[0].focus();
</script>
@endpush
@endsection

