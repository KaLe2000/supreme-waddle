<?php

namespace Tests\Feature;

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
        $this->be(factory('App\User')->create());

        $this->get('/projects/create')->assertStatus(200);

        $project = factory('App\Project')->raw(['user_id' => auth()->user()->id]);
        $this->post('/projects', $project);
        $this->assertDatabaseHas('projects', $project);
        $this->get('/projects')->assertSee($project['title']);
    }

    /** @test */
    public function a_project_requires_a_data()
    {
//        $this->withoutExceptionHandling();
        $this->be(factory('App\User')->create());
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
        $this->be(factory('App\User')->create());
        $project = factory('App\Project')->create(['user_id' => auth()->user()->id]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->desciption);
    }

    /** @test */
    public function authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->be(factory('App\User')->create());

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }
}
