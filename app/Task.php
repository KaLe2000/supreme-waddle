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
     * Record activity for a project.
     * @param $description
     * @return Model
     */
    public function recordActivity($description)
    {
        return $this->activity()->create([
            'project_id' => $this->project_id,
            'description' => $description
        ]);
    }

    /**
     * The activity feed for the project.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject')->latest();
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
