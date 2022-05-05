<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Models\logKC;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Carbon;

class ChartController extends Controller
{
    public function showNRU()
    {
        return view('admin.chart.view_new_register_user');
    }
    public function showDAU()
    {
        return view('admin.chart.view_daily_active_user');
    }
    // public function showREV()
    // {
    //     $users = logKC::select(DB::raw("SUM(kc_numb)*200 as kc_numb"), DB::raw("Date(mua_kc_time) as day_name"))
    //         ->whereYear('mua_kc_time', date('Y'))
    //         ->groupBy(DB::raw("Date(mua_kc_time)"))
    //         ->pluck('kc_numb', 'day_name');

    //     $labels = $users->keys();

    //     $data = $users->values();

    //     return view('admin.chart.view_revenue', compact('labels', 'data', 'users'));
    // }

    public function update()
    {
        $users = logKC::select(DB::raw("SUM(kc_numb)*200 as kc_numb"), DB::raw("Date(mua_kc_time) as day_name"))
            ->whereYear('mua_kc_time', date('Y'))
            ->groupBy(DB::raw("Date(mua_kc_time)"))
            ->pluck('kc_numb', 'day_name');

        $labels = $users->keys();

        $data = $users->values();
        return response()->json(compact('labels', 'data', 'users'));
    }

    // public function show(Request $rq)
    // {
    //     if ($rq->get('start_date') && $rq->get('end_date')){
            
    //         $start_date = $rq->start_date;
    //         $end_date = $rq->end_date;
    //     }else{
    //         $start_date = Carbon::today()->subDays(6);
    //         $end_date = Carbon::today();
    //     }
    //     $users = logKC::select(DB::raw("SUM(kc_numb)*200 as kc_numb"), DB::raw("Date(mua_kc_time) as day_name"))
    //     ->where(
    //         [
    //             ['mua_kc_time', '>=', $rq->start_date],
    //             ['mua_kc_time', '<=', $rq->end_date],
    //         ])
    //     ->groupBy(DB::raw("Date(mua_kc_time)"))
    //     ->pluck('kc_numb', 'day_name');

    //     $labels = $users->keys();

    //     $data = $users->values();
    //     return response()->json(compact('labels', 'data', 'users'));
    // }
    public function showREV(Request $rq)
    {
        
        if ($rq->get('start_date') && $rq->get('end_date')){
            // dd(1);
            $start_date = $rq->start_date;
            $end_date = $rq->end_date;
        }else{
            // dd(2);
            $start_date = Carbon::today()->subDays(6);
            $end_date = Carbon::today();
        }

        $users = logKC::select(DB::raw("SUM(kc_numb)*200 as kc_numb"), DB::raw("Date(mua_kc_time) as day_name"))
            ->where(
                [
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
