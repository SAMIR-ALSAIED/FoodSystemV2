<?php

namespace App\Http\Controllers\Front;

use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Reservation\AddReservationRequest;
use App\Http\Requests\Front\StoreReservationRequest;

use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;


class ReservationController extends Controller
{

public function create()
{
      $tables = Table::where('status', 'متاحة')->get();

    return view('front.reservation', compact('tables'));
}


public function store(StoreReservationRequest $request)
{
    $data = $request->validated();

    // دمج التاريخ والوقت في عمود واحد (لو عمود واحد في DB)
    $data['datetime'] = $data['reservation_date'] . ' ' . $data['reservation_time'];

    // تحقق أن الطاولة غير محجوزة في نفس التاريخ والوقت
    $exists = Reservation::where('table_id', $data['table_id'])
        ->where('datetime', $data['datetime'])
        ->exists();

    if ($exists) {
        // نرسل الخطأ تحت حقل الطاولة
        return redirect()->back()
            ->withErrors(['table_id' => 'هذه الطاولة محجوزة في هذا الوقت'])
            ->withInput(); // تحفظ البيانات اللي دخلها المستخدم
    }

    // إنشاء الحجز
   $reservation = Reservation::create([
        'table_id' => $data['table_id'],
        'customer_name' => $data['customer_name'],
        'phone' => $data['customer_phone'], // الاسم مطابق للعمود في DB
        'guest_count' => $data['guest_count'] ?? 1,
        'datetime' => $data['datetime'],
        'status' => 'في الانتظار',
    ]);

    Mail::to('samiralsaied07@gmail.com')->send(new TestMail($reservation));


    return redirect()->back()->with('success', 'تم حجز الطاولة بنجاح!');
}






}
