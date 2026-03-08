<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\AddOrderRequest;

class OrderController extends Controller
{

    public function index()
    {



    $orders = Order::orderBy('created_at', 'desc')->get();


        return view('dashbord.orders.index', compact('orders'));
    }



public function show(Order $order)
{
    return view('dashbord.orders.show', compact('order'));
}

public function destroy(Order $order)
{
    // حذف العناصر المرتبطة بالطلب أولاً
    if ($order->items()->exists()) {
        $order->items()->delete();
    }

    // حذف الطلب نفسه
    $order->delete();

    return redirect()->back()->with('success', 'تم حذف الطلب وجميع عناصره بنجاح!');
}



}
