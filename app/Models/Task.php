<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'completed'];

    protected $casts = [
        'completed' => 'boolean',
    ];

    protected $touches = [
        'project'
    ];

    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function complete()
    {
        $this->update([
            'completed' => true
        ]);

        $this->recordActivity('completed_task');
    }

    public function incomplete()
    {
        $this->update([
            'completed' => false
        ]);

        $this->recordActivity('uncompleted_task');
    }

    public function activity()
    {
        // gets both the class and foreign key i.e activity.subject_id, activity.subject_type
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    public function recordActivity($description)
    {
        // will also add
        // subject_type = App\Models\Task
        // subject_id = 1
        $this->activity()->create([
            'project_id' => $this->project->id,
            'description' => $description
        ]);
    }
}
