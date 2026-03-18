<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Departments;
use App\Models\Teachers;
use App\Models\Announcements;
use App\Models\Assignments;
use App\Models\Enrollments;
use App\Models\Schedules;

class Courses extends Model
{
    protected $table = 'courses';

    protected $fillable = ['title', 'code', 'description', 'credits', 'department_id', 'teacher_id', 'max_students', 'is_active'];

    public function departments()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }

    public function teachers()
    {
        return $this->belongsTo(Teachers::class, 'teacher_id');
    }

    public function announcements()
    {
        return $this->hasMany(Announcements::class, 'course_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignments::class, 'course_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollments::class, 'course_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedules::class, 'course_id');
    }
}
