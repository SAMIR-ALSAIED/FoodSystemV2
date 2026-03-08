<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCart extends Model
{


    
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'total',
        'status',
    ];
    
    public function items()
    
    {

        return $this->hasMany(      CustomerCartOr::class,  'customer_cart_id');

    
    }
}
