@extends('layouts.app')

@section('title', 'Verify OTP')

@section('content')
<div class="min-h-screen flex items-center justify-center py-8 px-4 bg-cream">
    <div class="glass mirror-effect rounded-2xl p-8 max-w-md w-full bg-white shadow-xl">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-primary-green mb-2">Verify OTP</h1>
            <p class="text-gray-600 urdu-text">او ٹی پی کی تصدیق کریں</p>
        </div>
        
        @if(session('error'))
            <div class="bg-red-50 border-2 border-red-300 text-red-700 px-4 py-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('membership.verify-otp.post') }}" id="otpForm">
            @csrf
            
            <div class="space-y-6">
                <!-- Email OTP -->
                <div>
                    <label class="block text-dark font-semibold mb-2">
                        Email OTP <span class="urdu-text text-sm text-gray-600">ای میل او ٹی پی</span>
                    </label>
                    <input type="text" name="email_otp" maxlength="6" class="form-input w-full text-center text-2xl tracking-widest font-bold text-primary-green" required autofocus>
                </div>
                
                <!-- SMS OTP -->
                <div>
                    <label class="block text-dark font-semibold mb-2">
                        SMS OTP <span class="urdu-text text-sm text-gray-600">ایس ایم ایس او ٹی پی</span>
                    </label>
                    <input type="text" name="sms_otp" maxlength="6" class="form-input w-full text-center text-2xl tracking-widest font-bold text-primary-green" required>
                </div>
                
                <!-- Resend OTP -->
                <div class="text-center">
                    <button type="button" id="resendBtn" class="text-primary-green hover:text-secondary-green font-semibold text-sm">
                        Resend OTP <span class="urdu-text">او ٹی پی دوبارہ بھیجیں</span>
                    </button>
                    <p class="text-gray-500 text-xs mt-2" id="countdown"></p>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn-primary w-full">
                    Verify <span class="urdu-text">تصدیق کریں</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Auto-focus next input
    document.querySelectorAll('input[name="email_otp"], input[name="sms_otp"]').forEach(input => {
        input.addEventListener('input', function() {
            if (this.value.length === 6) {
                const nextInput = this.name === 'email_otp' 
                    ? document.querySelector('input[name="sms_otp"]')
                    : null;
                if (nextInput) {
                    nextInput.focus();
                }
            }
        });
    });
    
    // Resend OTP
    let resendCooldown = 60;
    const resendBtn = document.getElementById('resendBtn');
    const countdown = document.getElementById('countdown');
    
    function updateCountdown() {
        if (resendCooldown > 0) {
            countdown.textContent = `Resend available in ${resendCooldown} seconds`;
            resendCooldown--;
            setTimeout(updateCountdown, 1000);
        } else {
            countdown.textContent = '';
            resendBtn.disabled = false;
        }
    }
    
    resendBtn.addEventListener('click', function() {
        if (resendCooldown > 0) return;
        
        resendBtn.disabled = true;
        resendCooldown = 60;
        
        fetch('{{ route("membership.resend-otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert('OTP resent successfully');
            }
            updateCountdown();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to resend OTP');
            resendBtn.disabled = false;
        });
    });
    
    updateCountdown();
</script>
@endpush
@endsection

