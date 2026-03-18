<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users;
use App\Models\Categories;
use App\Models\Comments;

class Posts extends Model
{
    protected $table = 'posts';

    protected $fillable = ['title', 'content', 'user_id', 'category_id'];

    public function users()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comments::class, 'post_id');
    }
}
