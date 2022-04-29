<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;

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
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

Route::controller(GoogleController::class)->group(function () {
    Route::get('/login/google', 'login');
    Route::get('/login/google/callback', 'callback');
});

// Route::middleware(['auth', 'role:user'])->prefix('user')->group(function() {
    
// });
require __DIR__.'/auth.php';
