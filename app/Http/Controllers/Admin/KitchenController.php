<?php

namespace App\Http\Controllers\Admin;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\kitchen\UpdateOrderStatusRequest;

class KitchenController extends Controller
{

    public function kitchen()
    {

            $orders = Order::where('status', 'pending')
                   ->orWhere('status', 'preparing')
                   ->orderBy('created_at', 'desc')
                   ->get();

        return view('dashbord.orders.kitchen', compact('orders'));
    }




public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
{

    $validData=$request->validated();





$order->update([
      'status' => $validData['status']
]);



    // لو الطلب بقى مكتمل → فضّي الطاولة
    // if ($validData['status'] === 'completed' && $order->table_id) {
    //     $order->table()->update([
    //         'status' => 'متاحة'
    //     ]);
    // }




    return response()->json([
        'success' => true,
        'status' => $order->status,
        'message' => 'تم تحديث حالة الطلب بنجاح'
    ]);


}
}
