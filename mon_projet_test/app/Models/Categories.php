<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Posts;

class Categories extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name', 'description'];

    public function posts()
    {
        return $this->hasMany(Posts::class, 'category_id');
    }
}
