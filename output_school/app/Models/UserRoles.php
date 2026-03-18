<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users;
use App\Models\Roles;

class UserRoles extends Model
{
    protected $table = 'user_roles';

    protected $fillable = ['user_id', 'role_id', 'assigned_at'];

    public function users()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function roles()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }
}
