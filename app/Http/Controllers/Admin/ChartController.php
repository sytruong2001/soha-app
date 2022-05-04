<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function showNRU(){
        return view('admin.chart.view_new_register_user');
    }
    public function showDAU(){
        return view('admin.chart.view_daily_active_user');
    }
    public function showREV(){
        return view('admin.chart.view_revenue');
    }
}
