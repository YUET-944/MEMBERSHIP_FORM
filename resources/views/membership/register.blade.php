@extends('layouts.app')

@section('title', 'Individual Membership Registration')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-8 stagger-reveal">
        <h1 class="ultra-heading-1 mb-2">Individual Membership Registration</h1>
        <p class="ultra-body text-lg">Complete the form below to join the National Membership System</p>
    </div>

    <!-- Multi-Step Progress Indicator -->
    <div class="ultra-card p-6 mb-8 stagger-reveal" x-data="{ currentStep: 1, totalSteps: 5 }">
        <div class="ultra-step-indicator">
            <div class="ultra-step">
                <div class="ultra-step-number" :class="currentStep >= 1 ? 'active' : ''">1</div>
                <span class="ml-3 text-sm font-medium text-charcoal hidden sm:block">Personal Info</span>
            </div>
            <div class="ultra-step-line" :class="currentStep >= 2 ? 'completed' : ''"></div>
            <div class="ultra-step">
                <div class="ultra-step-number" :class="currentStep >= 2 ? 'active' : (currentStep > 2 ? 'completed' : '')">2</div>
                <span class="ml-3 text-sm font-medium text-charcoal hidden sm:block">Documents</span>
            </div>
            <div class="ultra-step-line" :class="currentStep >= 3 ? 'completed' : ''"></div>
            <div class="ultra-step">
                <div class="ultra-step-number" :class="currentStep >= 3 ? 'active' : (currentStep > 3 ? 'completed' : '')">3</div>
                <span class="ml-3 text-sm font-medium text-charcoal hidden sm:block">Contact</span>
            </div>
            <div class="ultra-step-line" :class="currentStep >= 4 ? 'completed' : ''"></div>
            <div class="ultra-step">
                <div class="ultra-step-number" :class="currentStep >= 4 ? 'active' : (currentStep > 4 ? 'completed' : '')">4</div>
                <span class="ml-3 text-sm font-medium text-charcoal hidden sm:block">Address</span>
            </div>
            <div class="ultra-step-line" :class="currentStep >= 5 ? 'completed' : ''"></div>
            <div class="ultra-step">
                <div class="ultra-step-number" :class="currentStep >= 5 ? 'active' : ''">5</div>
                <span class="ml-3 text-sm font-medium text-charcoal hidden sm:block">Review</span>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('membership.submit') }}" enctype="multipart/form-data" class="glass-ultra p-8 shadow-strong stagger-reveal" x-data="{ submitting: false, currentStep: 1 }" @submit="submitting = true">
        @csrf
        
        <!-- Step 1: Personal Information -->
        <div x-show="currentStep === 1" x-transition:enter.duration.500ms x-transition:leave.duration.400ms>
            <h2 class="ultra-section-header flex items-center">
                <i class="fas fa-user mr-3 text-primary"></i>
                Personal Information
            </h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <x-form-input name="full_name" label="Full Name" urduLabel="پورا نام" required :error="$errors->first('full_name')" />
                <x-form-input name="cnic" label="CNIC Number" urduLabel="شناختی کارڈ نمبر" placeholder="12345-1234567-1" required :error="$errors->first('cnic')" />
                <x-form-input name="date_of_birth" type="date" label="Date of Birth" urduLabel="تاریخ پیدائش" required :error="$errors->first('date_of_birth')" />
                
                <div class="mb-6 relative">
                    <select name="gender" id="gender" class="ultra-input {{ $errors->has('gender') ? 'border-red-500 focus:ring-red-500/20' : '' }}" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                    <label for="gender" class="ultra-floating-label">Gender <span class="text-red-500">*</span></label>
                </div>
                
                <div class="mb-6 relative">
                    <select name="education" id="education" class="ultra-input {{ $errors->has('education') ? 'border-red-500 focus:ring-red-500/20' : '' }}" required>
                        <option value="">Select Education</option>
                        <option value="matric">Matric</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="bachelor">Bachelor's</option>
                        <option value="master">Master's</option>
                        <option value="phd">PhD</option>
                        <option value="other">Other</option>
                    </select>
                    <label for="education" class="ultra-floating-label">Education <span class="text-red-500">*</span></label>
                </div>
                
                <x-form-input name="profession" label="Profession" urduLabel="پیشہ" required :error="$errors->first('profession')" />
            </div>
            
            <div class="flex justify-end mt-6">
                <x-button type="button" @click="currentStep = 2" variant="primary">Next Step <i class="fas fa-arrow-right ml-2"></i></x-button>
            </div>
        </div>

        <!-- Step 2: CNIC Documents -->
        <div x-show="currentStep === 2" style="display: none;" x-transition:enter.duration.500ms x-transition:leave.duration.400ms>
            <h2 class="ultra-section-header flex items-center">
                <i class="fas fa-id-card mr-3 text-primary"></i>
                CNIC Documents
            </h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <x-file-upload name="cnic_front" label="CNIC Front" required maxSize="2MB" :error="$errors->first('cnic_front')" />
                <x-file-upload name="cnic_back" label="CNIC Back" required maxSize="2MB" :error="$errors->first('cnic_back')" />
            </div>
            
            <div class="flex justify-between mt-6">
                <x-button type="button" @click="currentStep = 1" variant="secondary"><i class="fas fa-arrow-left mr-2"></i> Previous</x-button>
                <x-button type="button" @click="currentStep = 3" variant="primary">Next Step <i class="fas fa-arrow-right ml-2"></i></x-button>
            </div>
        </div>

        <!-- Step 3: Contact Details -->
        <div x-show="currentStep === 3" style="display: none;" x-transition:enter.duration.500ms x-transition:leave.duration.400ms>
            <h2 class="ultra-section-header flex items-center">
                <i class="fas fa-phone mr-3 text-primary"></i>
                Contact Details
            </h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <x-form-input name="email" type="email" label="Email Address" urduLabel="ای میل" required :error="$errors->first('email')" />
                <x-form-input name="phone" type="tel" label="Phone Number" urduLabel="فون نمبر" placeholder="03XX-XXXXXXX" required :error="$errors->first('phone')" />
            </div>
            
            <div class="flex justify-between mt-6">
                <x-button type="button" @click="currentStep = 2" variant="secondary"><i class="fas fa-arrow-left mr-2"></i> Previous</x-button>
                <x-button type="button" @click="currentStep = 4" variant="primary">Next Step <i class="fas fa-arrow-right ml-2"></i></x-button>
            </div>
        </div>

        <!-- Step 4: Address -->
        <div x-show="currentStep === 4" style="display: none;" x-transition:enter.duration.500ms x-transition:leave.duration.400ms>
            <h2 class="ultra-section-header flex items-center">
                <i class="fas fa-map-marker-alt mr-3 text-primary"></i>
                Address Information
            </h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="mb-6 relative">
                    <select name="province" id="province" class="ultra-input" required>
                        <option value="">Select Province</option>
                        <option value="Punjab">Punjab</option>
                        <option value="Sindh">Sindh</option>
                        <option value="Khyber Pakhtunkhwa">Khyber Pakhtunkhwa</option>
                        <option value="Balochistan">Balochistan</option>
                        <option value="Islamabad">Islamabad</option>
                        <option value="Gilgit-Baltistan">Gilgit-Baltistan</option>
                        <option value="Azad Kashmir">Azad Kashmir</option>
                    </select>
                    <label for="province" class="ultra-floating-label">Province <span class="text-red-500">*</span></label>
                </div>
                
                <div class="mb-6 relative">
                    <select name="district" id="district" class="ultra-input" required>
                        <option value="">Select District</option>
                    </select>
                    <label for="district" class="ultra-floating-label">District <span class="text-red-500">*</span></label>
                </div>
                
                <div class="mb-6 relative">
                    <select name="tehsil" id="tehsil" class="ultra-input" required>
                        <option value="">Select Tehsil</option>
                    </select>
                    <label for="tehsil" class="ultra-floating-label">Tehsil <span class="text-red-500">*</span></label>
                </div>
                
                <div class="mb-6 relative">
                    <select name="union_council" id="union_council" class="ultra-input" required>
                        <option value="">Select Union Council</option>
                    </select>
                    <label for="union_council" class="ultra-floating-label">Union Council <span class="text-red-500">*</span></label>
                </div>
                
                <div class="md:col-span-2 mb-6 relative">
                    <textarea name="current_address" id="current_address" rows="3" class="ultra-input {{ $errors->has('current_address') ? 'border-red-500 focus:ring-red-500/20' : '' }}" required>{{ old('current_address') }}</textarea>
                    <label for="current_address" class="ultra-floating-label">Current Address <span class="text-red-500">*</span></label>
                </div>
            </div>
            
            <div class="flex justify-between mt-6">
                <x-button type="button" @click="currentStep = 3" variant="secondary"><i class="fas fa-arrow-left mr-2"></i> Previous</x-button>
                <x-button type="button" @click="currentStep = 5" variant="primary">Next Step <i class="fas fa-arrow-right ml-2"></i></x-button>
            </div>
        </div>

        <!-- Step 5: Review & Submit -->
        <div x-show="currentStep === 5" style="display: none;" x-transition:enter.duration.500ms x-transition:leave.duration.400ms>
            <h2 class="ultra-section-header flex items-center">
                <i class="fas fa-check-circle mr-3 text-primary"></i>
                Review & Submit
            </h2>
            
            <div class="space-y-4 mb-6">
                <div class="p-4 bg-primary-50 border border-primary-200 rounded-input">
                    <p class="text-sm text-primary-700 font-medium mb-1">Please review all information before submitting</p>
                </div>
            </div>

            <!-- Terms & Declaration -->
            <div class="space-y-4 mb-6">
                <label class="flex items-start">
                    <input type="checkbox" name="terms_accepted" required class="mt-1 mr-3 w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                    <span class="text-sm ultra-body">I declare that all information provided is true and accurate to the best of my knowledge.</span>
                </label>
                
                <label class="flex items-start">
                    <input type="checkbox" name="privacy_accepted" required class="mt-1 mr-3 w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                    <span class="text-sm ultra-body">I agree to the Privacy Policy and Terms of Service.</span>
                </label>
            </div>
            
            <div class="flex justify-between mt-6">
                <x-button type="button" @click="currentStep = 4" variant="secondary"><i class="fas fa-arrow-left mr-2"></i> Previous</x-button>
                <x-button 
                    type="submit" 
                    variant="primary"
                    :loading="submitting"
                    :disabled="submitting"
                >
                    Submit Application
                </x-button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // CNIC formatting
    document.getElementById('cnic')?.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 5) value = value.slice(0, 5) + '-' + value.slice(5);
        if (value.length > 13) value = value.slice(0, 13) + '-' + value.slice(13, 14);
        e.target.value = value;
        e.target.classList.toggle('has-value', value.length > 0);
    });
    
    // Phone formatting
    document.getElementById('phone')?.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 4) value = value.slice(0, 4) + '-' + value.slice(4, 11);
        e.target.value = value;
        e.target.classList.toggle('has-value', value.length > 0);
    });
    
    // Select fields - update has-value class
    document.querySelectorAll('select.ultra-input').forEach(select => {
        select.addEventListener('change', function() {
            this.classList.toggle('has-value', this.value.length > 0);
        });
    });
</script>
@endpush
