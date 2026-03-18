<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comments;
use App\Models\Posts;

class Users extends Model
{
    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password'];

    public function comments()
    {
        return $this->hasMany(Comments::class, 'user_id');
    }

    public function posts()
    {
        return $this->hasMany(Posts::class, 'user_id');
    }
}
