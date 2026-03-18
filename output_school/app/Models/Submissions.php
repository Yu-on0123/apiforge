<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Assignments;
use App\Models\Students;

class Submissions extends Model
{
    protected $table = 'submissions';

    protected $fillable = ['assignment_id', 'student_id', 'content', 'score', 'submitted_at', 'is_late'];

    public function assignments()
    {
        return $this->belongsTo(Assignments::class, 'assignment_id');
    }

    public function students()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }
}
