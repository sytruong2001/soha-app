<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Nru_daily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:nru';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update new register user';

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
        $get_info_new_user = User::select(DB::raw("COUNT(id) as id"))
            ->whereDate('created_at', '=', $today)
            ->get();
        foreach ($get_info_new_user as $value) {
            if ($value->id != null) {
                $amount = $value->id;
            } else {
                $amount = 0;
            }
        }
        $check_nru_daily = DB::table('nru_daily')->where('date', $today)->count();
        if ($check_nru_daily == 0) {
            $create_nru_daily = DB::table('nru_daily')->insert([
                'total_register' => $amount,
                'date' => $today,
            ]);
        } else {
            $update_nru_daily = DB::table('nru_daily')->where('date', $today)->update([
                'total_register' => $amount,
            ]);
        }
    }
}