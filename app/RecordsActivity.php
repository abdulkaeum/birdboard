<?php

namespace App;

use App\Models\Activity;

trait RecordsActivity
{
    /**
     * The project's old attributes
     *
     * @var array
     */
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

            if ($event === 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    protected function activityDescription($description): string
    {
        return "{$description}_" . strtolower(class_basename($this)); // e.g created_task
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     * gets both the class and foreign key i.e activity.creator_id, activity.creator_type
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'creator')->latest();
    }
}
