<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Models\InfoUser;
use App\Models\InfoAdmin;

class LogService
{
    public static function logService($user, $day)
    {
        $id = $user->id;
        $role = DB::table('model_has_roles')->where('role_id', '>', '2')->where('model_id', '=', $id)->first();
        $check = DB::table('login_log')->where('user_id', $id)->whereDate('login_time', $day)->first();
        if ($check === null && $role) {
            $loginLog = DB::table("login_log")->insert([
                'user_id' => $id,
                'login_time' => $day,
            ]);
        }
        
        if ($role) {
            $info = DB::table('info_user')->where('user_id', '=', $id)->first();
            // dd($info);
            if ($info) {
                if ($info->status == 0) {
                    // Kiểm tra tồn tại thông tin về số điện thoại
                    if ($info->phone != null) {
                        $otp = rand(100000, 999999);
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
                } else {
                    Auth::login($user);

                    if (auth()->user()->hasRole('admin')) {
                        return redirect()->intended(RouteServiceProvider::HOME);
                    } else if (auth()->user()->hasRole('user')) {
                        return redirect()->intended(RouteServiceProvider::WELCOME);
                    } else {
                        return redirect()->intended(RouteServiceProvider::DIALOG);
                    }
                }
            } else {
                $create = InfoUser::create(['phone' => null, 'user_id' => $id]);
                return view('auth.login-otp', [
                    'info' => $create,
                    'info_phone'  => $create->phone,
                    'id' => $id,
                ]);

            }
        } else {
            $info = DB::table('info_admin')->where('user_id', '=', $id)->first();
        }
        if ($info) {
            
            // Kiểm tra tồn tại thông tin về số điện thoại

            if ($info->phone != null) {
                $otp = rand(100000, 999999);
                Redis::set('otp', $otp, 'EX', 300);
                $message = "Mã OTP của bạn là:\n"
                    . "$otp"
                    . " thời gian sử dụng là 5 phút\n";
                // dd($message);
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
        } else {
            $create = InfoAdmin::create(['phone' => null, 'user_id' => $id]);
            return view('auth.login-otp', [
                'info' => $create,
                'info_phone'  => $create->phone,
                'id' => $id,
            ]);
        }
    }
}
