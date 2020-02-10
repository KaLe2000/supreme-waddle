<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
//This is Laravel Facades trick, now we can call methods statically
use Facades\Tests\Setup\ProjectFactory; // Real path is Tests\Setup\ProjectFactory
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_manage_the_projects()
    {
        $project = factory('App\Project')->create();

        $this->get('/projects')->assertRedirect('/login');
        $this->get('/projects/create')->assertRedirect('/login');
        $this->get($project->path())->assertRedirect('/login');
        $this->get($project->path() . '/edit')->assertRedirect('/login');
        $this->post('/projects', $project->toArray())->assertRedirect('/login');
    }

    /**
     * @test
     * @return void
     */
    public function only_authenticated_users_can_manage_a_projects()
    {
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $project = factory('App\Project')->raw(['user_id' => auth()->user()->id]);
        $this->post('/projects', $project);
        $this->assertDatabaseHas('projects', $project);

        $project = Project::where($project)->first();

        $this->get($project->path() . '/edit')->assertStatus(200);

        $this->get($project->path())
            ->assertSee($project['title'])
            ->assertSee($project['notes']);

        $this->patch($project->path(), [
            'title' => 'Test',
            'description' => 'Test',
            'notes' => 'Test general notes'
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', [
            'title' => 'Test',
            'description' => 'Test',
            'notes' => 'Test general notes'
        ]);

        $this->patch($project->path(), [
            'notes' => 'Another Test general notes'
        ])->assertRedirect($project->path());


        $this->assertDatabaseHas('projects', [
            'notes' => 'Another Test general notes'
        ]);
    }

    /** @test */
    public function a_project_requires_a_data()
    {
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
        $project = ProjectFactory::create();

        $this->be($project->user)
            ->get($project->path())
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
