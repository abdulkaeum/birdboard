<?php

namespace App\Models;

use App\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class Task extends Model
{
    use HasFactory, RecordsActivity;

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
}
