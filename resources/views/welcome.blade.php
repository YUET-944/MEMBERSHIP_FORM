@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="min-h-screen flex items-center justify-center py-8 px-4 bg-cream">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-primary-green mb-4">
            National Membership System
        </h1>
        <p class="text-2xl text-gray-600 mb-8 urdu-text">
            قومی رکنیت کا نظام
        </p>
        
        <div class="glass mirror-effect rounded-2xl p-8 max-w-2xl mx-auto mb-8 bg-white shadow-lg">
            <p class="text-dark text-lg mb-6 font-medium">
                Join our community and become a member today
            </p>
            <p class="text-gray-600 mb-8 urdu-text">
                ہماری کمیونٹی میں شامل ہوں اور آج ہی ممبر بنیں
            </p>
            
            <a href="{{ route('membership.register') }}" class="btn-primary inline-block text-lg px-8 py-4 rounded-lg">
                Register Now <span class="urdu-text">ابھی رجسٹر کریں</span>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto mt-12">
            <div class="glass rounded-xl p-6 bg-white shadow-md">
                <h3 class="text-xl font-semibold text-primary-green mb-2">Secure</h3>
                <p class="text-gray-600 text-sm">AES-256 encryption</p>
            </div>
            <div class="glass rounded-xl p-6 bg-white shadow-md">
                <h3 class="text-xl font-semibold text-primary-green mb-2">Verified</h3>
                <p class="text-gray-600 text-sm">OTP & 2FA protection</p>
            </div>
            <div class="glass rounded-xl p-6 bg-white shadow-md">
                <h3 class="text-xl font-semibold text-primary-green mb-2">Official</h3>
                <p class="text-gray-600 text-sm">Government-level security</p>
            </div>
        </div>
    </div>
</div>
@endsection

