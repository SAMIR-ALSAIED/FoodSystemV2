<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerCart;


use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{


public function index()
{
    $orders = CustomerCart::orderBy('created_at','desc')->get();


    return view('dashbord.customer_orders.index', compact('orders'));
}


public function updateStatus(Request $request, $id)
    {
        $order = CustomerCart::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,completed',
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح!');
    }

    /**
     * حذف الطلب نهائياً
     */
    public function destroy($id)
    {
        $order = CustomerCart::findOrFail($id);
        
        $order->delete();

        return redirect()->back()->with('success', 'تم حذف الطلب ومحتوياته بنجاح!');
    }



}
