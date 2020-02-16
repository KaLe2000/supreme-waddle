<?php

namespace Tests\Feature;

use App\Task;
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

        tap($project->activity->last(), function($activity) {
            $this->assertEquals('created', $activity->description);
            $this->assertNull($activity->changes);
        });
    }

    /** @test */
    public function updating_a_project()
    {
        $project = ProjectFactory::create();
        $originalTitle = $project->title;
        $project->update(['title' => 'test title']);

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function($activity) use ($originalTitle) {
            $this->assertEquals('updated', $activity->description);

            $expected = [
              'before' => ['title' => $originalTitle],
              'after' => ['title' => 'test title']
            ];

            $this->assertEquals($expected, $activity->changes);
        });
    }

    /** @test */
    public function creating_a_task()
    {
        $project = ProjectFactory::create();

        $project->addTask('Test task');

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('Test task', $activity->subject->body);
        });
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

        tap($project->activity->last(), function($activity) {
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }

    /*FIXME FIXME FIXME */
    /*
     * Проверка на инкомплит не работает
     * */
    /** @test */
    public function incompleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->be($project->user)->patch($project->tasks->last()->path(), [
            'body' => 'test body',
            'completed_at' => false
        ]);

        $this->assertCount(4, $project->activity);

        $this->be($project->user)->patch($project->tasks->last()->path(), [
            'body' => 'test body 2'
        ]);

//        $this->assertCount(5, $project->fresh()->activity);

        tap($project->fresh()->activity->last(), function($activity) {
            $this->assertEquals('incomplete_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }

    /** @test */
    public function deleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks->last()->delete();

        $this->assertCount(3, $project->activity);
    }
}
