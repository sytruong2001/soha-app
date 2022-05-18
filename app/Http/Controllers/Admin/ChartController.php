<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ChartService;

class ChartController extends Controller
{
    public function showNRU(Request $request = null)
    {
        $date = $this->chart->getDateRequest($request);
        $charts = $this->chart->showNRU($date);
        $entries = $this->chart->getChartReport($charts);

        return view('admin.chart.view_new_register_user',[
            'entries' => $entries,
            'charts' => $charts,
        ]);
    }

    public function showDAU(Request $request = null)
    {
        $date = $this->chart->getDateRequest($request);
        $charts = $this->chart->showDAU($date); 
        $entries = $this->chart->getChartReport($charts);

        return view('admin.chart.view_daily_active_user',[
            'entries' => $entries,
            'charts' => $charts,
        ]);
    }

    public function showREV(Request $request = null)
    {
        $date = $this->chart->getDateRequest($request);
        $charts = $this->chart->showREV($date); 
        $entries = $this->chart->getChartReport($charts);

        return view('admin.chart.view_revenue',[
            'entries' => $entries,
            'charts' => $charts,
        ]);
    }
}