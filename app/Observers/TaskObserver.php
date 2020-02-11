<?php

namespace App\Observers;

use App\Task;

class TaskObserver
{
    /**
     * Handle the task "created" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        $task->project->recordActivity('created_task', $task);
    }

    /**
     * Handle the task "updated" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        if (is_null($task->completed_at)) {
            $task->project->recordActivity('incomplete_task', $task);
            return;
        }
        $task->project->recordActivity('completed_task', $task);
    }

    public function deleted(Task $task)
    {
        $task->project->recordActivity('deleted_task', $task);
    }
}
