<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\ContactMessage;

class DashboardController extends Controller
{
    public function index()
    {
        $projectCount = Project::count();
        $skillCount = Skill::count();
        $serviceCount = Service::count();
        $testimonialCount = Testimonial::count();
        $messageCount = ContactMessage::count();

        return view('admin.dashboard', compact('projectCount', 'skillCount', 'serviceCount', 'testimonialCount', 'messageCount'));
    }
}