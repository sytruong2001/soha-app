<?php

namespace App\Console\Commands;

use App\Models\logKC;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Rev_daily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:rev';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update revenue daily';

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
        $get_info_mua_kc_log = logKC::select(DB::raw("SUM(kc_numb) as kc_numb"))
            ->whereDate('mua_kc_time', '=', $today)
            ->get();
        foreach ($get_info_mua_kc_log as $value) {
            if ($value->kc_numb != null) {
                $amount = $value->kc_numb;
            } else {
                $amount = 0;
            }
        }
        $check_rev_daily = DB::table('rev_daily')->where('date', $today)->count();
        if ($check_rev_daily == 0) {
            $create_rev_daily = DB::table('rev_daily')->insert([
                'total_kc' => $amount,
                'date' => $today,
            ]);
        } else {
            $update_rev_daily = DB::table('rev_daily')->where('date', $today)->update([
                'total_kc' => $amount,
            ]);
        }
    }
}