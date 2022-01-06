<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_project_can_invite_a_user()
    {
        $project = app(ProjectFactory::class)->create();

        $project->invite($newUser = User::factory()->create());

        $this->signIn($newUser);

        $this->post($project->path() . '/tasks', $task = ['body' => 'Foo Task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
