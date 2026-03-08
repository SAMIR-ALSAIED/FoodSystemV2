<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{


    use HasFactory;

    protected $fillable = [
        'customer_name',
        'phone',
        'guest_count',
        'table_id',
        'status',
        'datetime'
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }





public function getStatusBadgeAttribute()
{
    $map = [
        'في الانتظار' => ['text' => 'في الانتظار', 'badge' => 'bg-warning'],
        'تم الحجز'    => ['text' => 'تم الحجز', 'badge' => 'bg-success'],
        'اكتمل الطلب' => ['text' => 'اكتمل الطلب', 'badge' => 'bg-info'],
        'ملغي'        => ['text' => 'ملغي', 'badge' => 'bg-danger'],
    ];

    return $map[$this->status] ?? ['text' => 'غير معروف', 'badge' => 'bg-secondary'];
}

}
