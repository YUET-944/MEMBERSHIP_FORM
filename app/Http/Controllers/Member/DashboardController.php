<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Services\CertificateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected CertificateService $certificateService;

    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    /**
     * Show member dashboard
     */
    public function index()
    {
        $member = Auth::guard('sanctum')->user();
        
        return view('member.dashboard', [
            'member' => $member,
        ]);
    }

    /**
     * Show profile
     */
    public function profile()
    {
        $member = Auth::guard('sanctum')->user();
        
        return view('member.profile', [
            'member' => $member,
        ]);
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        $member = Auth::guard('sanctum')->user();
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'profession' => 'nullable|string|max:100',
            'education' => 'nullable|string',
        ]);

        $member->update($validated);

        return back()->with('success', 'Profile updated successfully');
    }

    /**
     * Download certificate
     */
    public function downloadCertificate()
    {
        $member = Auth::guard('sanctum')->user();
        
        if (!$member->isApproved()) {
            return back()->with('error', 'Your membership is not approved yet.');
        }

        if (!$member->certificate_path || !file_exists(storage_path('app/' . $member->certificate_path))) {
            // Generate certificate if not exists
            $this->certificateService->generate($member);
            $member->refresh();
        }

        return response()->download(
            storage_path('app/' . $member->certificate_path),
            'membership-certificate-' . $member->membership_id . '.pdf'
        );
    }
}

