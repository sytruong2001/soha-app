<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserService
{
    public function get_info_user($id = null)
    {
        if ($id != null) {
            $get_user = User::query()
                ->join('info_user', 'users.id', '=', 'info_user.user_id')
                ->find($id);
        } else {
            $get_user = User::query()
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('info_user', 'users.id', '=', 'info_user.user_id')
                ->where('role_id', '=', 3)
                ->get();
        }

        return $get_user;
    }

    public function get_info_admin($id = null)
    {
        if ($id != null) {
            $get_admin = User::query()
                ->join('info_admin', 'users.id', '=', 'info_admin.user_id')
                ->where('user_id', $id)
                ->first();
        } else {
            $get_admin = User::query()
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('info_admin', 'users.id', '=', 'info_admin.user_id')
                ->where('role_id', '=', 2)
                ->get();
        }

        return $get_admin;
    }
}
