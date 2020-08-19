<?php

namespace App\Models;

use App\Models\Project;
use App\Models\Traits\RecordsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    /**
     * Task touch his project (updated_at).
     * */
    protected $touches = ['project'];

    /**
     * Uses in RecordActivity Trait
     * */
    protected static $recordableEvents = ['created', 'deleted'];

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

        $this->recordActivity('incomplete_task');
    }

    /**
     * Set task to complete.
     */
    public function complete()
    {
        $this->update(['completed_at' => Carbon::now()]);

        $this->recordActivity('completed_task');
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
