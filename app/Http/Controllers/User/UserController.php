<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\InfoUser;
use App\Models\KC;
use App\Models\logCoin;
use App\Models\logKC;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // trở về trang thông tin người dùng
    public function index()
    {
        return view('user.ID');
    }


    // trở về trang mua coin và mua kc
    public function payment()
    {
        return view('user.Payment');
    }

    public function dialog()
    {
        return view('user.error_login');
    }
}