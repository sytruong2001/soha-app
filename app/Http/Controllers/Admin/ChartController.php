<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Models\logKC;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function showNRU(Request $request)
    {
        $start_date = Carbon::today()->subDays(6);
        $end_date = Carbon::now()->toDateTimeString();

        $users = User::select(DB::raw("COUNT(created_at) as new_user"), DB::raw("Date(created_at) as day_name"))
            ->where([
                ['created_at', '>=', $start_date],
                ['created_at', '<=', $end_date],
            ])
            ->groupBy(DB::raw("Date(created_at)"))
            ->pluck('new_user', 'day_name');
        
        $labels = $users->keys();

        $data = $users->values();
        return view('admin.chart.view_new_register_user', compact('labels', 'data', 'users'));
    }

    public function showDAU()
    {
        return view('admin.chart.view_daily_active_user');
    }

    public function showREV(Request $request)
    {
        $start_date = Carbon::today()->subDays(6);
        $end_date = Carbon::now()->toDateTimeString();
  
        $users = logKC::select(DB::raw("SUM(kc_numb)*200 as kc_numb"), DB::raw("Date(mua_kc_time) as day_name"))
        ->where([
            ['mua_kc_time', '>=', $start_date],
            ['mua_kc_time', '<=', $end_date],
        ])
        ->groupBy(DB::raw("Date(mua_kc_time)"))
        ->pluck('kc_numb', 'day_name');

        $labels = $users->keys();

        $data = $users->values();

        return view('admin.chart.view_revenue', compact('labels', 'data', 'users'));
    }
}