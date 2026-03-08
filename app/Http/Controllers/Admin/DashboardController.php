<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{


public function index(Request $request)
{
    $year = $request->year ?? now()->year;
    $month = $request->month ?? null; // null معناه كل السنة لو ما تمش تحديد شهر

    // العدادات
    $products_count = Product::count();
    $category_count = Category::count();
    $orders_count = Order::count();
    $users_count = User::count();

    $latest_orders = Order::latest()->take(8)->get();
    $latest_reservations = Reservation::orderBy('created_at', 'desc')->take(5)->get();

    // إيراد اليوم
    $today_income = Order::whereDate('created_at', Carbon::today())->sum('total');

    // إجمالي المبيعات
    $total_sales_query = Order::query()->whereYear('created_at', $year);
    if ($month) {
        $total_sales_query->whereMonth('created_at', $month);
    }
    $total_sales = $total_sales_query->sum('total');

    // Chart مبيعات الشهر الحالي (أو حسب الشهر اللي اتحدد)
    $startDate = $month ? Carbon::create($year, $month, 1)->startOfMonth()
                         : Carbon::create($year)->startOfYear();
    $endDate = $month ? Carbon::create($year, $month, 1)->endOfMonth()
                       : Carbon::create($year)->endOfYear();

    $dates = [];
    $sales = [];

    for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
        $dates[] = $date->format('Y-m-d');
        $sales[] = Order::whereDate('created_at', $date)->sum('total');
    }

    $chart_labels = $dates;
    $chart_data = $sales;

    return view('dashbord.dashboard', compact(
        'products_count',
        'category_count',
        'orders_count',
        'users_count',
        'latest_reservations',
        'today_income',
        'chart_labels',
        'chart_data',
        'latest_orders',
        'year',
        'month',
        'total_sales'
    ));
}
}
