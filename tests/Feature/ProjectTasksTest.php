<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
//This is Laravel Facades trick, now we can call methods statically
use Facades\Tests\Setup\ProjectFactory; // Real path is Tests\Setup\ProjectFactory
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_add_tasks_to_projects()
    {
        $project = ProjectFactory::create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    /** @test */
    public function only_the_project_owner_may_add_tasks()
    {
        $this->signIn();
        $project = ProjectFactory::ownedBy(factory('App\User')->create())->create();
        $task = factory('App\Task')->raw(['project_id' => $project->id]);

        $this->post($project->path() . '/tasks', $task)
            ->assertStatus(403);
        $this->assertDatabaseMissing('tasks', $task);
    }

    /** @test */
    public function only_the_project_owner_may_update_a_tasks()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->be($project->user)
            ->patch($project->tasks[0]->path(), [
            'body' => 'changed test'
        ])
            ->assertRedirect($project->path());
        $this->assertDatabaseHas('tasks', [
            'body' => 'changed test'
        ]);
    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        $project = ProjectFactory::create();

        $task = ['body' => 'Test task'];
        $this->be($project->user)
            ->post($project->path() . '/tasks', $task);

        $this->assertDatabaseHas('tasks', $task);
        $this->get($project->path())
        ->assertSee($task['body']);
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $project = ProjectFactory::create();
        $task = $project->addTask('test task');

        $this->be($project->user)
            ->patch($task->path(), [
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
        $project = ProjectFactory::create();

        $task = factory('App\Task')->raw(['body' => '']);

        $this->be($project->user)
            ->post($project->path() . '/tasks', $task)
        ->assertSessionHasErrors('body');
    }
}
