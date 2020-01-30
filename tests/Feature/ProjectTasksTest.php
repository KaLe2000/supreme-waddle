<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_tasks()
    {
//        $this->withoutExceptionHandling();
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );
        $task = factory('App\Task')->raw(['project_id' => $project->id]);

//        dd($task);

        $this->post($project->path() . '/tasks', $task);

        $this->assertDatabaseHas('tasks', $task);
        $this->get($project->path())
        ->assertSee($task['body']);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );

        $task = factory('App\Task')->raw(['body' => '']);

//        dd($task);

        $this->post($project->path() . '/tasks', $task)
        ->assertSessionHasErrors('body');
    }
}
