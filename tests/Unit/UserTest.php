<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_has_projects()
    {
        $user = User::factory()->create();

        // a user can access their projects

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    public function test_a_user_has_accessible_projects()
    {
        $john = $this->signIn();
        $nick = User::factory()->create();
        $sally = User::factory()->create();

        $johnProject = app(ProjectFactory::class)->ownedBy($john)->create();
        $sallyProject = app(ProjectFactory::class)->ownedBy($sally)->create();

        $this->assertCount(1, $john->accessibleProjects());

        $sallyProject->invite($nick);

        $this->assertCount(1, $john->accessibleProjects());

        $sallyProject->invite($john);

        $this->assertCount(2, $john->accessibleProjects());
    }
}
