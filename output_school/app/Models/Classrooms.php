<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Schedules;

class Classrooms extends Model
{
    protected $table = 'classrooms';

    protected $fillable = ['name', 'capacity', 'location', 'has_projector'];

    public function schedules()
    {
        return $this->hasMany(Schedules::class, 'classroom_id');
    }
}
