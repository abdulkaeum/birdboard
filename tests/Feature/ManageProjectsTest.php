<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_guests_cannot_manage_projects()
    {
        // if we're not authenticated then we won't have a user to associate the project to
        // so this WILL fail which is what we are testing for
        // user_id will be set to null if we are not signed in
        // we've added middleware of auth onto the POST 'projects' route
        // if you're not authenticated then you shouldn't be here at that point

        //$this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $this->get('projects')->assertRedirect('login');
        $this->get('projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('projects', $project->toArray())->assertRedirect('login');
    }

    public function test_a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $this->get('projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->sentence(),
            'notes' => 'Notes here'
        ];

        $response = $this->post('projects', $attributes);

        $project = Project::where($attributes)->first();
        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    public function test_a_user_can_update_a_project()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        $this->patch($project->path(), [
            'notes' => 'Changed'
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', [
            'notes' => 'Changed'
        ]);
    }

    public function test_a_user_can_view_their_project()
    {
        $this->actingAs(User::factory()->create());

        $this->withoutExceptionHandling();

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        // assert that you can see a title and a description for any given project
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee(Str::limit($project->description, 100));
    }

    public function test_an_authenticated_user_cannot_view_projects_of_others()
    {
        $this->actingAs(User::factory()->create());

        //$this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);

    }

    public function test_a_project_requires_a_title()
    {
        // user must be signed in
        $this->actingAs(User::factory()->create());

        // create a project and override it's title to null
        $attributes = Project::factory()->raw(['title' => '']);

        // make sure that validation checks if title is set
        $this->post('projects', $attributes)->assertSessionHasErrors('title');
    }

    public function test_a_project_requires_a_description()
    {
        // user must be signed in
        $this->actingAs(User::factory()->create());

        // create a project and override it's description to null
        $attributes = Project::factory()->raw(['description' => '']);

        // make sure that validation checks if description is set
        $this->post('projects', $attributes)->assertSessionHasErrors('description');
    }
}
