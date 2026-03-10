<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/customer/about', function () {
    return view('customer.about');
});

Route::get('/customer/help', function () {
    return view('customer.help');
});

Route::get('/admin/invoice/{id}', [OrderController::class, 'invoice']);


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::prefix('customer')->group(function () {

    Route::view('/login', 'login');
    Route::view('/register', 'register');
    Route::get('/forgot-password', [AuthController::class, 'index'])->name('customer.forgot.password');
    Route::post('/forgot-password', [AuthController::class, 'sendOtp']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    Route::get('/chat/{user}', [ChatController::class, 'show'])
        ->name('chat.show');
});

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/logout', [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| CUSTOMER AREA
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('customer')->group(function () {

    /*
    | Checkout
    */
    Route::get('/checkout', [CheckoutController::class, 'index']);
    Route::post('/checkout', [CheckoutController::class, 'store']);

    /*
    | Invoice
    */
    Route::post('/order/pay/{id}', [OrderController::class, 'pay']);
    Route::post('/order/done/{id}', [OrderController::class, 'done']);

    /*
    | Transactions
    */
    Route::get('/transactions', [OrderController::class, 'buyerHistory']);

    /*
    | Cart
    */
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove']);
});

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| CHATTING
|--------------------------------------------------------------------------
*/
Route::get('/chat/{user}', [ChatController::class, 'showAdmin'])
    ->name('admin.chat.show');

Route::post('/messages', [ChatController::class, 'send'])
    ->name('messages.send');
