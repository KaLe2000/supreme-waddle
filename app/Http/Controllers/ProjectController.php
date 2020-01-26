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
//        Этот способ мне нравится больше, но я учусь использовать Policy
//        if (auth()->user()->isNot($project->user_id)) {
//            abort(403);
//        }
        if (\Gate::denies('can-view', $project)) {
            abort(403);
        }
        return view('projects.show', compact('project'));
    }

    public function store()
    {
        auth()->user()->projects()->create(
            \request()->validate([
                'title' => 'required',
                'description' => 'required'
            ])
        );

        return redirect('/projects');
    }
}
