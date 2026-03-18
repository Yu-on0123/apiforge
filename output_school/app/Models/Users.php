<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Students;
use App\Models\Teachers;
use App\Models\UserRoles;

class Users extends Model
{
    protected $table = 'users';

    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'phone', 'is_active'];

    public function students()
    {
        return $this->hasMany(Students::class, 'user_id');
    }

    public function teachers()
    {
        return $this->hasMany(Teachers::class, 'user_id');
    }

    public function userRoles()
    {
        return $this->hasMany(UserRoles::class, 'user_id');
    }
}
