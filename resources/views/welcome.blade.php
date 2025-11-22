@extends('layouts.app')

@section('title', 'Home - National Membership System')

@section('content')
<!-- Hero Section -->
<section class="relative py-20 bg-gradient-to-br from-primary-50 via-white to-primary-50 overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary-light rounded-full blur-3xl"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-4xl mx-auto fade-in stagger-reveal">
            <div class="inline-flex items-center px-4 py-2 bg-primary-50 border border-primary-200 rounded-full mb-6 magnetic-hover">
                <i class="fas fa-shield-check text-primary mr-2"></i>
                <span class="text-sm font-semibold text-primary-700">Government Verified System</span>
            </div>
            
            <h1 class="ultra-heading-1 mb-6 stagger-reveal">
                Join the National Membership System
            </h1>
            <p class="ultra-body text-xl md:text-2xl mb-8 stagger-reveal">
                Secure, verified, and officially protected membership platform
            </p>
            <p class="text-lg text-gray-medium mb-12 urdu-text stagger-reveal" dir="rtl">
                محفوظ، تصدیق شدہ اور سرکاری طور پر محفوظ رکنیت کا پلیٹ فارم
            </p>
            
            <a href="{{ route('membership.register') }}" class="ultra-btn-primary inline-flex items-center text-lg px-8 py-4 magnetic-hover stagger-reveal">
                <span>Join Membership</span>
                <i class="fas fa-arrow-right ml-3"></i>
            </a>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="ultra-section-header">How Membership Works</h2>
            <p class="ultra-body text-lg">Simple steps to become a verified member</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="ultra-card p-8 text-center stagger-reveal">
                <div class="w-16 h-16 bg-primary-50 rounded-full flex items-center justify-center mx-auto mb-6 magnetic-hover">
                    <i class="fas fa-user-plus text-3xl text-primary"></i>
                </div>
                <h3 class="ultra-heading-3 mb-4">1. Register</h3>
                <p class="ultra-body">Fill out the membership form with your details</p>
            </div>
            
            <div class="ultra-card p-8 text-center stagger-reveal">
                <div class="w-16 h-16 bg-primary-50 rounded-full flex items-center justify-center mx-auto mb-6 magnetic-hover">
                    <i class="fas fa-shield-check text-3xl text-primary"></i>
                </div>
                <h3 class="ultra-heading-3 mb-4">2. Verify</h3>
                <p class="ultra-body">Complete OTP verification and document upload</p>
            </div>
            
            <div class="ultra-card p-8 text-center stagger-reveal">
                <div class="w-16 h-16 bg-primary-50 rounded-full flex items-center justify-center mx-auto mb-6 magnetic-hover">
                    <i class="fas fa-certificate text-3xl text-primary"></i>
                </div>
                <h3 class="ultra-heading-3 mb-4">3. Get Approved</h3>
                <p class="ultra-body">Receive your membership certificate</p>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="py-20 bg-gray-soft">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="ultra-section-header">Membership Benefits</h2>
            <p class="ultra-body text-lg">Why join our secure platform</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="ultra-card p-6 text-center stagger-reveal">
                <i class="fas fa-lock text-3xl text-primary mb-4"></i>
                <h3 class="font-bold mb-2 text-charcoal">Secure</h3>
                <p class="text-sm ultra-body">Military-grade encryption</p>
            </div>
            
            <div class="ultra-card p-6 text-center stagger-reveal">
                <i class="fas fa-check-circle text-3xl text-primary mb-4"></i>
                <h3 class="font-bold mb-2 text-charcoal">Verified</h3>
                <p class="text-sm ultra-body">Multi-factor authentication</p>
            </div>
            
            <div class="ultra-card p-6 text-center stagger-reveal">
                <i class="fas fa-building text-3xl text-primary mb-4"></i>
                <h3 class="font-bold mb-2 text-charcoal">Official</h3>
                <p class="text-sm ultra-body">Government-level standards</p>
            </div>
            
            <div class="ultra-card p-6 text-center stagger-reveal">
                <i class="fas fa-clock text-3xl text-primary mb-4"></i>
                <h3 class="font-bold mb-2 text-charcoal">24/7 Support</h3>
                <p class="text-sm ultra-body">Always available assistance</p>
            </div>
        </div>
    </div>
</section>
@endsection
