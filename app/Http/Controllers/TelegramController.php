<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;
use App\Models\InfoAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Jobs\ProcessUpdate;
use App\Models\InfoUser;
use Illuminate\Support\Facades\DB;

class TelegramController extends Controller
{
    public function connectTelegram()
    {
        $otp = rand(100000, 999999);
        $id = Auth::user()->id;
        $url = "https://t.me/SohaAppBot?start=";
        Redis::set('otp_tele', $otp, 'EX', 100);
        $get_otp = Redis::get('otp_tele');
        $processUpdate = (new ProcessUpdate($id))->delay(10);

        $this->dispatch($processUpdate);
        return Redirect::to($url . $get_otp);
    }
    // public function updatedActivity()
    // {
    //     $id = Auth::user()->id;
    //     $activity = Telegram::getUpdates();
    //     $chat_id = Arr::last($activity)->message->chat->id;
    //     $text = Arr::last($activity)->message->text;
    //     $check = substr($text, 0, 6);

    //     // dd(Arr::last($activity));
    //     if ($check == "/start") {
    //         $cache_otp = Redis::get('otp_tele');
    //         $otp = substr($text, 7, 6);
    //         if ($otp == $cache_otp) {
    //             $role = $this->auth->hasRole($id);
    //             // dd($role);
    //             if ($role == 1) {
    //                 $update_telegram_id_user = InfoUser::where('user_id', '=', $id)->update(['telegram_id' => $chat_id]);
    //             } else {
    //                 $update_telegram_id_admin = InfoAdmin::where('user_id', '=', $id)->update(['telegram_id' => $chat_id]);
    //             }
    //             return response()->json(['status' => 1]);
    //         } else {
    //             return 'mã otp k trùng';
    //         }
    //     }
    //     // dd(Arr::last($activity));
    // }
}