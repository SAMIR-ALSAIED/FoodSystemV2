<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CustomerCart;
use App\Models\CustomerCartOr;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // عرض  السلة
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('front.cart', compact('cart'));
    }

<<<<<<< HEAD
=======
    // إضافة منتج للسلة
>>>>>>> e0081a4 (update: improve cart, reservation, roles and UI)
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);
        $qty = max(1, intval($request->quantity ?? 1));

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $qty;
        } else {
            $cart[$product->id] = [
                "id"       => $product->id,
                "name"     => $product->name,
                "quantity" => $qty,
                "price"    => $product->price,
                "image"    => $product->image
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'message' => 'تمت الإضافة للسلة!',
            'cart_count' => count($cart)
        ]);
    }

    // تحديث الكمية 
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$request->id])) {
            $cart[$request->id]["quantity"] = max(1, intval($request->quantity));
            session()->put('cart', $cart);
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error'], 404);
    }

    // حذف منتج واحد
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return response()->json(['status' => 'success']);
    }

    // إتمام الطلب 
    public function checkout(Request $request)
    {
        $request->validate([
            'name'    => 'required|min:3',
            'phone'   => ['required', 'regex:/^(010|011|012|015)[0-9]{8}$|^(040)[0-9]{7}$/'],
            'address' => 'required|min:10',
        ], [
            'name.required'    => 'اسمك مهم جداً لتسليم الطلب.',
            'phone.required'   => 'رقم الهاتف مطلوب للتواصل معك.',
            'phone.regex'      => 'رقم الهاتف يجب أن يكون (موبايل) أو (أرضي الغربية 040).',
            'address.required' => 'أين نسلم الطلب؟ يرجى كتابة العنوان.',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['status' => 'error', 'message' => 'سلتك فارغة حالياً!'], 400);
        }

        // 2. حساب الإجمالي الكلي
        $grandTotal = collect($cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });

        // 3. تخزين الطلب في قاعدة البيانات
        $order = CustomerCart::create($request->only('name', 'phone', 'address') + [
            'total'  => $grandTotal,
            'status' => 'pending'
        ]);

        // 4. تخزين  المنتجات 
        $orderDetails = [];
        foreach ($cart as $id => $item) {
            $orderDetails[] = [
                'customer_cart_id' => $order->id,
                'product_name'     => $item['name'],
                'quantity'         => $item['quantity'],
                'price'            => $item['price'],
                'total'            => $item['price'] * $item['quantity'],
                'created_at'       => now(),
                'updated_at'       => now(),
            ];
        }
        CustomerCartOr::insert($orderDetails);

        // 5. تفريغ السلة
        session()->forget('cart');

        return response()->json([
            'status'  => 'success',
            'message' => 'تم استلام طلبك بنجاح رقم: #' . $order->id
        ]);
    }

    // مسح السلة بالكامل
    public function clear()
<<<<<<< HEAD
{
    session()->forget('cart');
    return redirect()->back()->with('success', 'تم مسح السلة');
}

}
=======
    {
        session()->forget('cart');
        return response()->json(['status' => 'success']);
    }
}
>>>>>>> e0081a4 (update: improve cart, reservation, roles and UI)
