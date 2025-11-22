<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Get member profile
     */
    public function profile()
    {
        $member = Auth::guard('sanctum')->user();
        
        return response()->json([
            'member' => [
                'id' => $member->id,
                'membership_id' => $member->membership_id,
                'first_name' => $member->first_name,
                'last_name' => $member->last_name,
                'status' => $member->status,
            ],
        ]);
    }

    /**
     * Update member profile
     */
    public function updateProfile(Request $request)
    {
        $member = Auth::guard('sanctum')->user();
        
        $validated = $request->validate([
            'first_name' => 'sometimes|string|max:100',
            'last_name' => 'sometimes|string|max:100',
        ]);

        $member->update($validated);

        return response()->json(['message' => 'Profile updated successfully']);
    }

    /**
     * Download certificate
     */
    public function downloadCertificate()
    {
        $member = Auth::guard('sanctum')->user();
        
        if (!$member->isApproved()) {
            return response()->json(['message' => 'Membership not approved'], 403);
        }

        // Certificate download logic
        return response()->json(['message' => 'Certificate download']);
    }
}

