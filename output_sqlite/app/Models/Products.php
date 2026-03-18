<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Orders;

class Products extends Model
{
    protected $table = 'products';

    protected $fillable = ['name', 'price', 'stock'];

    public function orders()
    {
        return $this->hasMany(Orders::class, 'product_id');
    }
}
