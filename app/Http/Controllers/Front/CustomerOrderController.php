<!-- 

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CustomerCart;
use App\Models\CustomerCartOr;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    // عرض نموذج Checkout
    public function form()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'السلة فارغة!');
        }

        return view('front.checkout.form', compact('cart'));
    }

    // معالجة الـ Checkout وحفظ الطلب
    public function process(Request $request)
    {
        // التحقق من البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'السلة فارغة!');
        }

        // إنشاء الطلب الرئيسي
        $order = CustomerCart::create([
            'name'    => $request->name,
            'phone'   => $request->phone,
            'email'   => $request->email,
            'address' => $request->address,
            'status'  => 'pending',
            'total'   => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
        ]);

        // حفظ كل منتج مرتبط بالطلب
      


foreach($cart as $productId => $item) {
    CustomerCartOr::create([
        'customer_cart_id' => $order->id, // تأكد أن الاسم هنا customer_cart_id وليس order_id
        'product_name'     => $item['name'],
        'quantity'         => $item['quantity'],
        'price'            => $item['price'],
        'total'            => $item['price'] * $item['quantity'],
    ]);
}





        // مسح السلة بعد حفظ الطلب
        session()->forget('cart');

        return redirect()->route('front.home')->with('success', 'تم تسجيل طلبك بنجاح!');
    }

    // عرض كل الطلبات (اختياري للعميل أو Admin)
    public function index()
    {
        $orders = CustomerCart::orderBy('created_at', 'desc')->with('items')->get();
        return view('dashbord.customer_orders.index', compact('orders'));
    }

    // عرض تفاصيل طلب واحد
    public function show($id)
    {
        $order = CustomerCart::with('items')->findOrFail($id);
        return view('dashbord.customer_orders.show', compact('order'));
    }
} --> 
