<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_add_tasks_to_projects()
    {
        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    /** @test */
    public function only_the_project_owner_may_add_tasks()
    {
        $this->signIn();

        $project = factory('App\Project')->create();
        $task = factory('App\Task')->raw(['project_id' => $project->id]);

        $this->post($project->path() . '/tasks', $task)
            ->assertStatus(403);
        $this->assertDatabaseMissing('tasks', $task);
    }

    /** @test */
    public function a_project_can_have_tasks()
    {
//        $this->withoutExceptionHandling();
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );
        $task = factory('App\Task')->raw(['project_id' => $project->id]);

//        dd(auth()->id(), $project->id, $task);

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
