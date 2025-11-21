<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\ProfileSetting;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        // Get the profile settings with theme
        $profile = ProfileSetting::first();
        $theme = $profile ? $profile->theme : 'default';
        
        return view('layouts.app', compact('theme'));
    }
}