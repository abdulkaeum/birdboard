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
            $task->project->recordActivity('created_task');
        });
    }

    public function completed()
    {
        $this->update([
            'completed' => true
        ]);

        $this->project->recordActivity('completed_task');
    }
}
