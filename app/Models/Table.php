<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{

    protected $fillable = [
        'number',
        'min_guests',
        'max_guests',
        'status',
    ];

        public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
