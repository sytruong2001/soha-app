<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Auth\RegisteredAdminController;
use App\Http\Controllers\Admin\ChartController;

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


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function() {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('/new-register-user', [ChartController::class, 'showNRU']);
    Route::get('/daily-active-user', [ChartController::class, 'showDAU']);
    Route::get('/revenue', [ChartController::class, 'showREV']);
    Route::resource('/account', AccountController::class);
    Route::post('/account/register_admin', [RegisteredAdminController::class, 'store']);
});



// Route::middleware(['auth', 'role:user'])->prefix('user')->group(function() {
    
// });
require __DIR__.'/auth.php';
