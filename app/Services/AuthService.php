<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Telegram\Bot\Laravel\Facades\Telegram;

class AuthService
{
    public static function getOTP($info)
    {
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
    }

    public static function hasRole($id)
    {
        $role = DB::table('model_has_roles')->where('role_id', '>', '2')->where('model_id', '=', $id)->first();   
        
        return $role;
    }
}
