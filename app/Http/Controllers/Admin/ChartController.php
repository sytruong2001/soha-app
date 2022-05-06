<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Models\logKC;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use App\Models\loginLog;

class ChartController extends Controller
{
    public function showNRU(Request $request)
    {
        $start_date = Carbon::today()->subDays(6);
        $end_date = Carbon::now()->toDateTimeString();

        $users = User::select(DB::raw("COUNT(created_at) as new_user"), DB::raw("Date(created_at) as day_name"))
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->groupBy(DB::raw("Date(created_at)"))
            ->pluck('new_user', 'day_name');
        
        $labels = $users->keys();

        $data = $users->values();
        return view('admin.chart.view_new_register_user', compact('labels', 'data', 'users'));
    }

    public function showDAU()
    {
        $start_date = Carbon::today()->subDays(6);
        $end_date = Carbon::now()->toDateTimeString();

        $users = loginLog::select(DB::raw("COUNT(DISTINCT user_id) as user_log"), DB::raw("Date(login_time) as day_log"))
            ->whereDate('login_time', '>=', $start_date)
            ->whereDate('login_time', '<=', $end_date)
            ->groupBy(DB::raw("Date(login_time)"))
            ->pluck('user_log', 'day_log');
        
        $labels = $users->keys();

        $data = $users->values();

        return view('admin.chart.view_daily_active_user', compact('labels', 'data', 'users'));
    }

    public function showREV(Request $request)
    {
        $start_date = Carbon::today()->subDays(6);
        $end_date = Carbon::now()->toDateTimeString();
  
        $users = logKC::select(DB::raw("SUM(kc_numb)*200 as kc_numb"), DB::raw("Date(mua_kc_time) as day_name"))
        ->whereDate('mua_kc_time', '>=', $start_date)
        ->whereDate('mua_kc_time', '<=', $end_date)
        ->groupBy(DB::raw("Date(mua_kc_time)"))
        ->pluck('kc_numb', 'day_name');

        $labels = $users->keys();

        $data = $users->values();

        return view('admin.chart.view_revenue', compact('labels', 'data', 'users'));
    }
}