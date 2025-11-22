<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MembershipController extends Controller
{
    protected OtpService $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Register new member
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:members,email',
            'phone' => 'required|string',
            'cnic' => 'required|string|unique:members,cnic',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $member = Member::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'cnic' => $request->cnic,
            'password' => Hash::make(Str::random(16)),
            'status' => 'pending',
        ]);

        $otp = $this->otpService->generate($member->email, 'email', 'registration');

        return response()->json([
            'message' => 'Registration successful. Please verify OTP.',
            'member_id' => $member->id,
        ], 201);
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string',
            'otp' => 'required|string|size:6',
            'type' => 'required|in:email,sms',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $verified = $this->otpService->verify(
            $request->identifier,
            $request->otp,
            $request->type
        );

        if (!$verified) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        return response()->json(['message' => 'OTP verified successfully']);
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identifier' => 'required|string',
            'type' => 'required|in:email,sms',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $otp = $this->otpService->resend($request->identifier, $request->type);
            return response()->json(['message' => 'OTP resent successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Get provinces
     */
    public function getProvinces()
    {
        $provinces = [
            'Punjab',
            'Sindh',
            'Khyber Pakhtunkhwa',
            'Balochistan',
            'Islamabad',
            'Gilgit-Baltistan',
            'Azad Kashmir',
        ];

        return response()->json($provinces);
    }

    /**
     * Get divisions
     */
    public function getDivisions($province)
    {
        // Placeholder - implement based on your data
        return response()->json([]);
    }

    /**
     * Get districts
     */
    public function getDistricts($division)
    {
        // Placeholder - implement based on your data
        return response()->json([]);
    }

    /**
     * Get tehsils
     */
    public function getTehsils($district)
    {
        // Placeholder - implement based on your data
        return response()->json([]);
    }
}

