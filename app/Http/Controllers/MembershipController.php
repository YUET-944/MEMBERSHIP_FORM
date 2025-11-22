<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberDocument;
use App\Services\OtpService;
use App\Services\EncryptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Membership Controller
 * 
 * Handles membership registration and OTP verification
 */
class MembershipController extends Controller
{
    protected OtpService $otpService;
    protected EncryptionService $encryptionService;

    public function __construct(OtpService $otpService, EncryptionService $encryptionService)
    {
        $this->otpService = $otpService;
        $this->encryptionService = $encryptionService;
    }

    /**
     * Show registration form
     */
    public function showRegistrationForm()
    {
        return view('membership.register');
    }

    /**
     * Submit membership application
     */
    public function submit(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'member_type' => 'required|in:individual',
            'full_name' => 'required|string|max:200|min:3',
            'email' => 'required|email|unique:members,email',
            'phone' => 'required|string|regex:/^\d{9}$/',
            'cnic' => 'required|string|regex:/^\d{5}-\d{7}-\d{1}$/|unique:members,cnic',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'education' => 'required|string',
            'profession' => 'required|string|max:100',
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'resident_type' => 'required|in:pakistani,other',
            'province' => 'required|string',
            'division' => 'nullable|string',
            'district' => 'nullable|string',
            'tehsil_city' => 'nullable|string',
            'current_address' => 'required|string|max:500',
            'permanent_address' => 'nullable|string|max:500',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            'volunteering_preferences' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Handle profile picture upload with security service
            $fileSecurity = app(FileUploadSecurityService::class);
            $uploadResult = $fileSecurity->validateAndStore($request->file('profile_picture'), 'profile');
            
            if (!$uploadResult['success']) {
                return back()->with('error', $uploadResult['error'])->withInput();
            }
            
            $profilePath = $uploadResult['path'];

            // Format phone number
            $phone = '03' . $request->phone;

            // Create member record
            $member = Member::create([
                'member_type' => $request->member_type,
                'full_name' => $request->full_name, // Store full name directly
                'email' => $request->email, // Will be encrypted by trait
                'phone' => $phone, // Will be encrypted by trait
                'cnic' => $request->cnic, // Will be encrypted by trait
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender ?? null, // Optional - admin verification
                'education' => $request->education ?? null, // Optional - admin verification
                'profession' => $request->profession,
                'profile_picture' => $profilePath,
                'resident_type' => $request->resident_type,
                'province' => $request->province,
                'division' => $request->division,
                'district' => $request->district,
                'tehsil_city' => $request->tehsil_city,
                'address' => $request->current_address, // Will be encrypted by trait
                'permanent_address' => $request->permanent_address ?? $request->current_address, // Will be encrypted by trait
                'current_address' => $request->current_address,
                'volunteering_preferences' => json_encode($request->volunteering_preferences ?? []),
                'status' => 'pending',
                'password' => Hash::make(Str::random(16)), // Temporary password, will be set via OTP
            ]);

            // Generate OTP for email and SMS
            $emailOtp = $this->otpService->generate($member->email, 'email', 'registration');
            $smsOtp = $this->otpService->generate($phone, 'sms', 'registration');

            // Send OTP (implement email/SMS sending here)
            // Mail::to($member->email)->send(new OtpMail($emailOtp));
            // SmsService::send($phone, "Your OTP is: {$smsOtp}");

            // Store member ID in session for OTP verification
            $request->session()->put('pending_member_id', $member->id);
            $request->session()->put('otp_email', $member->email);
            $request->session()->put('otp_phone', $phone);

            Log::info('Membership application submitted', [
                'member_id' => $member->id,
                'membership_id' => $member->membership_id,
            ]);

            return redirect()->route('membership.verify-otp')
                ->with('success', 'Application submitted successfully. Please verify your email and phone number.');

        } catch (\Exception $e) {
            Log::error('Membership submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Failed to submit application. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show OTP verification page
     */
    public function showOtpVerification()
    {
        if (!session()->has('pending_member_id')) {
            return redirect()->route('membership.register');
        }

        return view('membership.verify-otp');
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_otp' => 'required|string|size:6',
            'sms_otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $memberId = session()->get('pending_member_id');
        $email = session()->get('otp_email');
        $phone = session()->get('otp_phone');

        if (!$memberId || !$email || !$phone) {
            return redirect()->route('membership.register')
                ->with('error', 'Session expired. Please register again.');
        }

        // Verify both OTPs
        $emailVerified = $this->otpService->verify($email, $request->email_otp, 'email');
        $smsVerified = $this->otpService->verify($phone, $request->sms_otp, 'sms');

        if (!$emailVerified || !$smsVerified) {
            return back()->with('error', 'Invalid OTP. Please try again.');
        }

        // Update member status
        $member = Member::findOrFail($memberId);
        $member->update([
            'email_verified_at' => now(),
        ]);

        // Clear session
        session()->forget(['pending_member_id', 'otp_email', 'otp_phone']);

        Log::info('OTP verified successfully', [
            'member_id' => $member->id,
        ]);

        return redirect()->route('member.login')
            ->with('success', 'Registration completed successfully! Please login to set your password.');
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request)
    {
        $memberId = session()->get('pending_member_id');
        $email = session()->get('otp_email');
        $phone = session()->get('otp_phone');

        if (!$memberId || !$email || !$phone) {
            return response()->json(['error' => 'Session expired'], 400);
        }

        try {
            $emailOtp = $this->otpService->resend($email, 'email');
            $smsOtp = $this->otpService->resend($phone, 'sms');

            // Send OTP (implement email/SMS sending here)

            return response()->json([
                'message' => 'OTP resent successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to resend OTP. Please try again later.',
            ], 500);
        }
    }

    /**
     * Handle file upload with encryption (Legacy method - kept for backward compatibility)
     * 
     * @deprecated Use FileUploadSecurityService instead
     */
    private function handleFileUpload($file, string $directory): string
    {
        // Use the new security service
        $fileSecurity = app(FileUploadSecurityService::class);
        $result = $fileSecurity->validateAndStore($file, $directory === 'profile_pictures' ? 'profile' : 'document');
        
        if (!$result['success']) {
            throw new \Exception($result['error']);
        }

        // Encrypt file content if needed
        $filePath = storage_path('app/private/' . $result['path']);
        if (file_exists($filePath)) {
            $encryptedContent = $this->encryptionService->encryptFile($filePath);
            file_put_contents($filePath, $encryptedContent);
        }

        return $result['path'];
    }
}

