<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Str;
use Laravel\Socialite\Facades\Socialite;
use App\Providers\RouteServiceProvider;
use App\Models\InfoUser;
use Carbon\Carbon;

class GoogleController extends Controller
{
    public function login()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $google_user = Socialite::driver('google')->user();
            $user = User::where('email', $google_user->email)->first();

            if ($user) {
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