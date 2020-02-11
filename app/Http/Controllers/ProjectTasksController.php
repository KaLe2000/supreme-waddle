<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Carbon\Carbon;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('view', $project);

        request()->validate([
            'body' => 'required'
        ]);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Project $project, Task $task)
    {

        $this->authorize('view', $project);

        $task->update(request()->validate(['body' => 'sometimes|required']));

        request('completed_at') ? $task->complete() : $task->incomplete();

        return redirect($project->path());
    }
}