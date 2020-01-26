<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     * @return void
     */
    public function a_user_can_create_a_project()
    {
//        $this->withoutExceptionHandling();
        $this->be(factory('App\User')->create());

        $project = factory('App\Project')->raw(['user_id' => auth()->user()->id]);
        $this->post('/projects', $project);
        $this->assertDatabaseHas('projects', $project);
        $this->get('/projects')->assertSee($project['title']);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
//        $this->withoutExceptionHandling();
        $this->be(factory('App\User')->create());
        $project = factory('App\Project')->raw(['title' => '']);

        $this->post('/projects', $project)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
//        $this->withoutExceptionHandling();
        $this->be(factory('App\User')->create());
        $project = factory('App\Project')->raw(['description' => '']);

        $this->post('/projects', $project)->assertSessionHasErrors('description');
    }
    /** @test */
    public function a_project_requires_an_owner()
    {
//        $this->withoutExceptionHandling();
//        $this->be(factory('App\User')->create());
        $project = factory('App\Project')->raw();

        $this->post('/projects', $project)->assertRedirect('/login');
    }


    /** @test */
    public function a_user_can_view_a_project()
    {
//        $this->withoutExceptionHandling();
        $this->be(factory('App\User')->create());
        $project = factory('App\Project')->create(['user_id' => auth()->user()->id]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->desciption);
    }
}
