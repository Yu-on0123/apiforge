<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Courses;
use App\Models\Submissions;

class Assignments extends Model
{
    protected $table = 'assignments';

    protected $fillable = ['course_id', 'title', 'description', 'due_date', 'max_score'];

    public function courses()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submissions::class, 'assignment_id');
    }
}
