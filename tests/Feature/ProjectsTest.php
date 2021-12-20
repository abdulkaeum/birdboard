<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_guests_cannot_create_projects()
    {
        // if we're not authenticated then we won't have a user to associate the project to
        // so this WILL fail which is what we are testing for
        // user_id will be set to null if we are not signed in
        // we've added middleware of auth onto the POST 'projects' route
        // if you're not authenticated then you shouldn't be here at that point

        //$this->withoutExceptionHandling();

        $attributes = Project::factory()->raw();

        $this->post('projects', $attributes)->assertRedirect('login');
    }

    public function test_a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $attributes = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph()
        ];

        $this->post('projects', $attributes)->assertRedirect('projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('projects')->assertSee($attributes['title']);
    }

    public function test_a_user_can_view_their_project()
    {
        $this->actingAs(User::factory()->create());

        $this->withoutExceptionHandling();

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        // assert that you can see a title and a description for any given project

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    public function test_an_authenticated_user_cannot_view_projects_of_others()
    {
        $this->actingAs(User::factory()->create());

        //$this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);

    }

    public function test_guests_cannot_view_projects()
    {
        $this->get('projects')->assertRedirect('login');
    }

    public function test_guests_cannot_view_a_single_project()
    {
        $project = Project::factory()->create();

        $this->get($project->path())->assertRedirect('login');
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
