<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->accessibleProjects();

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store()
    {
        $attributes = $this->validateRequests();

        $project = auth()->user()->projects()->create($attributes);

        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $attributes = $this->validateRequests();

        $project->update($attributes);

        return redirect($project->path());
    }

    public function destroy(Project $project)
    {
        $this->authorize('update', $project);

        $project->delete();

        return redirect('/projects');
    }

    protected function validateRequests()
    {
        return request()->validate([
            'title' => ['sometimes', 'required'],
            'description' => ['sometimes', 'required'],
            'notes' => ['nullable']
        ]);
    }
}
