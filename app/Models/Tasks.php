<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tasks extends Model
{
    use HasFactory,SoftDeletes;

    public function status()
    {
        return $this->belongsTo('App\Models\Status');
    }

    public function users()
    {
        return $this->hasOne('App\Models\UserTasks','task_id');
    }
}
