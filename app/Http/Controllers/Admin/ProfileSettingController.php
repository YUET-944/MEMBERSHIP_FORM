<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileSetting;
use Illuminate\Http\Request;

class ProfileSettingController extends Controller
{
    /**
     * Display the profile settings form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $profile = ProfileSetting::first() ?? new ProfileSetting();
        return view('admin.profile.index', compact('profile'));
    }

    /**
     * Update the profile settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'profile_avatar' => 'nullable|string|max:255',
            'theme' => 'nullable|string|max:50',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
        ]);

        $profile = ProfileSetting::first();
        
        if ($profile) {
            $profile->update($request->only([
                'name', 'title', 'bio', 'profile_avatar',
                'facebook_url', 'twitter_url', 'linkedin_url', 'youtube_url', 'instagram_url',
                'theme',
            ]));
        } else {
            $profile = ProfileSetting::create($request->only([
                'name', 'title', 'bio', 'profile_avatar',
                'facebook_url', 'twitter_url', 'linkedin_url', 'youtube_url', 'instagram_url',
                'theme',
            ]));
        }

        return redirect()->back()->with('success', 'Profile settings updated successfully.');
    }
}