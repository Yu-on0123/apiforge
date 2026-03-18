<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Courses;
use App\Models\Students;
use App\Models\Teachers;

class Departments extends Model
{
    protected $table = 'departments';

    protected $fillable = ['name', 'code', 'description'];

    public function courses()
    {
        return $this->hasMany(Courses::class, 'department_id');
    }

    public function students()
    {
        return $this->hasMany(Students::class, 'department_id');
    }

    public function teachers()
    {
        return $this->hasMany(Teachers::class, 'department_id');
    }
}
