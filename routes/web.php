<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
<<<<<<< HEAD
use App\Http\Controllers\User\UserController;
=======
use Carbon\Carbon;

>>>>>>> db1c22e7dbf0bac988a57a6be48dc2f810800f79
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
    Route::get('/payment', [UserController::class, 'payment'])->name('user.payment');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});



// Route::middleware(['auth', 'role:user'])->prefix('user')->group(function() {

// });
require __DIR__ . '/auth.php';