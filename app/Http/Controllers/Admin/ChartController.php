<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Models\logKC;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ChartController extends Controller
{
    public function showNRU(Request $request)
    {
        $from = '';
        $to = '';
        if ($request->get('to') && $request->get('from')) {
            $from = $request->get('from');
            $to = $request->get('to');
            $users = User::select(DB::raw("COUNT(created_at) as new_user"), DB::raw("Date(created_at) as day_name"))
                ->whereYear('created_at', date('Y'))
                ->where([
                    ['created_at', '>=', $from],
                    ['created_at', '<=', $to],
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
                ->whereYear('created_at', date('Y'))
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