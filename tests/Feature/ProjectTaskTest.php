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
