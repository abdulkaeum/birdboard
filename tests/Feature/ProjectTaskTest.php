<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_add_tasks_to_project()
    {
        //$this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    public function test_only_the_owner_of_a_project_may_add_tasks()
    {
        // sign is as a user
        $this->actingAs(User::factory()->create());

        // create a project that does not belong to the auth user
        $project = Project::factory()->create();

        // try to add a task to the $project that does not belong to the actingAs user
        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
        ->assertStatus(403);

        // double check in db
        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    public function test_only_the_owner_of_a_project_may_update_a_tasks()
    {
        // sign is as a user
        $this->actingAs(User::factory()->create());

        // create a project and task that does not belong to the auth user
        $project = Project::factory()->create();
        $task = $project->addTask('test task');

        // try to update a task to the $project that does not belong to the actingAs user
        // we want a 403 forbidden
        // if we get anuthing other than 403 then anyone can update a task
        $this->patch($project->path() . '/tasks/' . $task->id, ['body' => 'update it'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'update it']);
    }

    public function test_a_project_can_have_tasks()
    {
        //$this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        // hit end point and add task to current project
        $this->post($project->path() . '/tasks', ['body' => 'Test task']);

        //  check to see if the project page contains 'Test task'
        $this->get($project->path())->assertSee('Test task');
    }

    public function test_a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(User::factory()->create());

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        $task = $project->addTask('test task');

        $this->patch($project->path(). '/tasks/' . $task->id, [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    public function test_a_task_requires_a_body()
    {
        // user must be signed in
        $this->actingAs(User::factory()->create());

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        // create a project and override it's description to null
        $attributes = Task::factory()->raw(['body' => '']);

        // make sure that validation checks if description is set
        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
