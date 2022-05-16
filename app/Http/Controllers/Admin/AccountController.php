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
use App\Services\LockedService;
use App\Services\ModelHasRoleService;
use App\Services\ReqService;
use App\Services\UserService;

class AccountController extends Controller
{
    private $user;
    private $locked;
    private $role;
    private $req;
    public function __construct(UserService $user, LockedService $locked, ModelHasRoleService $role, ReqService $req)
    {
        $this->user = $user;
        $this->locked = $locked;
        $this->role = $role;
        $this->req = $req;
    }
    public function index()
    {
        $accounts_user = $this->user->get_info_user();
        $accounts_admin = $this->user->get_info_admin();

        return view('admin.account.view_all', [
            'accounts_user' => $accounts_user,
            'accounts_admin' => $accounts_admin,
        ]);
    }

    public function show($id)
    {
        $user = $this->user->get_info_user($id);
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
        $id = $request->get('id');
        $check = DB::table('locked')->where('locked_id', $id)->count();
        if ($check == 1) {
            $update_locked = $this->locked->createOrUpdate($request);
            $this->req->delete($id);
        } else {
            $update_role = $this->role->update_role($id, 4);
            $create_locked = $this->locked->createOrUpdate($request);
        }
        return response()->json([
            'code' => 200,
        ]);
    }
    public function unlockAccount($id)
    {
        $unlock = $this->role->update_role($id, 3);
        $this->locked->delete($id);
        $this->req->delete($id);
        return response()->json([
            'success' => 200
        ]);
    }
    public function accountLocked()
    {
        $accounts_locked = $this->locked->get_info_locked();
        $accounts_requested = $this->req->get_info_req();
        return view('admin.account.view_account_locked', [
            'accounts_locked' => $accounts_locked,
            'accounts_requested' => $accounts_requested,
        ]);
    }
    public function infoAdmin($id)
    {
        $accounts_admin = $this->user->get_info_admin($id);
        return view('admin.account.view_info_admin', [
            'accounts_admin' => $accounts_admin,
        ]);
    }
}