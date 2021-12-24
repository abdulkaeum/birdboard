<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_a_path()
    {
        $project = Project::factory()->create();

        $this->assertEquals('projects/' . $project->id, $project->path());
    }

    public function test_a_project_belongs_to_an_owner()
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(User::class, $project->user);
    }

    public function test_it_can_add_a_task()
    {
        $project = Project::factory()->create();

        // add a task to a project
        $task = $project->addTask('Test task');

        // we should have at least 1 task associated to the given project
        $this->assertCount(1, $project->tasks);

        // now check to see if the created tasks exists for the given project
        $this->assertTrue($project->tasks->contains($task));
    }
}
