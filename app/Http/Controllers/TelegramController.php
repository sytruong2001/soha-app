<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;
use App\Models\InfoAdmin;
use Illuminate\Support\Facades\Auth;


class TelegramController extends Controller
{
    public function updatedActivity()
    {
        $id = Auth::user()->id;
        $activity = Telegram::getUpdates();
        $chat_id = Arr::last($activity)->message->chat->id;
        $text = Arr::last($activity)->message->text;
        $check = substr($text, 0, 6);

        if ($check == "/start") {
            $check_admin = InfoAdmin::where('user_id', '=', $id)->where('telegram_id', '=', $chat_id)->count();
            if ($check_admin == 1) {
            } else {
                // $otp = substr($text, 7, 6);
                // $cache_otp =  Redis::get('otp_tele');
                // if ($otp == $cache_otp) {
                $update = InfoAdmin::where('user_id', '=', $id)->update(['telegram_id' => $chat_id]);
                // }
                // else{
                // dd(Arr::last($activity));
                // }
            }
        }
        dd(Arr::last($activity));
    }
}