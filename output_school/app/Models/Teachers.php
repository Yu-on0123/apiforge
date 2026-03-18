<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users;
use App\Models\Departments;
use App\Models\Announcements;
use App\Models\Courses;

class Teachers extends Model
{
    protected $table = 'teachers';

    protected $fillable = ['user_id', 'department_id', 'specialization', 'hire_date', 'salary'];

    public function users()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function departments()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }

    public function announcements()
    {
        return $this->hasMany(Announcements::class, 'teacher_id');
    }

    public function courses()
    {
        return $this->hasMany(Courses::class, 'teacher_id');
    }
}
