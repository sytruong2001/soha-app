<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('user.ID');
    }
    public function getInfoUser(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        echo json_encode($user);
    }
    public function payment()
    {
        return view('user.Payment');
    }
}