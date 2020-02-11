<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    /**
     * Task touch his project (updated_at).
     * */
    protected $touches = ['project'];

    /**
     * The path of the task/
     * @return string
     */
    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    /**
     * Set task to incomplete.
     */
    public function incomplete()
    {
        $this->update(['completed_at' => null]);
    }

    /**
     * Set task to complete.
     */
    public function complete()
    {
        $this->update(['completed_at' => Carbon::now()]);
    }

    /**
     * The project of the task.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
