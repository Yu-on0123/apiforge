<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Enrollments;

class Grades extends Model
{
    protected $table = 'grades';

    protected $fillable = ['enrollment_id', 'grade', 'letter_grade', 'graded_at', 'comment'];

    public function enrollments()
    {
        return $this->belongsTo(Enrollments::class, 'enrollment_id');
    }
}
