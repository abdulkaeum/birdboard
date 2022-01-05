<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'description', 'changes'];

    protected $casts = [
        'changes' => 'array'
    ];

    // a relationship to get the thing / model why the activity was created
    public function creator()
    {
        // polymorphic relation - gets both the class and foreign key
        // then using these 2 it will then retrieve the model
        return $this->morphTo();
    }
}
