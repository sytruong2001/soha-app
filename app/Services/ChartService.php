<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\RevDaily;
use App\Models\DauDaily;
use App\Models\NruDaily;


class ChartService
{
    public static function getChartReport($charts)
    {
        $labels = $charts->keys();
        $data = $charts->values();
        $entries = [
            'labels' => $labels,
            'data' => $data,
        ];       
        return $entries;
    }

    public static function getDateRequest($request)
    {
        if ($request == null) {
            $start_date = Carbon::today()->subDays(6);
            $end_date = Carbon::now()->toDateTimeString();
        } else {
            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');
        }
        $date = [
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];       
        return collect($date);
    }
    public static function showNRU($date)
    {
        $charts = NruDaily::select(DB::raw("total_register as new_user"), DB::raw("DATE_FORMAT(date, '%d-%m') as day_name"))
        ->whereBetween('date', [$date['start_date'], $date['end_date']])
        // ->groupBy(DB::raw("Date(date)"))
        ->pluck('new_user', 'day_name');
        return $charts;
    }
    public static function showDAU($date)
    {
        $charts = DauDaily::select(DB::raw("total_login as user_log"), DB::raw("DATE_FORMAT(date, '%d-%m') as day_log"))
        ->whereBetween('date', [$date['start_date'], $date['end_date']])
        // ->groupBy(DB::raw("Date(login_time)"))
        ->pluck('user_log', 'day_log');    
        return $charts;
    }
    public static function showREV($date)
    {
        $charts = RevDaily::select(DB::raw("(total_kc)*200 as kc_numb"), DB::raw("DATE_FORMAT(date, '%d-%m') as day_name"))
        ->whereBetween('date', [$date['start_date'], $date['end_date']])
        // ->groupBy(DB::raw("Date(date)"))
        ->pluck('kc_numb', 'day_name'); 
        return $charts;
    }
}
