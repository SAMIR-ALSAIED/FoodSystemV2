<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    public function category(){

        return $this->belongsTo(Category::class);

    }


    protected $fillable = ['name','image','price','category_id'];


      public function orderItems()
    {
        return $this->hasMany(OrderItem::class); 
    }
}
