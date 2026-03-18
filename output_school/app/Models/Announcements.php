<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Courses;
use App\Models\Teachers;

class Announcements extends Model
{
    protected $table = 'announcements';

    protected $fillable = ['course_id', 'teacher_id', 'title', 'content', 'is_pinned'];

    public function courses()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function teachers()
    {
        return $this->belongsTo(Teachers::class, 'teacher_id');
    }
}
