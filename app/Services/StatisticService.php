<?php

namespace App\Services;

use App\Models\DauDaily;
use App\Models\NruDaily;
use App\Models\RevDaily;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticService
{
    public function get_info_nru($start, $end)
    {
        $users = NruDaily::select(DB::raw("total_register as new_user"), DB::raw("DATE_FORMAT(date, '%d-%m') as day_name"))
            ->whereDate('date', '>=', $start)
            ->whereDate('date', '<=', $end)
            ->pluck('new_user', 'day_name');
        return $this->get_label_data($users);
    }
    public function get_info_dau($start, $end)
    {
        $users = DauDaily::select(DB::raw("total_login as user_log"), DB::raw("DATE_FORMAT(date, '%d-%m') as day_log"))
            ->whereDate('date', '>=', $start)
            ->whereDate('date', '<=', $end)
            ->pluck('user_log', 'day_log');
        return $this->get_label_data($users);
    }
    public function get_info_rev($start, $end)
    {
        $users = RevDaily::select(DB::raw("(total_kc)*200 as kc_numb"), DB::raw("DATE_FORMAT(date, '%d-%m') as day_name"))
            ->whereDate('date', '>=', $start)
            ->whereDate('date', '<=', $end)
            ->pluck('kc_numb', 'day_name');
        return $this->get_label_data($users);
    }
    public function get_label_data($users)
    {
        $labels = $users->keys();

        $data = $users->values();
        $result = [
            'users' => $users,
            'labels' => $labels,
            'data' => $data,
        ];
        return $result;
    }
}