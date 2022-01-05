<?php

namespace App;

use App\Models\Activity;

trait RecordsActivity
{
    public $oldAttributes = [];

    /**
     * Boot the trait for Task or Project model
     */
    public static function bootRecordsActivity()
    {
        foreach (self::recordableEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($model->activityDescription($event));
            });

            if($event === 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    protected function activityDescription ($description){
        if (class_basename($this) !== 'Project') {
            return "{$description}_" . strtolower(class_basename($this)); // e.g created_task
        }

        return $description; //e.g created
    }

    /**
     * if $recordableEvents is on model use it
     * otherwise use our defaults
     */
    protected static function recordableEvents()
    {
        return static::$recordableEvents ?? ['created', 'updated', 'deleted'];
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
