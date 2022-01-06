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

    public function test_non_owners_may_not_invite_users()
    {
        $project = app(ProjectFactory::class)->create();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post($project->path() . '/invitations')
            ->assertStatus(403);
    }

    public function test_a_project_owner_can_invite_a_user()
    {
        $this->withoutExceptionHandling();

        $project = app(ProjectFactory::class)->create();

        $userToInvite = User::factory()->create();

        $this->actingAs($project->user)
            ->post($project->path() . '/invitations', [
                'email' => $userToInvite->email
            ])
            ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    public function test_the_email_must_already_be_registered()
    {
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->user)
            ->post($project->path() . '/invitations', [
                'email' => 'notuser@example.com'
            ])
            ->assertSessionHasErrors([
                'email' => 'The email is not registered with us'
            ]);
    }

    public function test_a_member_may_update_a_project_they_are_invited_to()
    {
        $project = app(ProjectFactory::class)->create();

        $project->invite($newUser = User::factory()->create());

        $this->signIn($newUser);

        $this->post($project->path() . '/tasks', $task = ['body' => 'Foo Task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
