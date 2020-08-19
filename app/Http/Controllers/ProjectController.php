<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->accessibleProjects();
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
//        Этот способ мне нравится больше, но я учусь использовать Policy
//        if (auth()->user()->isNot($project->user_id)) {
//            abort(403);
//        }
//        OR
//        abort_if(auth()->user()->isNot($project->user_id), 403);
//        if (\Gate::denies('can-view', $project)) {
//            abort(403);
//        }
        $this->authorize('view', $project);
        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store()
    {
        $project = auth()->user()->projects()->create($this->validateRequest());

        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Project $project)
    {
        $this->authorize('view', $project);
//        abort_if(auth()->id() !=  $project->user_id, 403);
        $project->update($this->validateRequest());

        return redirect($project->path());
    }

    public function destroy(Project $project)
    {
        $this->authorize('manage', $project);

        $project->delete();

        return redirect(route('projects.index'));
    }

    protected function validateRequest()
    {
        return \request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable',
        ]);
    }
}
