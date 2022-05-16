<?php

namespace App\Services;

use App\Models\Lock;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Locked;

class LockedService
{
    public function get_info_locked()
    {
        $accounts_locked = Lock::query()
            ->with('user', 'locker')
            ->where('locked.status', 0)
            ->orderByDesc('locked.updated_at')
            ->get();
        return $accounts_locked;
    }
    public function createOrUpdate($request)
    {
        $id_admin = Auth::user()->id;
        $id = $request->get('id');
        $time = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
        $msg = $request->get('msg');
        if ($msg) {
            $locked = DB::table('locked')
                ->insert([
                    'locked_id' => $id,
                    'message' => $msg,
                    'locked_by' => $id_admin,
                    'created_at' => $time,
                    'updated_at' => $time,
                ]);
        } else {
            $locked = DB::table('locked')
                ->where('locked_id', $id)
                ->update([
                    'status' => 0,
                    'updated_at' => $time,
                ]);
        }

        return $locked;
    }
    public function delete($id)
    {
        $delete_locked = DB::table("locked")
            ->where('locked_id', $id)
            ->delete();
    }
}