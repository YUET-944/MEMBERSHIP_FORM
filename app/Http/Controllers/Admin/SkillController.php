<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the skills.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $skills = Skill::all();
        return view('admin.skills.index', compact('skills'));
    }

    /**
     * Show the form for creating a new skill.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.skills.create');
    }

    /**
     * Store a newly created skill in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'level' => 'required|integer|min:0|max:100',
            'icon' => 'nullable|string|max:255',
        ]);

        Skill::create($request->only(['name', 'category', 'level', 'icon']));

        return redirect()->route('admin.skills.index')->with('success', 'Skill created successfully.');
    }

    /**
     * Show the form for editing the specified skill.
     *
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\View\View
     */
    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }

    /**
     * Update the specified skill in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'level' => 'required|integer|min:0|max:100',
            'icon' => 'nullable|string|max:255',
        ]);

        $skill->update($request->only(['name', 'category', 'level', 'icon']));

        return redirect()->route('admin.skills.index')->with('success', 'Skill updated successfully.');
    }

    /**
     * Remove the specified skill from storage.
     *
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')->with('success', 'Skill deleted successfully.');
    }
}