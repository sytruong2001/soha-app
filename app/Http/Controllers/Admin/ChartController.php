<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\RevDaily;
use App\Models\DauDaily;
use App\Models\NruDaily;

class ChartController extends Controller
{
    public function showNRU(Request $request)
    {
        $start_date = Carbon::today()->subDays(6);
        $end_date = Carbon::now()->toDateTimeString();

        $users = NruDaily::select(DB::raw("total_register as new_user"), DB::raw("DATE_FORMAT(date, '%d-%m') as day_name"))
            ->whereDate('date', '>=', $start_date)
            ->whereDate('date', '<=', $end_date)
            // ->groupBy(DB::raw("Date(date)"))
            ->pluck('new_user', 'day_name');

        $labels = $users->keys();

        $data = $users->values();
        return view('admin.chart.view_new_register_user', compact('labels', 'data', 'users'));
    }

    public function showDAU()
    {
        $start_date = Carbon::today()->subDays(6);
        $end_date = Carbon::now()->toDateTimeString();

        $users = DauDaily::select(DB::raw("total_login as user_log"), DB::raw("DATE_FORMAT(date, '%d-%m') as day_log"))
            ->whereDate('date', '>=', $start_date)
            ->whereDate('date', '<=', $end_date)
            // ->groupBy(DB::raw("Date(login_time)"))
            ->pluck('user_log', 'day_log');

        $labels = $users->keys();

        $data = $users->values();

        return view('admin.chart.view_daily_active_user', compact('labels', 'data', 'users'));
    }

    public function showREV(Request $request)
    {
        $start_date = Carbon::today()->subDays(6);
        $end_date = Carbon::now()->toDateTimeString();

        $users = RevDaily::select(DB::raw("(total_kc)*200 as kc_numb"), DB::raw("DATE_FORMAT(date, '%d-%m') as day_name"))
            ->whereDate('date', '>=', $start_date)
            ->whereDate('date', '<=', $end_date)
            // ->groupBy(DB::raw("Date(date)"))
            ->pluck('kc_numb', 'day_name');

        $labels = $users->keys();

        $data = $users->values();

        return view('admin.chart.view_revenue', compact('labels', 'data', 'users'));
    }
}