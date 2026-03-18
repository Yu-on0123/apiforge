<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserRoles;

class Roles extends Model
{
    protected $table = 'roles';

    protected $fillable = ['name', 'description'];

    public function userRoles()
    {
        return $this->hasMany(UserRoles::class, 'role_id');
    }
}
