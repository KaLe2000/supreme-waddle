<?php

namespace Tests\Feature;

use App\Models\Project;
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
        $project = factory('App\Models\Project')->create();

        $this->get('/projects')->assertRedirect('/login');
        $this->get('/projects/create')->assertRedirect('/login');
        $this->get($project->path())->assertRedirect('/login');
        $this->get($project->path() . '/edit')->assertRedirect('/login');
        $this->post('/projects', $project->toArray())->assertRedirect('/login');
        $this->delete($project->path())->assertRedirect('/login');
    }

    /** @test */
    public function unauthorized_users_cannot_delete_project()
    {
        $project = ProjectFactory::create();

        $this->delete($project->path())
            ->assertRedirect('/login');

        $user = $this->signIn();

        $this->delete($project->path())->assertStatus(403);

        $project->invite($user);

        $this->be($user)
            ->delete($project->path())
            ->assertStatus(403);
    }

    /**
     * @test
     * @return void
     */
    public function only_authenticated_users_can_manage_a_projects()
    {
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $project = factory('App\Models\Project')->raw(['user_id' => auth()->user()->id]);
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

        $this->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /** @test */
    public function a_user_can_see_all_projects_they_have_been_invited_to()
    {
        $user = $this->signIn();

        $project = tap(ProjectFactory::create())->invite($user);

        $this->get(route('projects.index'))->assertSee($project->title);
    }

    /** @test */
    public function a_project_requires_a_data()
    {
        $this->signIn();
        $project = factory('App\Models\Project')->raw([
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

        $project = factory('App\Models\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }
}
