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
    public function index()
    {
        // العدادات لوحة التحكم
        $products_count = Product::count();
        $category_count = Category::count();
        $orders_count = Order::count();
        $users_count = User::count();


$latest_orders = Order::latest()->take(8)->get();



        // آخر 5 حجوزات

$latest_reservations = Reservation::orderBy('created_at', 'desc')->take(5)->get();


        // إيراد اليوم
        $today_income = Order::whereDate('created_at', Carbon::today())->sum('total');

        // المبيعات من أول الشهر لآخر يوم الشهر الحالي
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $dates = [];
        $sales = [];

        for ($date = $startOfMonth; $date->lte($endOfMonth); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');

            $dayIncome = Order::whereDate('created_at', $date)->sum('total'); // عمود total
            $sales[] = $dayIncome;
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
           'latest_orders'
        ));
    }
}
