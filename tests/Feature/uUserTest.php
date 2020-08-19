<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class uUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_projects()
    {
        $user = factory('App\Models\User')->create();
        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    public function a_user_has_accessible_projects()
    {
        $john = $this->signIn();

        ProjectFactory::ownedBy($john)->create();

        $this->assertCount(1, $john->accessibleProjects());

        $harry = factory('App\Models\User')->create();
        $nick = factory('App\Models\User')->create();

        $harryProject = ProjectFactory::ownedBy($harry)->create();
        $harryProject->invite($nick);

        $this->assertCount(1, $john->accessibleProjects());

        $harryProject->invite($john);

        $this->assertCount(2, $john->accessibleProjects());
    }
}
