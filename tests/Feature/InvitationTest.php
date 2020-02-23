<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function non_owners_may_not_invite_users()
    {
        $project = ProjectFactory::create();

        $user = factory('App\User')->create();

        $this->be($user)
            ->post($project->path() . '/invitations')
            ->assertStatus(403);

        $project->invite($user);

        $this->be($user)
            ->post($project->path() . '/invitations')
            ->assertStatus(403);
    }
    
    /** @test */
    public function a_project_can_invite_a_user()
    {
        $project = ProjectFactory::create();

        $userToInvite = factory('App\User')->create();

        $this->be($project->user)->post($project->path() . '/invitations', [
            'email' => $userToInvite->email
        ])
        ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    /** @test */
    public function the_invited_email_address_must_be_a_valid()
    {
        $project = ProjectFactory::create();

        $this->be($project->user)->post($project->path() . '/invitations',[
            'email' => 'notregistereduser@user.ru'
        ])->assertSessionHasErrors(['email' => 'User is not exists!'], null, 'invitations');
    }

    /** @test */
    public function invited_users_may_update_project_details()
    {
        $project = ProjectFactory::create();

        $project->invite($newUser = factory('App\User')->create());

        $this->signIn($newUser);
        $this->post(route('tasks.store', $project), $task = ['body' => 'Test task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
