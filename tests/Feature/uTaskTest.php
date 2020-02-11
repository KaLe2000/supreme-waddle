<?php

namespace Tests\Feature;

use App\Project;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class uTaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $task = factory('App\Task')->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }

    /** @test */
    public function it_has_a_path()
    {
        $task = factory('App\Task')->create();

        $this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }

    /** @test */
    public function it_can_be_completed()
    {
        $task = factory('App\Task')->create(['completed_at' => null]);

        $task->complete();

        $this->assertDatabaseHas('tasks', ['completed_at' => Carbon::now()]);
    }

    /** @test */
    public function it_can_be_incomplete()
    {
        $task = factory('App\Task')->create();

        $task->incomplete();

        $this->assertDatabaseHas('tasks', ['completed_at' => null]);
    }
}
