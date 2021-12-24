<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsTasksController extends Controller
{
    public function store(Project $project)
    {
        request()->validate([
            'body' => ['required']
        ]);

        $project->addTask(request('body'));

        return redirect($project->path());
    }
}
