<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class Orders extends Model
{
    protected $table = 'orders';

    protected $fillable = ['product_id', 'quantity', 'total'];

    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
