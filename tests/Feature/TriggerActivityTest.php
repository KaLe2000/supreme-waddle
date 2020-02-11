<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity[0]->description);
    }

    /** @test */
    public function updating_a_project()
    {
        $project = ProjectFactory::create();
        $project->update(['title' => 'test title']);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity[1]->description);
    }

    /** @test */
    public function creating_a_task()
    {
        $project = ProjectFactory::create();

        $project->addTask('Test task');

        $this->assertCount(2, $project->activity);
        $this->assertEquals('created_task', $project->activity[1]->description);
    }

    /** @test */
    public function completing_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->be($project->user)->patch($project->tasks[0]->path(), [
            'body' => 'test body',
            'completed_at' => true
        ]);

        $this->assertCount(4, $project->activity);
        $this->assertEquals('completed_task', $project->activity->last()->description);
    }

    /*FIXME FIXME FIXME */
    /*
     * Проверка на инкомплит не работает
     * */
    /** @test */
    public function incompleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->be($project->user)->patch($project->tasks[0]->path(), [
            'body' => 'test body',
            'completed_at' => true
        ]);

        $this->assertCount(4, $project->activity);

        $this->patch($project->tasks[0]->path(), [
            'body' => 'test body 2',
//            'completed_at' => false
        ]);

//        dd($project->activity);

//        $this->assertCount(5, $project->fresh()->activity);
        $this->assertEquals('incomplete_task', $project->fresh()->activity->last()->description);
    }

    /** @test */
    public function deleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);
    }
}
