<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CustomerCart;
use App\Models\CustomerCartOr;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // عرض السلة
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('front.cart', compact('cart'));
    }

    // إضافة منتج للسلة (الدالة التي سببت الخطأ)
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => $request->quantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'تمت الإضافة للسلة!');
    }

    // تحديث الكمية (AJAX)
    public function update(Request $request)
    {
        $cart = session()->get('cart');
        if($request->id && $request->quantity){
            $cart[$request->id]["quantity"] = max(1, $request->quantity);
            session()->put('cart', $cart);
            return response()->json(['status' => 'success']);
        }
    }

    // حذف منتج (AJAX)
    public function remove($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return response()->json(['status' => 'success']);
    }

    // إتمام الطلب (AJAX)
    public function checkout(Request $request)
    {
     
    $request->validate([
    'name'    => 'required',
    'phone'   => 'required|unique:customer_carts,phone',
    'email'   => 'required|email',
    'address' => 'required',
]);


        $cart = session()->get('cart', []);
        if(!$cart) return response()->json(['status' => 'error', 'message' => 'السلة فارغة!'], 400);

        // حساب الإجمالي
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        // 1. حفظ الطلب الرئيسي
        $order = CustomerCart::create($request->all() + ['total' => $total, 'status' => 'pending']);

        // 2. حفظ المنتجات المرتبطة بالطلب
        foreach($cart as $id => $item) {
            CustomerCartOr::create([
                'customer_cart_id' => $order->id,
                'product_name'     => $item['name'],
                'quantity'         => $item['quantity'],
                'price'            => $item['price'],
                'total'            => $item['price'] * $item['quantity'],
            ]);
        }

        // مسح السلة
        session()->forget('cart');

        return response()->json(['status' => 'success', 'message' => 'تم تسجيل طلبك بنجاح رقم: #' . $order->id]);
    }

    public function clear()
{
    session()->forget('cart');
    return redirect()->back()->with('success', 'تم مسح السلة');
}

}