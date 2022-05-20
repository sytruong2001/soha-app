<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Providers\RouteServiceProvider;
use App\Models\InfoUser;
use App\Models\InfoAdmin;
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
            $day = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
            $google_user = Socialite::driver('google')->user();
            $user = User::where('email', $google_user->email)->first();
            if ($user) {
                $id = $user->id;
                $role = $this->auth->hasRole($id);
                $check = DB::table('login_log')->where('user_id', $user->id)->whereDate('login_time', $day)->first();
                if ($check === null && $role) {
                    $loginLog = DB::table("login_log")->insert([
                        'user_id' => $user->id,
                        'login_time' => $day,
                    ]);
                }
                
                if ($role) {
                    $info = DB::table('info_user')->where('user_id', '=', $id)->first();
                    // dd($info);
                    if ($info) {
                        if ($info->status == 0) {
                            // Kiểm tra tồn tại thông tin về số điện thoại
                            if ($info->phone != null) {
                                $this->auth->getOTP($info);
                                return view('auth.login-otp', [
                                    'info' => $info,
                                    'info_phone'  => $info->phone,
                                    'id' => $id,
                                ]);
                            }
                            return view('auth.login-otp', [
                                'info' => $info,
                                'info_phone'  => $info->phone,
                                'id' => $id,
                            ]);
                        } else {
                            Auth::login($user);

                            if (auth()->user()->hasRole('admin')) {
                                return redirect()->intended(RouteServiceProvider::HOME);
                            } else if (auth()->user()->hasRole('user')) {
                                return redirect()->intended(RouteServiceProvider::WELCOME);
                            } else {
                                return redirect()->intended(RouteServiceProvider::DIALOG);
                            }
                        }
                    } else {
                        $create = InfoUser::create(['phone' => null, 'user_id' => $id]);
                        return view('auth.login-otp', [
                            'info' => $create,
                            'info_phone'  => $create->phone,
                            'id' => $id,
                        ]);

                    }
                } else {
                    $info = DB::table('info_admin')->where('user_id', '=', $id)->first();
                }
                if ($info) {
                    // Kiểm tra tồn tại thông tin về số điện thoại

                    if ($info->phone != null) {
                        $this->auth->getOTP($info);
                        return view('auth.login-otp', [
                            'info' => $info,
                            'info_phone'  => $info->phone,
                            'id' => $id,
                        ]);
                    }
                    return view('auth.login-otp', [
                        'info' => $info,
                        'info_phone'  => $info->phone,
                        'id' => $id,
                    ]);
                } else {
                    $create = InfoAdmin::create(['phone' => null, 'user_id' => $id]);
                    return view('auth.login-otp', [
                        'info' => $create,
                        'info_phone'  => $create->phone,
                        'id' => $id,
                    ]);
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
                    'login_time' => $day,
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