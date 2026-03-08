<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Table;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Cashier\StoreCashierRequest;

class CashierController extends Controller
{


    //casier

    public function cashier()
{
    $tables = Table::where('status', 'متاحة')->get();
    $products = Product::all();
        $categories = Category::all();

        $nextOrderId = (Order::max('id') ?? 0) + 1;

    return view('dashbord.orders.cashier', compact('tables','products','categories','nextOrderId'));
}




public function storeCashier(StoreCashierRequest $request)
{

    $validated = $request->validated();


    $items = $validated['items'];

    // إنشاء الطلب
    $order = Order::create([
        'user_id'  => auth()->id(),
        'table_id' => $validated['table_id'] ?? null,
        'status'   => 'pending',
    ]);

    // إضافة المنتج وحساب الإجمالي
    $total = 0;
    foreach ($items as $item) {
        $order->items()->create([
            'product_id' => $item['product_id'],
            'quantity'   => $item['quantity'],
            'price'      => $item['price'],
        ]);

        $total += $item['price'] * $item['quantity'];
    }

    $order->update(['total' => $total]);

    // حجز الطاولة لو موجودة
    if (!empty($validated['table_id'])) {
      Table::where('id', $validated['table_id'])
            ->update(['status' => 'محجوزة']);
    }

    return redirect()->back()->with('success','تم إضافة الطلب للمطبخ!');
}




}
