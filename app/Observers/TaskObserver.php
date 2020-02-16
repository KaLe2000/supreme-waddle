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
        $task->recordActivity('created_task', $task);
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
            $task->recordActivity('incomplete_task');
        } else {
            $task->recordActivity('completed_task');
        }
    }

    public function deleted(Task $task)
    {
        $task->recordActivity('deleted_task');
    }
}
