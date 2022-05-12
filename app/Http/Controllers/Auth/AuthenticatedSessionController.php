<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\InfoAdmin;
use App\Models\InfoUser;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\Otp;
use Illuminate\Support\Facades\Redis;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function check(Request $request)
    {
        
        // Kiểm tra thông tin đăng nhập (email và mật khẩu)
        $user  = User::where('email', '=', request('email'))->first();
        \Hash::check(request('password'), $user->password);
        if (\Hash::check(request('password'), $user->password)) {
            $id = $user->id;
            $role = DB::table('model_has_roles')->where('role_id', '>', '2')->where('model_id', '=', $id)->first();
            $time =  Carbon::now('Asia/Ho_Chi_Minh');
            $time_expire =  Carbon::now('Asia/Ho_Chi_Minh')->addMinutes(5);
            $day = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
            $check = DB::table('login_log')->where('user_id', $id)->whereDate('login_time', $day)->first();
            // Tạo lịch sử đăng nhập nếu là user
            if ($check == null && $role) {
                // dd($role);
                $loginLog = DB::table("login_log")->insert([
                    'user_id' => $id,
                    'login_time' => $time,
                ]);
            }
            // Lấy thông tin người dùng bình thườn
            if ($role) {
                $info = DB::table('info_user')->where('user_id', '=', $id)->first();
                if ($info->status == 0) {
                    if ($info) {
                        // Kiểm tra tồn tại thông tin về số điện thoại
                        if ($info->phone != null) {
                            $otp = rand(100000,999999);
                            // Kiểm tra tồn tại của bảng otp
                            // $find = DB::table('otp')->where('user_id', '=', $id)->first();
                            // if ($find) {
                            //     $update = Otp::where('user_id','=',$id)->update(['otp' => $otp, 'created_at' => $time, 'updated_at' => $time_expire]);
                            // }else{
                            //     $create = Otp::create(['otp' => $otp, 'user_id' => $id, 'created_at' => $time, 'updated_at' => $time_expire]);
                            // }
                            Redis::set('otp', $otp, 'EX', 300);
                            $message = "Mã OTP của bạn là:\n"
                                . "$otp"
                                . " thời gian sử dụng là 5 phút\n";
                            // dd($message);
                            // if ($info->telegram_id) {
                            //     Telegram::sendMessage([
                            //         'chat_id' => $info->telegram_id,
                            //         'parse_mode' => 'HTML',
                            //         'text' => $message
                            //     ]);
                            // } else {
                                Telegram::sendMessage([
                                    'chat_id' => env('TELEGRAM_CHANNEL_ID', ''),
                                    'parse_mode' => 'HTML',
                                    'text' => $message
                                ]);
                            // }
                            return view('auth.login-otp', [
                                'info' => $info,
                                'info_phone'  => $info->phone,
                                'id' => $id,
                            ]);
                        }    
                        return view('auth.login-otp', [
                            'info' => $info,
                            'info_phone'  => $info->phone,
                            'id' => $id,
                        ]);
                    }else{
                        $create = InfoUser::create(['phone' => null, 'user_id' => $id]);
                        return view('auth.login-otp', [
                            'info' => $create,
                            'info_phone'  => $create->phone,
                            'id' => $id,
                        ]);
                    }
                } else{
                    $login = User::where('id','=', $id)->first();
                    Auth::login($login);

                    if (auth()->user()->hasRole('admin')) {
                        return redirect()->intended(RouteServiceProvider::HOME);
                    } else if (auth()->user()->hasRole('user')) {
                        return redirect()->intended(RouteServiceProvider::WELCOME);
                    } else {
                        return redirect()->intended(RouteServiceProvider::DIALOG);
                    }
                }
            } else {
                $info = DB::table('info_admin')->where('user_id', '=', $id)->first();
            }
            // Kiểm tra tồn tại thông tin của admin
            if ($info) {
                // Kiểm tra tồn tại thông tin về số điện thoại
                if ($info->phone != null) {
                    $otp = rand(100000,999999);
                    // Kiểm tra tồn tại của bảng otp
                    // $find = DB::table('otp')->where('user_id', '=', $id)->first();
                    // if ($find) {
                    //     $update = Otp::where('user_id','=',$id)->update(['otp' => $otp, 'created_at' => $time, 'updated_at' => $time_expire]);
                    // }else{
                    //     $create = Otp::create(['otp' => $otp, 'user_id' => $id, 'created_at' => $time, 'updated_at' => $time_expire]);
                    // }

                    Redis::set('otp', $otp, 'EX', 300);

                    $message = "Mã OTP của bạn là:\n"
                        . "$otp"
                        . " thời gian sử dụng là 5 phút\n";
                    if ($info->telegram_id) {
                        Telegram::sendMessage([
                            'chat_id' => $info->telegram_id,
                            'parse_mode' => 'HTML',
                            'text' => $message
                        ]);
                    } else {
                        Telegram::sendMessage([
                            'chat_id' => env('TELEGRAM_CHANNEL_ID', ''),
                            'parse_mode' => 'HTML',
                            'text' => $message
                        ]);
                    }
                    return view('auth.login-otp', [
                        'info' => $info,
                        'info_phone'  => $info->phone,
                        'id' => $id,
                    ]);
                }    
                return view('auth.login-otp', [
                    'info' => $info,
                    'info_phone'  => $info->phone,
                    'id' => $id,
                ]);
            }else{
                $create = InfoAdmin::create(['phone' => null, 'user_id' => $id]);
                return view('auth.login-otp', [
                    'info' => $create,
                    'info_phone'  => $create->phone,
                    'id' => $id,
                ]);
            }

        } else {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }  
    }

    public function store(Request $request)
    {   
        $otp = $request->otp;
        // $time =  Carbon::now('Asia/Ho_Chi_Minh');
        $user_id = $request->id;
        // $log  = Otp::where('user_id','=', $user_id)
        //         ->where('otp', '=', $otp)
        //         ->where([
        //             ['created_at', '<=', $time],
        //             ['updated_at', '>=', $time],
        //         ])
        //         ->first();
        $cache = Redis::get('otp');
        // dd($log);
        // Kiểm tra đăng nhập
        if ($otp == $cache) {
            $login = User::where('id','=', $user_id)->first();
            Auth::login($login);

            if (auth()->user()->hasRole('admin')) {
                return redirect()->intended(RouteServiceProvider::HOME);
            } else if (auth()->user()->hasRole('user')) {
                return redirect()->intended(RouteServiceProvider::WELCOME);
            } else {
                return redirect()->intended(RouteServiceProvider::DIALOG);
            }
        }else{
            throw ValidationException::withMessages([
                'email' => trans('auth.expires'),
            ]);
        }
        
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */


    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
