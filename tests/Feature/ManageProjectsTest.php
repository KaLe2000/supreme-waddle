<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_manage_the_projects()
    {
//        $this->withoutExceptionHandling();
        $project = factory('App\Project')->create();

        $this->get('/projects')->assertRedirect('/login');

        $this->get('/projects/create')->assertRedirect('/login');

        $this->get($project->path())->assertRedirect('/login');

        $this->post('/projects', $project->toArray())->assertRedirect('/login');
    }

    /**
     * @test
     * @return void
     */
    public function only_authenticated_users_can_manage_a_projects()
    {
//        $this->withoutExceptionHandling();
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $project = factory('App\Project')->raw(['user_id' => auth()->user()->id]);
        $this->post('/projects', $project);
        $this->assertDatabaseHas('projects', $project);

        $project = Project::where($project)->first();
        $this->get($project->path())
            ->assertSee($project['title'])
            ->assertSee($project['notes']);

        $this->patch($project->path(), [
            'notes' => 'Test general notes'
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', [
            'notes' => 'Test general notes'
        ]);
    }

    /** @test */
    public function a_project_requires_a_data()
    {
//        $this->withoutExceptionHandling();
        $this->signIn();
        $project = factory('App\Project')->raw([
            'title' => '',
            'description' => ''
            ]);

        $this->post('/projects', $project)->assertSessionHasErrors(['title', 'description']);
    }

    /** @test */
    public function authenticated_user_can_view_a_project()
    {
//        $this->withoutExceptionHandling();
        $this->signIn();
        $project = factory('App\Project')->create(['user_id' => auth()->user()->id]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->desciption);
    }

    /** @test */
    public function authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }
}
