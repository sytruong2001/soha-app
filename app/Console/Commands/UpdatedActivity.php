<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;
use App\Models\InfoAdmin;
use Illuminate\Support\Facades\Auth;

class UpdatedActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updated:activity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updated Activity';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id = Auth::user()->id;
        $activity = Telegram::getUpdates();
        $chat_id = Arr::last($activity)->message->chat->id;
        $text = Arr::last($activity)->message->text;
        $check = substr($text, 0, 6);
        // dd(Arr::last($activity));
        if( $check == "/start" ){
            $cache_otp = Redis::get('otp_tele');
            $otp = substr($text, 7, 6);
            if ($otp == $cache_otp) {
                $update = InfoAdmin::where('user_id','=',$id)->update(['telegram_id' => $chat_id]);
            }
            else{
               return 'mã otp k trùng';
            }
        }
        return 'k ton tai text';
    }
}
