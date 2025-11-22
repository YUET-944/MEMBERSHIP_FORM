<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * List all members
     */
    public function index(Request $request)
    {
        $query = Member::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $members = $query->latest()->paginate(20);

        return response()->json($members);
    }

    /**
     * Show member details
     */
    public function show(Member $member)
    {
        return response()->json([
            'member' => [
                'id' => $member->id,
                'membership_id' => $member->membership_id,
                'first_name' => $member->first_name,
                'last_name' => $member->last_name,
                'status' => $member->status,
                'masked_cnic' => $member->masked_cnic,
                'masked_phone' => $member->masked_phone,
            ],
        ]);
    }

    /**
     * Approve member
     */
    public function approve(Member $member)
    {
        $member->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return response()->json(['message' => 'Member approved successfully']);
    }

    /**
     * Reject member
     */
    public function reject(Member $member, Request $request)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $member->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return response()->json(['message' => 'Member rejected']);
    }
}

