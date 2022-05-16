<?php

namespace App\Services;

use App\Models\Requested;
use Illuminate\Support\Facades\DB;

class ReqService
{
    public function get_info_req()
    {
        $accounts_requested = Requested::query()
            ->with('user')
            ->orderByDesc('updated_at')
            ->get();
        return $accounts_requested;
    }
    public function delete($id)
    {
        $delete_req = DB::table("requested")
            ->where('user_id', $id)
            ->delete();
    }
}