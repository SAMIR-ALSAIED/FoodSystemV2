<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class ReservationController extends Controller
{
    // 1. عرض صفحة الحجز
    public function create()
    {
        return view('front.reservation');
    }
public function store(Request $request)
{
    // 1. التحقق مع رسائل خطأ مخصصة بالعربي
    $request->validate([
        'customer_name'    => 'required',
        'customer_phone'   => 'required',
        'reservation_date' => 'required',
        'reservation_time' => 'required',
        'guest_count'      => 'required|numeric',
    ], [
        // هنا نكتب الترجمة لكل حقل
        'customer_name.required'    => 'يرجى كتابة اسمك.',
        'customer_phone.required'   => 'يرجى كتابة رقم الهاتف.',
        'reservation_date.required' => 'يرجى تحديد تاريخ الحجز.',
        'reservation_time.required' => 'يرجى تحديد وقت الحجز.',
        'guest_count.required'      => 'يرجى تحديد عدد الأفراد.',
        'guest_count.numeric'       => 'عدد الأفراد يجب أن يكون رقماً.',
    ]);

    // باقي الكود كما هو...
    $fullTime = $request->reservation_date . ' ' . $request->reservation_time;
    $people = $request->guest_count;

    $allTables = Table::where('status', 'متاحة')
                      ->where('min_guests', '<=', $people)
                      ->where('max_guests', '>=', $people)
                      ->get();

    $foundTable = null;
    foreach ($allTables as $table) {
        $isBooked = Reservation::where('table_id', $table->id)
                               ->where('datetime', $fullTime)
                               ->exists();

        if ($isBooked == false) {
            $foundTable = $table; 
            break; 
        }
    }

    // رسالة الخطأ في حال عدم وجود طاولة
    if ($foundTable == null) {
        return back()->with('error', 'نعتذر، لا توجد طاولة متاحة في هذا الموعد.');
    }

    $res = new Reservation();
    $res->table_id      = $foundTable->id;
    $res->customer_name = $request->customer_name;
    $res->phone         = $request->customer_phone;
    $res->guest_count   = $people;
    $res->datetime      = $fullTime;
    $res->status        = 'في الانتظار';
    $res->save();

    Mail::to('samiralsaied07@gmail.com')->send(new TestMail($res));

    return back()->with('success', 'تم الحجز بنجاح! رقم الطاولة: ' . $foundTable->id);
}

}