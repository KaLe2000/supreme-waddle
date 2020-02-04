<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    public function only_the_project_owner_may_update_a_tasks()
    {
//        $this->withoutExceptionHandling();
        $this->signIn();

        $project = factory('App\Project')->create();
        $task = $project->addTask('test task');

        $this->patch($task->path(), [
            'body' => 'changed test'
        ])
            ->assertStatus(403);
        $this->assertDatabaseMissing('tasks', [
            'body' => 'changed test'
        ]);
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
    public function a_task_can_be_updated()
    {

//        $this->withoutExceptionHandling();
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );

        $task = $project->addTask('test task');

        $this->patch($task->path(), [
            'body' => 'test change',
            'completed_at' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'test change',
            'completed_at' => Carbon::now()
        ]);
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
