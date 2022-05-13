<?php

namespace App\Console\Commands;

use App\Models\loginLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Dau_daily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:dau';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Daily active user';

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
        $today =  Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get_info_user_active = loginLog::select(DB::raw("COUNT(id) as id"))
            ->whereDate('login_time', '=', $today)
            ->get();
        foreach ($get_info_user_active as $value) {
            if ($value->id != null) {
                $amount = $value->id;
            } else {
                $amount = 0;
            }
        }
        $check_dau_daily = DB::table('dau_daily')->where('date', $today)->count();
        if ($check_dau_daily == 0) {
            $create_dau_daily = DB::table('dau_daily')->insert([
                'total_login' => $amount,
                'date' => $today,
            ]);
        } else {
            $update_dau_daily = DB::table('dau_daily')->where('date', $today)->update([
                'total_login' => $amount,
            ]);
        }
    }
}