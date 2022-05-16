<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\RevDaily;
use App\Models\DauDaily;
use App\Models\NruDaily;
use App\Services\StatisticService;

class ChartController extends Controller
{
    private $service;
    public function __construct(StatisticService $service)
    {
        $this->service = $service;
    }
    public function showNRU(Request $request)
    {
        $start_date = Carbon::today()->subDays(6);
        $end_date = Carbon::now()->toDateTimeString();
        $users = $this->service->get_info_nru($start_date, $end_date);
        $labels = $users->keys();
        $data = $users->values();
        return view('admin.chart.view_new_register_user', compact('labels', 'data', 'users'));
    }

    public function showDAU()
    {
        $start_date = Carbon::today()->subDays(6);
        $end_date = Carbon::now()->toDateTimeString();

        $users = $this->service->get_info_dau($start_date, $end_date);

        $labels = $users->keys();

        $data = $users->values();

        return view('admin.chart.view_daily_active_user', compact('labels', 'data', 'users'));
    }

    public function showREV(Request $request)
    {
        $start_date = Carbon::today()->subDays(6);
        $end_date = Carbon::now()->toDateTimeString();
        $users = $this->service->get_info_rev($start_date, $end_date);
        $labels = $users->keys();
        $data = $users->values();
        return view('admin.chart.view_revenue', compact('labels', 'data', 'users'));
    }
}