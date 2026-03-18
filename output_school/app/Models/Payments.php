<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Students;

class Payments extends Model
{
    protected $table = 'payments';

    protected $fillable = ['student_id', 'amount', 'payment_date', 'method', 'status', 'reference'];

    public function students()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }
}
