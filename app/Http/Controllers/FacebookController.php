<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Social; //sử dụng model Social
// use Socialite; //sử dụng Socialite
use App\Models\User; //sử dụng model Login
use App\Models\InfoUser;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;


class FacebookController extends Controller
{
    public function login_facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook()
    {
        $time =  Carbon::now('Asia/Ho_Chi_Minh');
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider', 'facebook')->where('provider_user_id', $provider->getId())->first();
        if ($account) {
            //login in vao trang quan tri
            $account_name = User::where('id', $account->user)->first();
            $loginLog = DB::table("login_log")->insert([
                'user_id' => $account->user,
                'login_time' => $time,
            ]);
            Auth::login($account_name);
            if (auth()->user()->hasRole('admin')) {
                return redirect()->intended(RouteServiceProvider::HOME);
            } else {
                return redirect()->intended(RouteServiceProvider::WELCOME);
            }
        } else {
            // tạo user mới
            $check_email = User::where('email', $provider->getEmail())->first();
            if ($check_email) {
                $fb = Social::create([
                    'provider_user_id' => $provider->getId(),
                    'provider' => 'facebook',
                    'user' => $check_email->id,
                ]);
                $loginLog = DB::table("login_log")->insert([
                    'user_id' => $check_email->id,
                    'login_time' => $time,
                ]);
                Auth::login($check_email);
                if (auth()->user()->hasRole('admin')) {
                    return redirect()->intended(RouteServiceProvider::HOME);
                } else {
                    return redirect()->intended(RouteServiceProvider::WELCOME);
                }
            } else {
                $new_user = User::create([
                    'name' => $provider->getName(),
                    'email' => $provider->getEmail(),
                    'email_verified_at' => now(),
                    'password' => '',
                    'remember_token' => Str::random(10),

                ]);
                $new_user->assignRole('user');
                $info_user = InfoUser::create([
                    'user_number' => 'SHA' . Carbon::now()->format('su'),
                    'user_id' => $new_user->id,
                ]);
                $loginLog = DB::table("login_log")->insert([
                    'user_id' => $new_user->id,
                    'login_time' => $time,
                ]);
                $fb = Social::create([
                    'provider_user_id' => $provider->getId(),
                    'provider' => 'facebook',
                    'user' => $new_user->id
                ]);
                Auth::login($new_user);
                if (auth()->user()->hasRole('admin')) {
                    return redirect()->intended(RouteServiceProvider::HOME);
                } else {
                    return redirect()->intended(RouteServiceProvider::WELCOME);
                }
            }
        }
    }
}