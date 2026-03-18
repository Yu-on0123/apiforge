<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users;
use App\Models\Departments;
use App\Models\Enrollments;
use App\Models\Payments;
use App\Models\Submissions;

class Students extends Model
{
    protected $table = 'students';

    protected $fillable = ['user_id', 'student_code', 'department_id', 'enrollment_year', 'status'];

    public function users()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function departments()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollments::class, 'student_id');
    }

    public function payments()
    {
        return $this->hasMany(Payments::class, 'student_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submissions::class, 'student_id');
    }
}
