<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_project()
    {
        $project = app(ProjectFactory::class)->create();

        $this->assertCount(1, $project->activity);

        $this->assertEquals('created', $project->activity[0]->description);
    }

    public function test_updating_a_project()
    {
        $project = app(ProjectFactory::class)->create();

        $project->update(['notes' => 'Changed']);

        $this->assertCount(2, $project->activity);

        $this->assertEquals('updated', $project->activity->last()->description);
    }

    public function test_creating_a_task()
    {
        $project = app(ProjectFactory::class)->create();

        $project->addTask('New Task');

        $this->assertCount(2, $project->activity);
        $this->assertEquals('created_task', $project->activity->last()->description);
    }

    public function test_completing_a_task()
    {
        $project = app(ProjectFactory::class)->withTasks(1)->create();

        $this->actingAs($project->user)
            ->patch($project->tasks[0]->path(), [
                'body' => 'foobar',
                'completed' => true
        ]);

        $this->assertCount(3, $project->activity);
        $this->assertEquals('completed_task', $project->activity->last()->description);
    }

    public function test_incompleting_a_task()
    {
        $project = app(ProjectFactory::class)->withTasks(1)->create();

        $this->actingAs($project->user)
            ->patch($project->tasks[0]->path(), [
                'body' => 'foobar',
                'completed' => true
            ]);

        $this->assertCount(3, $project->activity);

        $this->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => false
        ]);

        $project->refresh();

        $this->assertCount(4, $project->activity);

        $this->assertEquals('uncompleted_task', $project->activity->last()->description);
    }

    public function test_deleting_a_task()
    {
        $project = app(ProjectFactory::class)->withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);
    }
}
