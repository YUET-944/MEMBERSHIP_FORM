<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\TwoFactorService;

class AdminController extends Controller
{
    protected TwoFactorService $twoFactorService;

    public function __construct(TwoFactorService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }

    /**
     * Show admin login form
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Handle admin login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->with('error', 'Invalid credentials');
        }

        if (!$user->is_active) {
            return back()->with('error', 'Account is suspended');
        }

        // Check 2FA
        if (method_exists($user, 'hasTwoFactorEnabled') && $user->hasTwoFactorEnabled()) {
            $request->session()->put('2fa_user_id', $user->id);
            return redirect()->route('admin.2fa.verify');
        }

        // Use standard web guard for session authentication
        Auth::guard('web')->login($user, $request->has('remember'));
        $request->session()->regenerate();
        $request->session()->put('2fa_verified', true);

        return redirect()->route('admin.dashboard');
    }

    /**
     * Show 2FA verification
     */
    public function show2FAVerification()
    {
        if (!session()->has('2fa_user_id')) {
            return redirect()->route('admin.login');
        }

        return view('admin.2fa-verify');
    }

    /**
     * Verify 2FA
     */
    public function verify2FA(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $userId = session()->get('2fa_user_id');
        $user = \App\Models\User::findOrFail($userId);

        if (!$this->twoFactorService->verifyCode($user->two_factor_secret, $request->code)) {
            return back()->with('error', 'Invalid 2FA code');
        }

        Auth::guard('web')->login($user);
        $request->session()->regenerate();
        $request->session()->put('2fa_verified', true);
        $request->session()->forget('2fa_user_id');

        return redirect()->route('admin.dashboard');
    }

    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_members' => \App\Models\Member::count(),
            'pending_members' => \App\Models\Member::where('status', 'pending')->count(),
            'approved_members' => \App\Models\Member::where('status', 'approved')->count(),
            'rejected_members' => \App\Models\Member::where('status', 'rejected')->count(),
        ];

        return view('admin.dashboard', [
            'stats' => $stats,
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}

