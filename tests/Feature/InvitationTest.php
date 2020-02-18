<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_invite_a_user()
    {
        $project = ProjectFactory::create();

        $project->invite($newUser = factory('App\User')->create());

        $this->signIn($newUser);
        $this->post(route('tasks.store', $project), $task = ['body' => 'Test task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
