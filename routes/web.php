<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Auth\RegisteredAdminController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Redirect;


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
Route::middleware(['auth', 'role:lock'])->prefix('lock')->group(function () {
    Route::get('/', [UserController::class, 'dialog'])->name('lock.dialog');
});

// Route::post('login-otp', [AuthenticatedSessionController::class, 'store']);

Route::get('/updated-activity', [TelegramController::class, 'updatedActivity']);

Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('user.dashboard');
        Route::get('/get-info', 'getInfoUser')->name('user.getInfoUser');
        Route::post('/update_info', 'updateInfoUser')->name('user.updateInfoUser');
        Route::get('/payment', 'payment')->name('user.payment');
        Route::get('/get-info-payment', 'getInfoPayment')->name('user.getInfoPayment');
        Route::post('/update-payment', 'UpdatePayment')->name('user.updatePayment');
        Route::post('/update-kc', 'UpdateKC')->name('user.updateKC');
    });

    Route::controller(NewPasswordController::class)->group(function () {
        Route::get('/reset-password', 'getInfo')->name('user.reset');
        // Route::post('/reset-password', 'store')->name('user.updatePass');
    });
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');

    Route::controller(ChartController::class)->group(function () {
        Route::get('/new-register-user', 'showNRU');
        Route::post('/new-register-user', 'showNRU');
        Route::get('/daily-active-user', 'showDAU');
        Route::get('/revenue', 'showREV');
    });

    Route::controller(AccountController::class)->group(function () {
        Route::get('/account', 'index');
        Route::get('/lock-account/{id}', 'lockAccount');
        Route::get('/unlock-account/{id}', 'unlockAccount');
        Route::get('/account-locked', 'accountLocked');
        Route::get('/info-admin/{id}', 'infoAdmin');
        Route::post('/change-password', 'changePassword');
    });

    Route::post('/account/register_admin', [RegisteredAdminController::class, 'store']);

    Route::get('/link', function () {
        $otp = rand(100000,999999);
        $url = "https://t.me/SohaAppBot?start=";
        Redis::set('otp_tele', $otp, 'EX', 100);
        $get_otp = Redis::get('otp_tele');
        return Redirect::to($url.$get_otp);
    });

});


//Route cho file Api
Route::prefix('api')->group(function () {
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
        Route::controller(ApiController::class)->group(function () {
            Route::get('/revenue/update', 'updateREV');
            Route::get('/new-register-user/update', 'updateNRU');
            Route::get('/daily-active-user/update', 'updateDAU');
            Route::get('/daily-active-user', 'showDAU');
            Route::get('/revenue', 'showREV');
            Route::get('/new-register-user', 'showNRU');
            Route::post('/change-password', 'changePassword');
            Route::post('/change-info', 'changeInfo');
        });
    });
    Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {

        Route::get('/get-info', [ApiController::class, 'getInfoUser'])->name('user.getInfoUser');
        Route::post('/update_info', [ApiController::class, 'updateInfoUser'])->name('user.updateInfoUser');
        Route::get('/get-info-payment', [ApiController::class, 'getInfoPayment'])->name('user.getInfoPayment');
        Route::post('/update-payment', [ApiController::class, 'UpdatePayment'])->name('user.updatePayment');
        Route::post('/update-kc', [ApiController::class, 'UpdateKC'])->name('user.updateKC');
        Route::post('/reset-password', [ApiController::class, 'changePasswordUser'])->name('user.updatePass');
    });
    Route::middleware(['auth', 'role:lock'])->prefix('lock')->group(function () {
        Route::post('/repost', [ApiController::class, 'CSKH'])->name('lock.CSKH');
        Route::get('/unlock-account/{id}', [AccountController::class, 'unlockAccount']);
    });

    Route::middleware('guest')->group(function () {
        Route::post('/login', [ApiController::class, 'phone']);
    });
});


require __DIR__ . '/auth.php';