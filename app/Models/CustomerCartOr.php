<?php

namespace App\Models;

use App\Models\CustomerCart;
use Illuminate\Database\Eloquent\Model;

class CustomerCartOr extends Model
{
  protected $fillable = [
        'customer_cart_id',
        'product_name',
        'quantity',
        'price',
        'total',
    ];

    // علاقة العنصر بالطلب
    public function order()
    {
        return $this->belongsTo(CustomerCart::class, 'customer_cart_id');
    }
}
