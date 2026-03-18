<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users;
use App\Models\Posts;

class Comments extends Model
{
    protected $table = 'comments';

    protected $fillable = ['content', 'user_id', 'post_id'];

    public function users()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function posts()
    {
        return $this->belongsTo(Posts::class, 'post_id');
    }
}
