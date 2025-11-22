<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Services\TwoFactorService;
use App\Http\Middleware\AuthenticationSecurityMiddleware;
use App\Models\SecurityEvent;

class MemberAuthController extends Controller
{
    protected TwoFactorService $twoFactorService;

    public function __construct(TwoFactorService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.member.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Check if account should be locked
        if (AuthenticationSecurityMiddleware::shouldLockAccount($request->email, $request->ip())) {
            SecurityEvent::log(
                SecurityEvent::TYPE_ACCOUNT_LOCKED,
                SecurityEvent::SEVERITY_HIGH,
                [
                    'email' => $request->email,
                    'ip_address' => $request->ip(),
                    'description' => 'Account locked due to multiple failed login attempts',
                ]
            );
            
            return back()->with('error', 'Too many failed login attempts. Please try again in 15 minutes.');
        }

        $member = Member::where('email', $request->email)->first();

        if (!$member || !Hash::check($request->password, $member->password)) {
            // Record failed attempt
            AuthenticationSecurityMiddleware::recordFailedAttempt(
                $request->email,
                $request->ip(),
                $request->userAgent(),
                'Invalid credentials'
            );

            return back()->with('error', 'Invalid credentials');
        }

        if ($member->status !== 'approved') {
            return back()->with('error', 'Your membership is not approved yet.');
        }

        // Check if 2FA is enabled
        if ($member->hasTwoFactorEnabled()) {
            // Generate 2FA code
            $code = $this->twoFactorService->generateCode($member->two_factor_secret);
            
            // Store member ID in session
            $request->session()->put('2fa_member_id', $member->id);
            
            return redirect()->route('member.2fa.verify');
        }

        // Record successful login attempt
        AuthenticationSecurityMiddleware::recordSuccessfulAttempt(
            $request->email,
            $request->ip(),
            $request->userAgent()
        );

        // Login without 2FA - Use web guard for session authentication
        Auth::guard('web')->login($member, $request->has('remember'));
        $request->session()->regenerate();
        $request->session()->put('2fa_verified', true);

        return redirect()->route('member.dashboard');
    }

    /**
     * Show 2FA verification
     */
    public function show2FAVerification()
    {
        if (!session()->has('2fa_member_id')) {
            return redirect()->route('member.login');
        }

        return view('auth.member.2fa-verify');
    }

    /**
     * Verify 2FA
     */
    public function verify2FA(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $memberId = session()->get('2fa_member_id');
        $member = Member::findOrFail($memberId);

        if (!$this->twoFactorService->verifyCode($member->two_factor_secret, $request->code)) {
            return back()->with('error', 'Invalid 2FA code');
        }

        Auth::guard('web')->login($member);
        $request->session()->regenerate();
        $request->session()->put('2fa_verified', true);
        $request->session()->forget('2fa_member_id');

        return redirect()->route('member.dashboard');
    }

    /**
     * Show 2FA setup
     */
    public function show2FASetup()
    {
        $member = Auth::guard('web')->user();
        
        if ($member->hasTwoFactorEnabled()) {
            return redirect()->route('member.dashboard');
        }

        $qrCode = $this->twoFactorService->generateQRCode($member);
        $recoveryCodes = $this->twoFactorService->generateRecoveryCodes();

        return view('auth.member.2fa-setup', [
            'qrCode' => $qrCode,
            'recoveryCodes' => $recoveryCodes,
        ]);
    }

    /**
     * Setup 2FA
     */
    public function setup2FA(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $member = Auth::guard('web')->user();
        $secret = session()->get('2fa_secret');

        if (!$this->twoFactorService->verifyCode($secret, $request->code)) {
            return back()->with('error', 'Invalid code');
        }

        $member->update([
            'two_factor_secret' => encrypt($secret),
            'two_factor_recovery_codes' => encrypt(json_encode(session()->get('2fa_recovery_codes'))),
            'two_factor_enabled_at' => now(),
        ]);

        session()->forget(['2fa_secret', '2fa_recovery_codes']);

        return redirect()->route('member.dashboard')
            ->with('success', '2FA enabled successfully');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}

