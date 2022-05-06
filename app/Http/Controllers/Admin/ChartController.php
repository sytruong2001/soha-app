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
        $end_date = Carbon::today()->addDay(1);
        if ($request->get('end_date') && $request->get('start_date')) {
            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');
            $users = User::select(DB::raw("COUNT(created_at) as new_user"), DB::raw("Date(created_at) as day_name"))
                ->where([
                    ['created_at', '>=', $start_date],
                    ['created_at', '<=', $end_date],
                ])
                ->groupBy(DB::raw("Date(created_at)"))
                ->pluck('new_user', 'day_name');
            $labels = $users->keys();
            $data = $users->values();
            $datas = [
                'labels' => $labels,
                'data' => $data,
            ];
            return response()->json(['users' => $users, 'datas' => $datas, 'labels' => $labels, 'data' => $data]);
        } else {
            $users = User::select(DB::raw("COUNT(created_at) as new_user"), DB::raw("Date(created_at) as day_name"))
                ->where([
                    ['created_at', '>=', $start_date],
                    ['created_at', '<=', $end_date],
                ])
                ->groupBy(DB::raw("Date(created_at)"))
                ->pluck('new_user', 'day_name');
        }


        $labels = $users->keys();

        $data = $users->values();

        $datas = [
            'labels' => $labels,
            'data' => $data,
        ];
        return view('admin.chart.view_new_register_user', [
            'datas' => $datas, 'users' => $users,
        ], compact('labels', 'data'));
    }
    public function showDAU()
    {
        return view('admin.chart.view_daily_active_user');
    }
    public function showREV()
    {
        $users = logKC::select(DB::raw("SUM(kc_numb)*200 as kc_numb"), DB::raw("Date(mua_kc_time) as day_name"))
            ->whereYear('mua_kc_time', date('Y'))
            ->groupBy(DB::raw("Date(mua_kc_time)"))
            ->pluck('kc_numb', 'day_name');

        $labels = $users->keys();

        $data = $users->values();

        $datas = [
            'labels' => $labels,
            'data' => $data,
        ];

        return view('admin.chart.view_revenue', [
            'datas' => $datas,
        ], compact('labels', 'data'));
    }

    public function update()
    {
        $users = logKC::select(DB::raw("SUM(kc_numb)*200 as kc_numb"), DB::raw("Date(mua_kc_time) as day_name"))
            ->whereYear('mua_kc_time', date('Y'))
            ->groupBy(DB::raw("Date(mua_kc_time)"))
            ->pluck('kc_numb', 'day_name');

        $labels = $users->keys();

        $data = $users->values();

        return response()->json(compact('labels', 'data'));
    }
    public function updateNRU()
    {
        $users = User::select(DB::raw("COUNT(created_at) as new_user"), DB::raw("Date(created_at) as day_name"))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Date(created_at)"))
            ->pluck('new_user', 'day_name');
        $labels = $users->keys();
        $data = $users->values();
        $datas = [
            'labels' => $labels,
            'data' => $data,
        ];
        return response()->json(['users' => $users, 'datas' => $datas, 'labels' => $labels, 'data' => $data]);
    }
}