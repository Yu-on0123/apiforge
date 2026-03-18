<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Courses;
use App\Models\Classrooms;

class Schedules extends Model
{
    protected $table = 'schedules';

    protected $fillable = ['course_id', 'classroom_id', 'day_of_week', 'start_time', 'end_time'];

    public function courses()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function classrooms()
    {
        return $this->belongsTo(Classrooms::class, 'classroom_id');
    }
}
