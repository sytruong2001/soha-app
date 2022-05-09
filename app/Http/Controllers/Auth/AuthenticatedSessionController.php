<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\InfoAdmin;
use App\Models\InfoUser;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Telegram\Bot\Laravel\Facades\Telegram;


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
    public function check(Request $request)
    {
        // $request->authenticate();

        // $request->session()->regenerate();

        $user  = User::where('email', '=', request('email'))->first();
        \Hash::check(request('password'), $user->password);
        if (\Hash::check(request('password'), $user->password)) {
            $id = $user->id;
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
            if ($role) {

                $info = DB::table('info_user')->where('user_id', '=', $id)->first();

            } else {

                $info = DB::table('info_admin')->where('user_id', '=', $id)->first();

            }
            // dd($info->phone);
            if ($info->phone) {
                $otp = rand(100000,999999);
                $add_otp = User::where('id','=',$id)->update(['otp' => $otp]);
                $message = "Mã OTP của bạn là:\n"
                    . "$otp"
                    . " thời gian sử dụng là 5 phút\n";
                // dd($message);
                Telegram::sendMessage([
                    'chat_id' => env('TELEGRAM_CHANNEL_ID', ''),
                    'parse_mode' => 'HTML',
                    'text' => $message
                ]);
                return view('auth.login-otp', [
                    'info' => $info,
                    'info_phone'  => $info->phone,
                    'id' => $id,
                ]);
            }else{
                return view('auth.login-otp', [
                    'info' => $info,
                    'info_phone'  => $info->phone,
                    'id' => $id,
                ]);
            }

        } else {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }  
    }

    public function store(Request $request)
    {   
        $otp = $request->otp;
        $user_id = $request->id;
        $log  = User::where('id','=', $user_id)->where('otp', '=', $otp)->first();
        // dd($log);
        if ($log) {
            Auth::login($log);

            if (auth()->user()->hasRole('admin')) {
                return redirect()->intended(RouteServiceProvider::HOME);
            } else if (auth()->user()->hasRole('user')) {
                return redirect()->intended(RouteServiceProvider::WELCOME);
            } else {
                return redirect()->intended(RouteServiceProvider::DIALOG);
            }
        }else{
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
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
