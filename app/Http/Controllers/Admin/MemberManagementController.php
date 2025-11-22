<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Services\CertificateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MemberManagementController extends Controller
{
    protected CertificateService $certificateService;

    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    /**
     * List all members
     */
    public function index(Request $request)
    {
        $query = Member::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('membership_id', 'like', "%{$search}%");
            });
        }

        $members = $query->latest()->paginate(20);

        return view('admin.members.index', [
            'members' => $members,
        ]);
    }

    /**
     * Show member details
     */
    public function show(Member $member)
    {
        return view('admin.members.show', [
            'member' => $member,
        ]);
    }

    /**
     * Approve member
     */
    public function approve(Member $member, Request $request)
    {
        $member->update([
            'status' => 'approved',
            'approved_at' => now(),
            'expires_at' => now()->addYear(),
        ]);

        // Generate certificate
        $this->certificateService->generate($member);

        Log::info('Member approved', [
            'member_id' => $member->id,
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Member approved successfully');
    }

    /**
     * Reject member
     */
    public function reject(Member $member, Request $request)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $member->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason ?? 'Application rejected by administrator',
        ]);

        Log::info('Member rejected', [
            'member_id' => $member->id,
            'rejected_by' => auth()->id(),
            'reason' => $request->rejection_reason ?? 'Application rejected by administrator',
        ]);

        return back()->with('success', 'Member rejected');
    }

    /**
     * View document
     */
    public function viewDocument(Member $member, $documentId)
    {
        $document = $member->documents()->findOrFail($documentId);
        
        // Decrypt and return document
        $encryptedContent = Storage::disk('private')->get($document->file_path);
        $decryptedContent = app(\App\Services\EncryptionService::class)->decrypt($encryptedContent);
        
        return response($decryptedContent)
            ->header('Content-Type', $document->mime_type);
    }
}

