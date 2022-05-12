<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpFoundation\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;
use App\Models\InfoAdmin;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProcessUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $id;
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $id_user = $this->id;
        $activity = Telegram::getUpdates();
        $chat_id = Arr::last($activity)->message->chat->id;
        $text = Arr::last($activity)->message->text;
        $check = substr($text, 0, 6);

        if ($check == "/start") {
            $otp = substr($text, 7, 6);
            $cache_otp = Redis::get('otp_tele');
            if ($otp == $cache_otp) {
                $update = InfoAdmin::where('user_id', '=', $id_user)->update(['telegram_id' => $chat_id]);
            } else {
                return 'mã otp k trùng';
            }
        }
    }
}