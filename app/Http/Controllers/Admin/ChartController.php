<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ChartService;

class ChartController extends Controller
{
    
    public function showNRU(Request $request = null)
    {
        $date = (new ChartService())->getDateRequest($request);
        $charts = (new ChartService())->showNRU($date);
        $entries = (new ChartService())->getChartReport($charts);

        return view('admin.chart.view_new_register_user',[
            'entries' => $entries,
            'charts' => $charts,
        ]);
    }

    public function showDAU(Request $request = null)
    {
        $date = (new ChartService())->getDateRequest($request);
        $charts = (new ChartService())->showDAU($date); 
        $entries = (new ChartService())->getChartReport($charts);

        return view('admin.chart.view_daily_active_user',[
            'entries' => $entries,
            'charts' => $charts,
        ]);
    }

    public function showREV(Request $request = null)
    {
        $date = (new ChartService())->getDateRequest($request);
        $charts = (new ChartService())->showREV($date); 
        $entries = (new ChartService())->getChartReport($charts);

        return view('admin.chart.view_revenue',[
            'entries' => $entries,
            'charts' => $charts,
        ]);
    }
}