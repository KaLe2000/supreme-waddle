<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Carbon\Carbon;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        // create the policy like in ProjectController
        abort_if(auth()->id() != $project->user_id, 403);

        request()->validate([
            'body' => 'required'
        ]);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Project $project, Task $task)
    {
        abort_if(auth()->id() != $project->user_id, 403);

        request()->validate([
            'body' => 'required'
        ]);

        $task->update([
            'body' => request('body'),
            'completed_at' => request()->has('completed_at') ? Carbon::now() : null
        ]);

        return redirect($project->path());
    }
}
