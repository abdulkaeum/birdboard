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

    protected static function boot()
    {
        parent::boot();

        static::created(function ($task){
            Activity::create([
                'project_id' => $task->project->id,
                'description' => 'created_task'
            ]);
        });

        static::updated(function ($task){
            if(! $task->completed) return;

            Activity::create([
                'project_id' => $task->project->id,
                'description' => 'completed_task'
            ]);
        });
    }


}
