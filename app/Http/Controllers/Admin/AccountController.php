<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

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

    public function show($id){
        $user = User::query()
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->join('info_user', 'users.id', '=', 'info_user.user_id')
        ->find($id);
        return response()->json([
            'data' => $user
          ]);
    }
}
