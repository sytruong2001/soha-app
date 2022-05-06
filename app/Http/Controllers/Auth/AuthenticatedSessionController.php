<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        $id = Auth::user()->id;
        $role = DB::table('model_has_roles')->where('role_id', '>', '2')->where('model_id', '=', $id)->first();
        $time =  Carbon::now('Asia/Ho_Chi_Minh');
        $day = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $check = DB::table('login_log')->where('user_id', $id)->whereDate('login_time', $day)->first();
        
        if ($check == null && $role) {
            // dd($role);
            $loginLog = DB::table("login_log")->insert([
                'user_id' => $id,
                'login_time' => $time,
            ]);
        }
        if (auth()->user()->hasRole('admin')) {
            return redirect()->intended(RouteServiceProvider::HOME);
        } else {
            return redirect()->intended(RouteServiceProvider::WELCOME);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}