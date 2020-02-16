<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

trait RecordsActivity
{
    /**
     * The model's old attributes.
    */
    public $oldAttributes = [];

    /**
     * Boot the trait (27 - 9:00)
     */
    public static function bootRecordsActivity()
    {
        //Refactor an observers
        foreach (self::recordableEvents() as $event) {
            static::$event(function($model) use ($event) {
                $model->recordActivity($model->activityDescription($event));
            });

            if ($event === 'updated') {
                static::updating(function($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    /**
     * Uses for models /// Project $project->activityDescription('created_project');
     *
     * @param $desctiption
     * @return string
     */
    protected function activityDescription($desctiption)
    {
        return "{$desctiption}_" . strtolower(class_basename($this)); // created_tasks
    }

    /**
     * Which events we are listening to a current model
     * Use events from model's $recordableEvents or set default
     *
     * @return array
     */
    public static function recordableEvents()
    {
        if (isset(static::$recordableEvents)) {
            return $recordableEvents = static::$recordableEvents;
        }

        return ['created', 'updated', 'deleted'];
    }

    /**
     * Record activity for a model.
     * @param $description
     * @return Model
     */
    public function recordActivity($description)
    {
        return $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id
        ]);
    }

    /**
     * The activity feed for the project.
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject')->latest();
    }

    /**
     * Check if records have changed
     * Which rows are changed except updated_at
     *
     * FIXME method must return same type (only array)
     * @return array|null
     */
    public function activityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'before' => Arr::except(array_diff($this->oldAttributes,$this->getAttributes()), ['updated_at']),
                'after' => Arr::except($this->getChanges(), ['updated_at'])
            ];
        }
        return null;
    }
}