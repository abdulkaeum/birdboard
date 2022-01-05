<?php

namespace App;

use App\Models\Activity;

trait RecordsActivity
{
    public $oldAttributes = [];

    /**
     * Boot the trait
     */
    public static function bootRecordsActivity()
    {
        // for Task or Porject model
        static::updating(function ($model) {
            $model->oldAttributes = $model->getOriginal();
        });

        // if $recordableEvents is on model us it
        if (isset(static::$recordableEvents)) {
            $recordableEvents = static::$recordableEvents;
        } else {
            // otherwise use our defaults
            $recordableEvents = ['created', 'updated', 'deleted'];
        }

        foreach ($recordableEvents as $event) {
            static::$event(function ($model) use ($event) {
                if (class_basename($model) !== 'Project') {
                    $event = "{$event}_" . strtolower(class_basename($model));
                }
                $model->recordActivity($event);
            });
        }
    }

    public function recordActivity($description)
    {
        // will also add:
        // creator_type = App\Models\Task
        // creator_id = 1

        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project->id
        ]);
    }

    public function activityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'before' => array_diff($this->oldAttributes, $this->getAttributes()),
                'after' => $this->getChanges()
            ];
        }
    }

    public function activity()
    {
        // gets both the class and foreign key i.e activity.creator_id, activity.creator_type
        return $this->morphMany(Activity::class, 'creator')->latest();
    }
}
