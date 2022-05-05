<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

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
    public function lockAccount($id)
    {
        $lock = DB::table("model_has_roles")
            ->where('model_id', $id)
            ->update([
                'role_id' => 4,
            ]);
        return response()->json([
            'success' => 200
        ]);
    }
    public function unlockAccount($id)
    {
        $unlock = DB::table("model_has_roles")
            ->where('model_id', $id)
            ->update([
                'role_id' => 3,
            ]);
        return response()->json([
            'success' => 200
        ]);
    }
    public function accountLocked()
    {
        $accounts_locked = User::query()
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('info_user', 'users.id', '=', 'info_user.user_id')
            ->where('role_id', '=', 4)
            ->get();
        return view('admin.account.view_account_locked', [
            'accounts_locked' => $accounts_locked,
        ]);
    }
    public function infoAdmin($id)
    {
        $accounts_admin = User::query()
            ->join('info_admin', 'users.id', '=', 'info_admin.user_id')
            ->where('user_id', $id)
            ->get();
        return view('admin.account.view_info_admin', [
            'accounts_admin' => $accounts_admin,
        ]);
    }
}