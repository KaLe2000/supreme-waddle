<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function store()
    {
        Project::create(
            \request()->validate([
                'title' => 'required',
                'description' => 'required'
            ])
        );

        return redirect('/projects');
    }
}
