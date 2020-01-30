<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        $project->addTask(request()->validate([
            'body' => 'required'
        ]));

        return redirect($project->path());
    }
}
