<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramService
{
    public function create_and_send_otp()
    {
        $otp = rand(100000, 999999);
        Redis::set('otp', $otp, 'EX', 300);
        $message = "Mã OTP của bạn là:\n"
            . "$otp"
            . " thời gian sử dụng là 5 phút\n";
        // dd($message);
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHANNEL_ID', ''),
            'parse_mode' => 'HTML',
            'text' => $message
        ]);
    }
}