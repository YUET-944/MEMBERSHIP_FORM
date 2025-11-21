<?php

namespace App\Http\Controllers;

use App\Models\ProfileSetting;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $profile = ProfileSetting::first();
        $skills = Skill::all();
        $projects = Project::where('status', 'published')->get();
        $services = Service::all();
        $testimonials = Testimonial::all();
        $theme = $profile ? $profile->theme : 'default';
        
        return view('home', compact('profile', 'skills', 'projects', 'services', 'testimonials', 'theme'));
    }
}