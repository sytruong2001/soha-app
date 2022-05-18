<?php

namespace App\Http\Controllers;

use App\Models\InfoAdmin as ModelsInfoAdmin;
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
use App\Models\InfoAdmin;
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
            // $account_name = User::where('id', $account->user)->first();
            $id = $account->user;
            $day = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
            $role = $this->auth->hasRole($id);
            $check = DB::table('login_log')->where('user_id', $account->user)->whereDate('login_time', $day)->first();
            if ($check == null && $role) {
                $loginLog = DB::table("login_log")->insert([
                    'user_id' => $account->user,
                    'login_time' => $time,
                ]);
            }
            // nếu là tài khoản user
            // Lấy thông tin người đăng nhập dành cho user
            if ($role) {
                $info = DB::table('info_user')->where('user_id', '=', $account->user)->first();
                // nếu mà có thông tin user trong bảng info_user thì thực hiện gửi otp
                if ($info) {
                    // kiểm tra status có bằng 0 hay không, nếu bằng thì cho gửi otp, nếu không thì đăng nhập luôn
                    if ($info->status == 0) {
                        // Kiểm tra tồn tại thông tin về số điện thoại
                        if ($info->phone != null) {
                            $this->auth->getOTP($info);
                            return view('auth.login-otp', [
                                'info' => $info,
                                'info_phone'  => $info->phone,
                                'id' => $account->user,
                            ]);
                        }
                        return view('auth.login-otp', [
                            'info' => $info,
                            'info_phone'  => $info->phone,
                            'id' => $account->user,
                        ]);
                    } else {
                        $login = User::where('id', '=', $account->user)->first();
                        Auth::login($login);

                        if (auth()->user()->hasRole('admin')) {
                            return redirect()->intended(RouteServiceProvider::HOME);
                        } else if (auth()->user()->hasRole('user')) {
                            return redirect()->intended(RouteServiceProvider::WELCOME);
                        } else {
                            return redirect()->intended(RouteServiceProvider::DIALOG);
                        }
                    }
                } else {
                    $create = InfoUser::create(['user_number' => 'SHA' . Carbon::now()->format('su'), 'phone' => null, 'user_id' => $account->user]);
                    return view('auth.login-otp', [
                        'info' => $create,
                        'info_phone'  => $create->phone,
                        'id' => $account->user,
                    ]);
                }
            } else {
                $info = DB::table('info_admin')->where('user_id', '=', $account->user)->first();
            }
            // Kiểm tra tồn tại thông tin của admin
            if ($info) {
                // Kiểm tra tồn tại thông tin về số điện thoại
                if ($info->phone != null) {
                    $this->auth->getOTP($info);
                    return view('auth.login-otp', [
                        'info' => $info,
                        'info_phone'  => $info->phone,
                        'id' => $account->user,
                    ]);
                }
                return view('auth.login-otp', [
                    'info' => $info,
                    'info_phone'  => $info->phone,
                    'id' => $account->user,
                ]);
            } else {
                $create = InfoAdmin::create(['phone' => null, 'user_id' => $account->user]);
                return view('auth.login-otp', [
                    'info' => $create,
                    'info_phone'  => $create->phone,
                    'id' => $account->user,
                ]);
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
                $day = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
                $check = DB::table('login_log')->where('user_id', $check_email->id)->whereDate('login_time', $day)->first();
                if ($check == null) {
                    $loginLog = DB::table("login_log")->insert([
                        'user_id' => $check_email->id,
                        'login_time' => $time,
                    ]);
                }
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