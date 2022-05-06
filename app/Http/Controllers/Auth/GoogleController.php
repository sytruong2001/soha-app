<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Str;
use Laravel\Socialite\Facades\Socialite;
use App\Providers\RouteServiceProvider;
use App\Models\InfoUser;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GoogleController extends Controller
{
    public function login()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $time =  Carbon::now('Asia/Ho_Chi_Minh');
            $google_user = Socialite::driver('google')->user();
            $user = User::where('email', $google_user->email)->first();
            if ($user) {
                $day = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
                $role = DB::table('model_has_roles')->where('role_id', '>', '2')->where('model_id', '=', $user->id)->first();
                $check = DB::table('login_log')->where('user_id', $user->id)->whereDate('login_time', $day)->first();
                if ($check === null && $role) {
                    $loginLog = DB::table("login_log")->insert([
                        'user_id' => $user->id,
                        'login_time' => $time,
                    ]);
                }
                Auth::login($user);

                if (auth()->user()->hasRole('admin')) {
                    return redirect()->intended(RouteServiceProvider::HOME);
                } else {
                    return redirect()->intended(RouteServiceProvider::WELCOME);
                }
            } else {
                $new_user = User::create([
                    'name' => ucwords($google_user->name),
                    'email' => $google_user->email,
                    'email_verified_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
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
                Auth::login($new_user);

                if (auth()->user()->hasRole('admin')) {
                    return redirect()->intended(RouteServiceProvider::HOME);
                } else {
                    return redirect()->intended(RouteServiceProvider::WELCOME);
                }
            }
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}