<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lock;
use App\Models\logCoin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Requested;

class AccountController extends Controller
{
    public function index()
    {
        $accounts_user = User::query()
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('info_user', 'users.id', '=', 'info_user.user_id')
            ->where('role_id', '=', 3)
            ->get();

        $accounts_admin = User::query()
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('info_admin', 'users.id', '=', 'info_admin.user_id')
            ->where('role_id', '=', 2)
            ->get();

        return view('admin.account.view_all', [
            'accounts_user' => $accounts_user,
            'accounts_admin' => $accounts_admin,
        ]);
    }

    public function show($id)
    {
        $user = User::query()
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('info_user', 'users.id', '=', 'info_user.user_id')
            ->find($id);
        return response()->json([
            'data' => $user
        ]);
    }

    public function show_req($id)
    {
        $user = User::query()->with('info_user')
            ->where('users.id', $id)->first();
        $nap_coin = DB::table('nap_coin_log')->where('user_id', $id)->orderByDesc('id')->paginate(3);
        return response()->json([
            'user' => $user,
            'nap_coin' => $nap_coin,
        ]);
    }
    public function lockAccount(Request $request)
    {
        $id_admin = Auth::user()->id;
        $id = $request->get('id');
        $time = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
        $check = DB::table('locked')->where('locked_id', $id)->count();
        if ($check == 1) {
            $update = DB::table('locked')
                ->where('locked_id', $id)
                ->update([
                    'status' => 0,
                    'updated_at' => $time,
                ]);
            $delete_req = DB::table("requested")
                ->where('user_id', $id)
                ->delete();
        } else {
            $msg = $request->get('msg');
            $lock = DB::table("model_has_roles")
                ->where('model_id', $id)
                ->update([
                    'role_id' => 4,
                ]);
            $insert = DB::table('locked')
                ->insert([
                    'locked_id' => $id,
                    'message' => $msg,
                    'locked_by' => $id_admin,
                    'created_at' => $time,
                    'updated_at' => $time,
                ]);
        }


        return response()->json([
            'code' => 200,
        ]);
    }
    public function unlockAccount($id)
    {
        $unlock = DB::table("model_has_roles")
            ->where('model_id', $id)
            ->update([
                'role_id' => 3,
            ]);
        $delete_locked = DB::table("locked")
            ->where('locked_id', $id)
            ->delete();
        $delete_req = DB::table("requested")
            ->where('user_id', $id)
            ->delete();
        return response()->json([
            'success' => 200
        ]);
    }
    public function accountLocked()
    {
        $accounts_locked = Lock::query()
            ->with('user', 'locker')
            ->where('locked.status', 0)
            ->orderByDesc('locked.updated_at')
            ->get();
        $accounts_requested = Requested::query()
            ->with('user')
            ->orderByDesc('updated_at')
            ->get();
        // dd($accounts_requested);
        return view('admin.account.view_account_locked', [
            'accounts_locked' => $accounts_locked,
            'accounts_requested' => $accounts_requested,
        ]);
    }
    public function infoAdmin($id)
    {
        $accounts_admin = User::query()
            ->join('info_admin', 'users.id', '=', 'info_admin.user_id')
            ->where('user_id', $id)
            ->first();
        return view('admin.account.view_info_admin', [
            'accounts_admin' => $accounts_admin,
        ]);
    }
}