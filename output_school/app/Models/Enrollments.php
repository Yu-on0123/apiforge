<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Students;
use App\Models\Courses;
use App\Models\Grades;

class Enrollments extends Model
{
    protected $table = 'enrollments';

    protected $fillable = ['student_id', 'course_id', 'enrolled_at', 'status'];

    public function students()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }

    public function courses()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function grades()
    {
        return $this->hasMany(Grades::class, 'enrollment_id');
    }
}
