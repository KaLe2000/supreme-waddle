<?php


namespace Tests\Setup;

/*
 * John Bonaccorsi tighten model factories
 * */
class ProjectFactory
{
    protected $tasksCount = 0;
    protected $user;

    public function ownedBy($user)
    {
        $this->user = $user;

        // fluent api
        return $this;
    }

    public function withTasks($count)
    {
        $this->tasksCount = $count;

        // fluent api
        return $this;
    }

    public function create()
    {
        $project = factory('App\Models\Project')->create([
            'user_id' => $this->user ?? factory('App\Models\User')
        ]);

        factory('App\Models\Task', $this->tasksCount)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }
}