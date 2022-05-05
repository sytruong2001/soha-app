<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Auth\RegisteredAdminController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\NewPasswordController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/get-info', [UserController::class, 'getInfoUser'])->name('user.getInfoUser');
    Route::post('/update_info', [UserController::class, 'updateInfoUser'])->name('user.updateInfoUser');
    Route::get('/reset-password', [NewPasswordController::class, 'create'])->name('user.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('user.updatePass');
    Route::get('/payment', [UserController::class, 'payment'])->name('user.payment');
    Route::get('/get-info-payment', [UserController::class, 'getInfoPayment'])->name('user.getInfoPayment');
    Route::post('/update-payment', [UserController::class, 'UpdatePayment'])->name('user.updatePayment');
    Route::post('/update-kc', [UserController::class, 'UpdateKC'])->name('user.updateKC');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('/new-register-user', [ChartController::class, 'showNRU']);
    // Route::post('/new-register-user', [ChartController::class, 'showNRU']);
    Route::get('/new-register-user/update', [ChartController::class, 'updateNRU']);
    Route::get('/daily-active-user', [ChartController::class, 'showDAU']);
    Route::get('/revenue', [ChartController::class, 'showREV']);
    Route::get('/revenue/update', [ChartController::class, 'update']);
    Route::resource('/account', AccountController::class);
    Route::post('/account/register_admin', [RegisteredAdminController::class, 'store']);
});



// Route::middleware(['auth', 'role:user'])->prefix('user')->group(function() {

// });
require __DIR__ . '/auth.php';