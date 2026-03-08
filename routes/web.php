<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CustomerOrderController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ReservationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [HomeController::class, 'index'])->name('front.home');

Route::get('/category/{id}', [HomeController::class, 'filter'])
    ->name('front.home.filter');

// Menu ()
Route::get('/menu', [HomeController::class, 'menu'])
    ->name('front.menu');


Route::get('/menu/category/{categoryId}', [HomeController::class, 'menu'])
    ->name('front.menu.filter');
    

//reservation



    Route::get('/reservation', [ReservationController::class, 'create'])
    ->name('front.reservation.create');


Route::post('/reservation', [ReservationController::class, 'store'])
    ->name('front.reservation.store');


// cart

Route::get('/cart', [CartController::class, 'index'])->name('front.cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('front.cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('front.cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('front.cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('front.cart.clear');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('front.cart.checkout');


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
