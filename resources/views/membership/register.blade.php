@extends('layouts.app')

@section('title', 'Membership Registration')

@push('styles')
<style>
    .membership-form-container {
        max-width: 1000px;
        margin: 2rem auto;
        padding: 0;
    }
    
    /* Premium Progress Orchid */
    .progress-container {
        margin-bottom: 3rem;
        padding: 0 1rem;
    }
    
    .progress-orchid {
        height: 8px;
        background: var(--bg-light-gray);
        border-radius: var(--radius-xl);
        overflow: hidden;
        position: relative;
        margin-bottom: 1rem;
    }
    
    .progress-orchid-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-green), var(--accent-gold));
        border-radius: var(--radius-xl);
        transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    
    .progress-orchid-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: shimmer 2s infinite;
    }
    
    .progress-text {
        text-align: center;
        color: var(--text-gray);
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    /* Premium Step Indicator */
    .step-indicator {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-bottom: 3rem;
        padding: 0 1rem;
    }
    
    .step-connector {
        position: absolute;
        top: 25px;
        left: 12.5%;
        width: 75%;
        height: 2px;
        background: repeating-linear-gradient(
            to right,
            var(--accent-gold) 0,
            var(--accent-gold) 8px,
            transparent 8px,
            transparent 16px
        );
        z-index: 1;
    }
    
    .step-connector.active {
        background: linear-gradient(90deg, var(--accent-gold), var(--primary-green));
        animation: flow 2s linear infinite;
    }
    
    .step {
        flex: 1;
        text-align: center;
        position: relative;
        z-index: 2;
    }
    
    .step-number {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--bg-white);
        border: 3px solid var(--border-light);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        font-weight: 700;
        color: var(--text-gray);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: var(--font-serif);
        font-size: 1.25rem;
        box-shadow: var(--shadow-sm);
    }
    
    .step.active .step-number {
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        color: white;
        border-color: var(--primary-green);
        box-shadow: var(--shadow-green);
        transform: scale(1.1);
    }
    
    .step.completed .step-number {
        background: linear-gradient(135deg, var(--accent-gold), #f4d03f);
        color: var(--text-charcoal);
        border-color: var(--accent-gold);
        box-shadow: var(--shadow-gold);
    }
    
    .step.completed .step-number::after {
        content: '✓';
        font-size: 1.5rem;
    }
    
    .step-label {
        color: var(--text-gray);
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .step.active .step-label {
        color: var(--primary-green);
        font-weight: 600;
    }
    
    .step-label .urdu-text {
        display: block;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        opacity: 0.8;
    }
    
    /* Form Sections - Single Page Display */
    .form-section {
        display: block;
        margin-bottom: 3rem;
        padding: 2rem;
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(16px) saturate(180%);
        -webkit-backdrop-filter: blur(16px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.6);
    }
    
    .form-section:last-of-type {
        margin-bottom: 0;
    }
    
    /* Premium Form Fields */
    .premium-form-group {
        position: relative;
        margin-bottom: 2rem;
    }
    
    .premium-input {
        width: 100%;
        padding: 1.25rem 1rem 0.75rem;
        background: var(--bg-white);
        border: 2px solid var(--border-light);
        border-radius: var(--radius-md);
        color: var(--text-charcoal);
        font-size: 1rem;
        font-family: var(--font-sans);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        outline: none;
    }
    
    .premium-input:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 4px rgba(30, 77, 43, 0.1), var(--shadow-md);
        transform: translateY(-2px);
    }
    
    .premium-input.important {
        border-image: linear-gradient(135deg, var(--accent-gold), #f4d03f) 1;
        border-width: 2px;
    }
    
    .premium-input.important:focus {
        border-image: linear-gradient(135deg, var(--accent-gold), #f4d03f) 1;
        box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.2), var(--shadow-gold);
    }
    
    .premium-input.invalid {
        border-color: var(--accent-coral);
        animation: shake 0.5s cubic-bezier(0.36, 0.07, 0.19, 0.97);
    }
    
    .premium-input.valid {
        border-color: var(--accent-green);
    }
    
    .floating-label {
        position: absolute;
        left: 1rem;
        top: 1rem;
        color: var(--text-gray);
        pointer-events: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: var(--bg-white);
        padding: 0 0.5rem;
        font-size: 1rem;
        font-weight: 500;
    }
    
    .floating-label .required {
        color: var(--accent-coral);
        margin-left: 0.25rem;
        animation: pulse-asterisk 2s infinite;
    }
    
    @keyframes pulse-asterisk {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    .premium-input:focus + .floating-label,
    .premium-input:not(:placeholder-shown) + .floating-label,
    .premium-input.has-value + .floating-label,
    .premium-select:focus + .floating-label,
    .premium-select.has-value + .floating-label,
    .premium-textarea:focus + .floating-label,
    .premium-textarea:not(:placeholder-shown) + .floating-label,
    .premium-textarea.has-value + .floating-label {
        transform: translateY(-1.5rem) scale(0.85);
        color: var(--primary-green);
        font-weight: 600;
    }
    
    .premium-input::placeholder {
        color: transparent;
    }
    
    .validation-icon {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0;
        transition: all 0.3s ease;
        width: 20px;
        height: 20px;
    }
    
    .premium-input.valid + .floating-label + .validation-icon.check {
        opacity: 1;
        color: var(--accent-green);
    }
    
    .premium-input.invalid + .floating-label + .validation-icon.x {
        opacity: 1;
        color: var(--accent-coral);
    }
    
    /* Premium Select */
    .premium-select {
        width: 100%;
        padding: 1.25rem 1rem 0.75rem;
        background: var(--bg-white);
        border: 2px solid var(--border-light);
        border-radius: var(--radius-md);
        color: var(--text-charcoal);
        font-size: 1rem;
        font-family: var(--font-sans);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        outline: none;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%231e4d2b' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        padding-right: 2.5rem;
    }
    
    .premium-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 4px rgba(30, 77, 43, 0.1), var(--shadow-md);
    }
    
    .premium-select:disabled,
    .premium-input:disabled {
        background: var(--bg-light-gray);
        color: var(--text-gray);
        cursor: not-allowed;
        opacity: 0.6;
        border-color: var(--border-light);
    }
    
    .field-hint {
        font-size: 0.75rem;
        color: var(--text-gray);
        margin-top: 0.5rem;
        font-style: italic;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .field-hint::before {
        content: 'ℹ️';
        font-size: 0.875rem;
    }
    
    /* Premium Textarea */
    .premium-textarea {
        width: 100%;
        padding: 1.25rem 1rem;
        background: var(--bg-white);
        border: 2px solid var(--border-light);
        border-radius: var(--radius-md);
        color: var(--text-charcoal);
        font-size: 1rem;
        font-family: var(--font-sans);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        outline: none;
        resize: vertical;
        min-height: 100px;
    }
    
    .premium-textarea:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 4px rgba(30, 77, 43, 0.1), var(--shadow-md);
    }
    
    /* Premium File Upload */
    .premium-file-upload {
        border: 2px dashed var(--border-light);
        border-radius: var(--radius-lg);
        padding: 2.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: var(--bg-white);
        position: relative;
        overflow: hidden;
    }
    
    .premium-file-upload::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(30, 77, 43, 0.05), rgba(212, 175, 55, 0.05));
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .premium-file-upload:hover {
        border-color: var(--primary-green);
        box-shadow: var(--shadow-md);
    }
    
    .premium-file-upload:hover::before {
        opacity: 1;
    }
    
    .premium-file-upload.dragover {
        border-color: var(--accent-gold);
        background: rgba(212, 175, 55, 0.1);
        transform: scale(1.02);
    }
    
    .file-upload-icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 1rem;
        color: var(--primary-green);
    }
    
    .image-preview {
        max-width: 200px;
        max-height: 200px;
        border-radius: var(--radius-lg);
        margin-top: 1rem;
        box-shadow: var(--shadow-md);
        border: 2px solid var(--border-light);
    }
    
    /* Premium Checkboxes */
    .premium-checkbox-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }
    
    .premium-checkbox-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: var(--bg-white);
        border-radius: var(--radius-md);
        border: 2px solid var(--border-light);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }
    
    .premium-checkbox-item:hover {
        border-color: var(--primary-green);
        box-shadow: var(--shadow-sm);
        transform: translateY(-2px);
    }
    
    .premium-checkbox-item input[type="checkbox"] {
        width: 20px;
        height: 20px;
        margin-right: 0.75rem;
        cursor: pointer;
        accent-color: var(--primary-green);
    }
    
    .premium-checkbox-item input[type="checkbox"]:checked + span {
        color: var(--primary-green);
        font-weight: 600;
    }
    
    .premium-checkbox-item:has(input[type="checkbox"]:checked) {
        border-color: var(--primary-green);
        background: rgba(30, 77, 43, 0.05);
    }
    
    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 2px solid var(--border-light);
    }
    
    /* Error Messages */
    .error-message {
        color: var(--accent-coral);
        font-size: 0.875rem;
        margin-top: 0.5rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .success-message {
        color: var(--accent-green);
        font-size: 0.875rem;
        margin-top: 0.5rem;
        font-weight: 500;
    }
    
    /* Section Headers */
    .section-header {
        font-family: var(--font-serif);
        color: var(--primary-green);
        font-size: 2rem;
        font-weight: 700;
        position: relative;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }
    
    .section-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-green), var(--accent-gold));
        border-radius: var(--radius-sm);
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .step-indicator {
            flex-direction: column;
            gap: 1rem;
        }
        
        .step-connector {
            display: none;
        }
        
        .premium-checkbox-group {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen py-8 px-4" style="background: linear-gradient(135deg, var(--bg-cream) 0%, var(--bg-white) 50%, var(--bg-light-gray) 100%);">
    <div class="membership-form-container">
        <div class="luxury-card glass" style="padding: 3rem;">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="ultra-h1 mb-2">Membership Registration</h1>
                <p class="text-gray-600 urdu-text text-lg">رکنیت کی درخواست</p>
            </div>
            
            <!-- Form -->
            <form id="membershipForm" method="POST" action="{{ route('membership.submit') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Member Type - Fixed to Individual (Hidden) -->
                <input type="hidden" name="member_type" value="individual">
                
                <!-- Section 1: Personal Information -->
                <section class="form-section" id="personal-info">
                    <h2 class="section-header">Personal Information <span class="urdu-text text-lg text-gray-600 font-normal">ذاتی معلومات</span></h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name (Combined) -->
                        <div class="premium-form-group md:col-span-2">
                            <input type="text" name="full_name" id="full_name" class="premium-input" placeholder=" " required autocomplete="name">
                            <label class="floating-label">Full Name <span class="urdu-text">پورا نام</span> <span class="required">*</span></label>
                            <i data-lucide="check" class="validation-icon check"></i>
                            <i data-lucide="x" class="validation-icon x"></i>
                        </div>
                        
                        <!-- CNIC -->
                        <div class="premium-form-group">
                            <input type="text" name="cnic" id="cnic" class="premium-input important" placeholder=" " maxlength="15" required>
                            <label class="floating-label">CNIC <span class="urdu-text">شناختی کارڈ نمبر</span> <span class="required">*</span></label>
                            <i data-lucide="check" class="validation-icon check"></i>
                            <i data-lucide="x" class="validation-icon x"></i>
                        </div>
                        
                        <!-- Date of Birth -->
                        <div class="premium-form-group">
                            <input type="date" name="date_of_birth" id="date_of_birth" class="premium-input" placeholder=" " required>
                            <label class="floating-label">Date of Birth <span class="urdu-text">تاریخ پیدائش</span> <span class="required">*</span></label>
                        </div>
                        
                        <!-- Gender -->
                        <div class="premium-form-group">
                            <select name="gender" id="gender" class="premium-select" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                            <label class="floating-label">Gender <span class="urdu-text">جنس</span> <span class="required">*</span></label>
                        </div>
                        
                        <!-- Education -->
                        <div class="premium-form-group">
                            <select name="education" id="education" class="premium-select" required>
                                <option value="">Select Education</option>
                                <option value="matric">Matric</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="bachelor">Bachelor's</option>
                                <option value="master">Master's</option>
                                <option value="phd">PhD</option>
                                <option value="other">Other</option>
                            </select>
                            <label class="floating-label">Education <span class="urdu-text">تعلیم</span> <span class="required">*</span></label>
                        </div>
                        
                        <!-- Profession -->
                        <div class="premium-form-group">
                            <input type="text" name="profession" id="profession" class="premium-input" placeholder=" " required>
                            <label class="floating-label">Profession <span class="urdu-text">پیشہ</span> <span class="required">*</span></label>
                            <i data-lucide="check" class="validation-icon check"></i>
                            <i data-lucide="x" class="validation-icon x"></i>
                        </div>
                        
                        <!-- Email -->
                        <div class="premium-form-group">
                            <input type="email" name="email" id="email" class="premium-input" placeholder=" " required autocomplete="email">
                            <label class="floating-label">Email Address <span class="urdu-text">ای میل ایڈریس</span> <span class="required">*</span></label>
                            <i data-lucide="check" class="validation-icon check"></i>
                            <i data-lucide="x" class="validation-icon x"></i>
                        </div>
                        
                        <!-- Phone -->
                        <div class="premium-form-group">
                            <div class="flex">
                                <span class="premium-input rounded-r-none px-4 py-3 border-r-0" style="flex-shrink: 0; width: auto;">03</span>
                                <input type="tel" name="phone" id="phone" class="premium-input rounded-l-none" placeholder=" " maxlength="9" required style="flex: 1;" autocomplete="tel">
                            </div>
                            <label class="floating-label" style="left: 4rem;">Mobile Number <span class="urdu-text">موبائل نمبر</span> <span class="required">*</span></label>
                            <i data-lucide="check" class="validation-icon check" style="right: 4rem;"></i>
                            <i data-lucide="x" class="validation-icon x" style="right: 4rem;"></i>
                        </div>
                        
                        <!-- Profile Picture -->
                        <div class="premium-form-group md:col-span-2">
                            <div class="premium-file-upload" id="profileUploadArea">
                                <input type="file" name="profile_picture" id="profilePicture" accept="image/*" class="hidden" required>
                                <button type="button" class="gold-outline-btn upload-trigger">Browse Files</button>
                                <i data-lucide="upload" class="file-upload-icon"></i>
                                <p class="text-gray-700 font-semibold mb-1">Click or drag to upload profile picture</p>
                                <p class="text-gray-500 text-sm">Max 2MB, JPG/PNG only</p>
                                <img id="profilePreview" class="image-preview hidden" alt="Profile Preview">
                            </div>
                        </div>
                    </div>
                </section>
                
                <!-- Section 2: Address Information -->
                <section class="form-section" id="address">
                    <h2 class="section-header">Address <span class="urdu-text text-lg text-gray-600 font-normal">پتہ</span></h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Current Address -->
                        <div class="premium-form-group md:col-span-2">
                            <textarea name="current_address" id="current_address" class="premium-textarea" placeholder=" " rows="3" required></textarea>
                            <label class="floating-label" style="top: 1.25rem;">Current Address <span class="urdu-text">موجودہ پتہ</span> <span class="required">*</span></label>
                        </div>
                        
                        <!-- Permanent Address -->
                        <div class="premium-form-group md:col-span-2">
                            <textarea name="permanent_address" id="permanent_address" class="premium-textarea" placeholder=" " rows="3"></textarea>
                            <label class="floating-label" style="top: 1.25rem;">Permanent Address <span class="urdu-text">مستقل پتہ</span></label>
                            <label class="flex items-center mt-2 cursor-pointer">
                                <input type="checkbox" id="sameAsCurrent" class="mr-2 w-4 h-4 accent-green-600">
                                <span class="text-gray-700">Same as Current Address</span>
                            </label>
                        </div>
                        
                        <!-- Province -->
                        <div class="premium-form-group">
                            <select name="province" id="province" class="premium-select" required>
                                <option value="">Select Province</option>
                                @foreach(['Punjab', 'Sindh', 'Khyber Pakhtunkhwa', 'Balochistan', 'Islamabad', 'Gilgit-Baltistan', 'Azad Kashmir'] as $province)
                                    <option value="{{ $province }}">{{ $province }}</option>
                                @endforeach
                            </select>
                            <label class="floating-label">Province <span class="urdu-text">صوبہ</span> <span class="required">*</span></label>
                        </div>
                        
                        <!-- Division -->
                        <div class="premium-form-group">
                            <input type="text" name="division" id="division" class="premium-input" placeholder=" ">
                            <label class="floating-label">Division <span class="urdu-text">ڈویژن</span></label>
                            <i data-lucide="check" class="validation-icon check"></i>
                        </div>
                        
                        <!-- District -->
                        <div class="premium-form-group">
                            <input type="text" name="district" id="district" class="premium-input" placeholder=" ">
                            <label class="floating-label">District <span class="urdu-text">ضلع</span></label>
                            <i data-lucide="check" class="validation-icon check"></i>
                        </div>
                        
                        <!-- Tehsil/City -->
                        <div class="premium-form-group">
                            <input type="text" name="tehsil_city" id="tehsil_city" class="premium-input" placeholder=" ">
                            <label class="floating-label">Tehsil/City <span class="urdu-text">تحصیل / شہر</span></label>
                            <i data-lucide="check" class="validation-icon check"></i>
                        </div>
                        
                        <!-- Resident Type -->
                        <div class="premium-form-group">
                            <select name="resident_type" id="resident_type" class="premium-select" required>
                                <option value="pakistani">Pakistani</option>
                                <option value="other">Other</option>
                            </select>
                            <label class="floating-label">Resident Type <span class="urdu-text">رہائشی کی قسم</span></label>
                        </div>
                    </div>
                </section>
                
                <!-- Section 3: Social Media -->
                <section class="form-section" id="social-media">
                    <h2 class="section-header">Social Media <span class="urdu-text text-lg text-gray-600 font-normal">سوشل میڈیا</span></h2>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div class="premium-form-group">
                            <input type="url" name="facebook_url" id="facebook_url" class="premium-input" placeholder=" ">
                            <label class="floating-label">Facebook Profile URL</label>
                            <i data-lucide="check" class="validation-icon check"></i>
                        </div>
                        
                        <div class="premium-form-group">
                            <input type="url" name="twitter_url" id="twitter_url" class="premium-input" placeholder=" ">
                            <label class="floating-label">Twitter Profile URL</label>
                            <i data-lucide="check" class="validation-icon check"></i>
                        </div>
                        
                        <div class="premium-form-group">
                            <input type="url" name="instagram_url" id="instagram_url" class="premium-input" placeholder=" ">
                            <label class="floating-label">Instagram Profile URL</label>
                            <i data-lucide="check" class="validation-icon check"></i>
                        </div>
                        
                        <div class="premium-form-group">
                            <input type="url" name="tiktok_url" id="tiktok_url" class="premium-input" placeholder=" ">
                            <label class="floating-label">TikTok Profile URL</label>
                            <i data-lucide="check" class="validation-icon check"></i>
                        </div>
                    </div>
                </section>
                
                <!-- Section 4: Volunteering Preferences -->
                <section class="form-section" id="volunteering">
                    <h2 class="section-header">Volunteering <span class="urdu-text text-lg text-gray-600 font-normal">رضاکارانہ</span></h2>
                    
                    <div class="premium-checkbox-group">
                        <label class="premium-checkbox-item">
                            <input type="checkbox" name="volunteering_preferences[]" value="polling_agent">
                            <span>Polling Agent</span>
                        </label>
                        <label class="premium-checkbox-item">
                            <input type="checkbox" name="volunteering_preferences[]" value="social_causes">
                            <span>Social Causes</span>
                        </label>
                        <label class="premium-checkbox-item">
                            <input type="checkbox" name="volunteering_preferences[]" value="door_to_door">
                            <span>Door-to-Door Canvassing</span>
                        </label>
                        <label class="premium-checkbox-item">
                            <input type="checkbox" name="volunteering_preferences[]" value="phone_campaign">
                            <span>Phone Campaign</span>
                        </label>
                        <label class="premium-checkbox-item">
                            <input type="checkbox" name="volunteering_preferences[]" value="election_day">
                            <span>Election Day</span>
                        </label>
                        <label class="premium-checkbox-item">
                            <input type="checkbox" name="volunteering_preferences[]" value="member_drive">
                            <span>Member Drive</span>
                        </label>
                        <label class="premium-checkbox-item">
                            <input type="checkbox" name="volunteering_preferences[]" value="mentoring">
                            <span>Mentoring Program</span>
                        </label>
                        <label class="premium-checkbox-item">
                            <input type="checkbox" name="volunteering_preferences[]" value="environmental">
                            <span>Environmental Sustainability</span>
                        </label>
                        <label class="premium-checkbox-item">
                            <input type="checkbox" name="volunteering_preferences[]" value="social_media">
                            <span>Social Media</span>
                        </label>
                        <label class="premium-checkbox-item">
                            <input type="checkbox" name="volunteering_preferences[]" value="legal_aid">
                            <span>Legal Aid</span>
                        </label>
                        <label class="premium-checkbox-item">
                            <input type="checkbox" name="volunteering_preferences[]" value="event_organization">
                            <span>Event Organization</span>
                        </label>
                        <label class="premium-checkbox-item">
                            <input type="checkbox" name="volunteering_preferences[]" value="medical_aid">
                            <span>Medical Aid</span>
                        </label>
                        <label class="premium-checkbox-item">
                            <input type="checkbox" name="volunteering_preferences[]" value="other" id="volunteer_other">
                            <span>Other</span>
                        </label>
                    </div>
                    
                    <div class="premium-form-group mt-4" id="volunteer_other_input" style="display: none;">
                        <input type="text" name="volunteering_other" id="volunteering_other" class="premium-input" placeholder=" ">
                        <label class="floating-label">Please specify</label>
                    </div>
                </section>
                
                <!-- Form Actions -->
                <div class="form-actions">
                    <div style="flex: 1;"></div>
                    <button type="submit" id="submitBtn" class="btn-primary px-8 py-3 rounded-lg font-semibold">Submit Registration</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialize Lucide icons
    lucide.createIcons();
    
    // CNIC formatting
    const cnicField = document.getElementById('cnic');
    if (cnicField) {
        cnicField.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 5) {
                value = value.substring(0, 5) + '-' + value.substring(5);
            }
            if (value.length > 13) {
                value = value.substring(0, 13) + '-' + value.substring(13, 14);
            }
            e.target.value = value;
            validateField(e.target);
        });
    }
    
    // Real-time validation
    function validateField(field) {
        const value = field.value.trim();
        const type = field.type;
        const name = field.name;
        
        field.classList.remove('valid', 'invalid', 'has-value');
        
        if (!value && field.hasAttribute('required') && !field.disabled) {
            field.classList.add('invalid');
            return false;
        }
        
        if (value) {
            field.classList.add('has-value');
        }
        
        if (type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailRegex.test(value)) {
                field.classList.add('valid');
            } else {
                field.classList.add('invalid');
            }
        } else if (name === 'phone' && value) {
            if (value.length === 9 && /^\d+$/.test(value)) {
                field.classList.add('valid');
            } else {
                field.classList.add('invalid');
            }
        } else if (name === 'cnic' && value) {
            if (value.length === 15) {
                field.classList.add('valid');
            } else {
                field.classList.add('invalid');
            }
        } else if (name === 'full_name' && value) {
            if (value.length >= 3) {
                field.classList.add('valid');
            } else {
                field.classList.add('invalid');
            }
        } else if (value) {
            field.classList.add('valid');
        }
        
        // Update icons
        lucide.createIcons();
    }
    
    // Add validation to all inputs
    document.querySelectorAll('.premium-input, .premium-select, .premium-textarea').forEach(field => {
        if (!field.disabled) {
            field.addEventListener('blur', () => validateField(field));
            field.addEventListener('input', function() {
                if (this.value) {
                    this.classList.add('has-value');
                } else {
                    this.classList.remove('has-value');
                }
                validateField(this);
            });
            if (field.tagName === 'SELECT') {
                field.addEventListener('change', function() {
                    if (this.value) {
                        this.classList.add('has-value');
                    } else {
                        this.classList.remove('has-value');
                    }
                    validateField(this);
                });
            }
        }
    });
    document.querySelectorAll('.premium-select, .premium-textarea').forEach(field => {
        if (field.value) {
            field.classList.add('has-value');
        }
    });
    
    // Profile picture upload
    const profileUploadArea = document.getElementById('profileUploadArea');
    const profilePicture = document.getElementById('profilePicture');
    const profilePreview = document.getElementById('profilePreview');
    
    if (profileUploadArea && profilePicture) {
        profileUploadArea.addEventListener('click', () => profilePicture.click());
        profileUploadArea.querySelector('.upload-trigger')?.addEventListener('click', (e) => {
            e.stopPropagation();
            profilePicture.click();
        });
        profileUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            profileUploadArea.classList.add('dragover');
        });
        profileUploadArea.addEventListener('dragleave', () => {
            profileUploadArea.classList.remove('dragover');
        });
        profileUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            profileUploadArea.classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            if (file) {
                profilePicture.files = e.dataTransfer.files;
                showPreview(file);
            }
        });
        
        profilePicture.addEventListener('change', (e) => {
            if (e.target.files[0]) {
                showPreview(e.target.files[0]);
            }
        });
    }
    
    function showPreview(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            profilePreview.src = e.target.result;
            profilePreview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
    
    // Same as current address
    document.getElementById('sameAsCurrent')?.addEventListener('change', function(e) {
        if (e.target.checked) {
            const currentAddress = document.getElementById('current_address').value;
            document.getElementById('permanent_address').value = currentAddress;
        }
    });
    
    // Volunteering other
    document.getElementById('volunteer_other')?.addEventListener('change', function(e) {
        document.getElementById('volunteer_other_input').style.display = e.target.checked ? 'block' : 'none';
    });
    
    // Note: Division, District, and Tehsil/City are now plain text fields
    // No cascading dropdown logic needed
    
    // Form submission validation
    document.getElementById('membershipForm').addEventListener('submit', function(e) {
        let isValid = true;
        const requiredFields = this.querySelectorAll('[required]:not(:disabled)');
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('invalid');
                // Scroll to first invalid field
                if (isValid) {
                    field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            } else {
                field.classList.remove('invalid');
                validateField(field);
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            return false;
        }
        
        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner"></span> Submitting...';
    });
</script>
@endpush
@endsection
