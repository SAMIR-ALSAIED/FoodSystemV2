<?php

namespace App\Http\Controllers\Admin;

use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Reservation\AddReservationRequest;
use App\Http\Requests\Admin\Reservation\UpdateReservationRequest;

class ReservationController extends Controller
{
  public function index() {
    $reservations = Reservation::orderBy('created_at', 'desc')->get();

        return view('dashbord.reservations.index', compact('reservations'));
    }

    public function create() {
        $tables = Table::where('status', 'متاحة')->get();
        return view('dashbord.reservations.create', compact('tables'));
    }
public function store(AddReservationRequest $request) {
    $data = $request->validated();

    // تحقق أن الطاولة متاحة
    $table = Table::find($data['table_id']);
    if ($table->status !== 'متاحة') {
        return redirect()->back()->with('error', 'هذه الطاولة محجوزة بالفعل');
    }

    // إنشاء الحجز
    Reservation::create($data);

    // تحديث حالة الطاولة إلى محجوزة
    $table->update(['status' => 'محجوزة']);

    return redirect()->route('reservations.index')->with('success', 'تم إضافة الحجز بنجاح');
}


    public function edit(Reservation $reservation) {

        $tables = Table::where('status', 'متاحة')->orWhere('id', $reservation->table_id)->get();
        return view('dashbord.reservations.edit', compact('reservation', 'tables'));
    }

  public function update(UpdateReservationRequest $request, Reservation $reservation) {
    $data = $request->validated();

    // تحديث حالة الطاولة القديمة إلى متاحة
    $oldTable = Table::find($reservation->table_id);
    $oldTable->update(['status' => 'متاحة']);

    // تحديث حالة الطاولة الجديدة إلى محجوزة
    $newTable = Table::find($data['table_id']);
    if ($newTable->status !== 'متاحة') {
        return redirect()->back()->with('error', 'هذه الطاولة محجوزة بالفعل');
    }
    $newTable->update(['status' => 'محجوزة']);

    // تحديث الحجز
    $reservation->update($data);

    return redirect()->route('reservations.index')->with('success', 'تم تعديل الحجز بنجاح');
}


public function destroy(Reservation $reservation) {
    $table = Table::find($reservation->table_id);
    $table->update(['status' => 'متاحة']);

    $reservation->delete();

    return redirect()->route('reservations.index')->with('error', 'تم حذف الحجز بنجاح');
}

}
