<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the projects.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $projects = Project::where('status', 'published')->get();
        return view('projects.index', compact('projects'));
    }

    /**
     * Display the specified project.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $project = Project::where('slug', $slug)->where('status', 'published')->firstOrFail();
        return view('projects.show', compact('project'));
    }
}