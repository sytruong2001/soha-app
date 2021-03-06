<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\logCoin;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\logKC;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\InfoAdmin;
use App\Models\InfoUser;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\RevDaily;
use App\Models\DauDaily;
use App\Models\NruDaily;
use Illuminate\Support\Facades\Redis;

class ApiController extends Controller
{
    public function updateREV()
    {
        $start_date = Carbon::today()->subDays(6);
        $end_date = Carbon::now()->toDateTimeString();
        $users = RevDaily::select(DB::raw("(total_kc)*200 as kc_numb"), DB::raw("DATE_FORMAT(date, '%d-%m') as day_name"))
            ->whereDate('date', '>=', $start_date)
            ->whereDate('date', '<=', $end_date)
            // ->groupBy(DB::raw("Date(date)"))
            ->pluck('kc_numb', 'day_name');

        $labels = $users->keys();

        $data = $users->values();

        return response()->json(compact('labels', 'data', 'users'));
    }
    public function updateNRU()
    {
        $start_date = Carbon::today()->subDays(6);
        $end_date = Carbon::now()->toDateTimeString();
        $users = NruDaily::select(DB::raw("total_register as new_user"), DB::raw("DATE_FORMAT(date, '%d-%m') as day_name"))
            ->whereDate('date', '>=', $start_date)
            ->whereDate('date', '<=', $end_date)
            // ->groupBy(DB::raw("Date(date)"))
            ->pluck('new_user', 'day_name');
        $labels = $users->keys();
        $data = $users->values();

        return response()->json(['users' => $users, 'labels' => $labels, 'data' => $data]);
    }
    public function updateDAU()
    {
        $start_date = Carbon::today()->subDays(6);
        $end_date = Carbon::now()->toDateTimeString();
        $users = DauDaily::select(DB::raw("total_login as user_log"), DB::raw("DATE_FORMAT(date, '%d-%m') as day_log"))
            ->whereDate('date', '>=', $start_date)
            ->whereDate('date', '<=', $end_date)
            // ->groupBy(DB::raw("Date(login_time)"))
            ->pluck('user_log', 'day_log');
        $labels = $users->keys();
        $data = $users->values();

        return response()->json(['users' => $users, 'labels' => $labels, 'data' => $data]);
    }
    public function showDAU(Request $request)
    {
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $users = DauDaily::select(DB::raw("total_login as user_log"), DB::raw("DATE_FORMAT(date, '%d-%m') as day_log"))
            ->whereDate('date', '>=', $start_date)
            ->whereDate('date', '<=', $end_date)
            // ->groupBy(DB::raw("Date(login_time)"))
            ->pluck('user_log', 'day_log');

        $labels = $users->keys();
        $data = $users->values();

        return response()->json(['users' => $users, 'labels' => $labels, 'data' => $data]);
    }
    public function showREV(Request $request)
    {
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $users = RevDaily::select(DB::raw("(total_kc)*200 as kc_numb"), DB::raw("DATE_FORMAT(date, '%d-%m') as day_name"))
            ->whereDate('date', '>=', $start_date)
            ->whereDate('date', '<=', $end_date)
            // ->groupBy(DB::raw("Date(date)"))
            ->pluck('kc_numb', 'day_name');

        $labels = $users->keys();
        $data = $users->values();

        return response()->json(['users' => $users, 'labels' => $labels, 'data' => $data]);
    }

    public function showNRU(Request $request)
    {
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        //    dd($end_date);
        $users = NruDaily::select(DB::raw("total_register as new_user"), DB::raw("DATE_FORMAT(date, '%d-%m') as day_name"))
            ->whereDate('date', '>=', $start_date)
            ->whereDate('date', '<=', $end_date)
            // ->groupBy(DB::raw("Date(date)"))
            ->pluck('new_user', 'day_name');

        $labels = $users->keys();
        $data = $users->values();
        return response()->json(['users' => $users, 'labels' => $labels, 'data' => $data]);
    }

    // l???y th??ng tin ng?????i d??ng
    public function getInfoUser(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::query()->with('info_user')->where('users.id', $id)->first();
        echo json_encode($user);
    }

    // c???p nh???t th??ng tin ng?????i d??ng
    public function updateInfoUser(Request $request)
    {
        $id = Auth::user()->id;
        $name = $request->get('name');
        $DOB = $request->get('date_of_birth');
        $identify_numb = $request->get('identify_numb');
        $phone = $request->get('phone');
        $region = $request->get('region');
        $check_phone = DB::table('info_user')->where('phone', $phone)->where('user_id', '<>', $id)->count();
        if ($check_phone == 0) {
            $data = DB::table("info_user")
                ->where('user_id', $id)
                ->update([
                    "identify_numb" => $identify_numb,
                    "phone" => $phone,
                    "region" => $region,
                    "date_of_birth" => $DOB,
                ]);
            $saveName = DB::table("users")
                ->where('id', $id)
                ->update([
                    'name' => $name,
                ]);
            $json['success'] = "C???p nh???t th??nh c??ng";
            $json['code'] = 200;
            echo json_encode($json);
        } else {
            $json['success'] = "S??? ??i???n tho???i ???? t???n t???i";
            $json['code'] = 401;
            echo json_encode($json);
        }
    }
    // l???y th??ng tin v??? s??? l?????ng coin v?? kc
    public function getInfoPayment(Request $request)
    {
        $id = Auth::user()->id;
        $payment = User::query()->with('info_user', 'info_kc', 'logKc', 'logCoin')->where('users.id', $id)->first();
        $logKc = logKC::query()->where('user_id', $id)->orderBy('user_id', 'desc')->paginate(3);
        $logCoin = logCoin::query()->where('user_id', $id)->paginate(3);
        $json['payment'] = $payment;
        $json['logKc'] = $logKc;
        $json['logCoin'] = $logCoin;
        echo json_encode($json);
    }

    public function UpdatePayment(Request $request)
    {
        $time =  Carbon::now('Asia/Ho_Chi_Minh');
        $id = Auth::user()->id;
        $coin = $request->get('coin');
        $checkData = DB::table("info_user")
            ->where('user_id', $id)
            ->select('coin')->first();
        $passCoin = $checkData->coin;
        $data = DB::table("info_user")
            ->where('user_id', $id)
            ->update([
                "coin" => $passCoin + $coin,
            ]);
        $createNapCoinLog = DB::table('nap_coin_log')->insert([ // th??m d??? li???u v??o b???ng log mua kc
            'user_id' => $id,
            'coin_numb' => $coin,
            'nap_coin_time' => $time,
        ]);
        $json['success'] = "N???p coin th??nh c??ng!";
        $json['code'] = 200;
        echo json_encode($json);
    }

    public function UpdateKC(Request $request)
    {
        $time =  Carbon::now('Asia/Ho_Chi_Minh');
        $id = Auth::user()->id;
        $kc = $request->get('kc'); //l???y s??? kc ???????c mua
        $checkData = DB::table("info_user") // l???y s??? coin hi???n t???i
            ->where('user_id', $id)
            ->select('coin')->first();
        $coin = $checkData->coin;
        $passCoin = $coin - ($kc / 5); // s??? coin c??n l???i
        $data = DB::table("info_user") // l??u d??? li???u v??o b???ng info_user
            ->where('user_id', $id)
            ->update([
                "coin" => $passCoin,
            ]);
        $checkInfoKc = DB::table("info_kc")->where('user_id', $id)->select('kc_numb')->first(); // ki???m tra xem c?? t???n t???i kc c???a ng?????i d??ng hay kh??ng?
        if ($checkInfoKc) { // n???u c?? th?? c???p nh???t
            $KC = $checkInfoKc->kc_numb;
            $Kc_numb_current = $KC + $kc;
            $updateKC = DB::table("info_kc") // c???p nh???t d??? li???u b???ng info_kc
                ->where('user_id', $id)
                ->update([
                    "kc_numb" => $Kc_numb_current,
                ]);
            $createLogKc = DB::table('mua_kc_log')->insert([ // th??m d??? li???u v??o b???ng log mua kc
                'user_id' => $id,
                'kc_numb' => $kc,
                'mua_kc_time' => $time,
            ]);
        } else { // n???u kh??ng th?? t???o m???i
            $createKC = DB::table("info_kc")->insert([ // th??m d??? li???u v??o b???ng info_kc
                'user_id' => $id,
                'kc_numb' => $kc,
            ]);
            $createLogKc = DB::table('mua_kc_log')->insert([ // th??m d??? li???u v??o b???ng log mua kc
                'user_id' => $id,
                'kc_numb' => $kc,
                'mua_kc_time' => $time,
            ]);
        }
        $json['success'] = "Mua Kim C????ng th??nh c??ng!";
        $json['code'] = 200;
        echo json_encode($json);
    }

    public function CSKH(Request $request)
    {
        $email = $request->get('email');
        $identify_numb = $request->get('identify_numb');
        $first = $request->get('first');
        $first_money = $request->get('first_money');
        $second = $request->get('second');
        $second_money = $request->get('second_money');
        $third = $request->get('third');
        $third_money = $request->get('third_money');
        $check_email = User::where('email', $email)->first();
        if ($check_email) {
            $check_identify_numb = DB::table('info_user')->where('user_id', $check_email->id)->where('identify_numb', $identify_numb)->first();
            if ($check_identify_numb) {
                $check_buy_coin = DB::table('nap_coin_log')->where('user_id', $check_email->id)->orderByDesc('id')->select(DB::raw("Date(nap_coin_time) as day_name, coin_numb as coin"))->get();
                $count = $check_buy_coin->count();
                if ($count == 1) {
                    if ($first == $check_buy_coin->day_name && $first_money == $check_buy_coin->coin * 1000) {
                        $json['id'] = $check_email->id;
                        $json['code'] = 200;
                        $json['message'] = "D??? li???u g???i v??o ch??nh x??c, xin ch??? trong gi??y l??t.";
                        echo json_encode($json);
                    } else {
                        $json['code'] = 202;
                        $json['error'] = "Nh???p sai l???n n???p 1";
                        echo json_encode($json);
                    }
                } else if ($count == 2) {
                    if ($first == $check_buy_coin[0]->day_name && $first_money == $check_buy_coin[0]->coin * 1000 && $second == $check_buy_coin[1]->day_name && $second_money == $check_buy_coin[1]->coin * 1000) {
                        $json['id'] = $check_email->id;
                        $json['code'] = 200;
                        $json['message'] = "D??? li???u g???i v??o ch??nh x??c, xin ch??? trong gi??y l??t.";
                        echo json_encode($json);
                    } else if ($first != $check_buy_coin[0]->day_name || $first_money != $check_buy_coin[0]->coin * 1000) {
                        $json['code'] = 202;
                        $json['error'] = "Nh???p sai l???n n???p 1";
                        echo json_encode($json);
                    } else if ($second != $check_buy_coin[1]->day_name || $second_money != $check_buy_coin[1]->coin * 1000) {
                        $json['code'] = 202;
                        $json['error'] = "Nh???p sai l???n n???p 2";
                        echo json_encode($json);
                    }
                } else if ($count == 3) {
                    if ($first == $check_buy_coin[0]->day_name && $first_money == $check_buy_coin[0]->coin * 1000 && $second == $check_buy_coin[1]->day_name && $second_money == $check_buy_coin[1]->coin * 1000 && $third == $check_buy_coin[2]->day_name && $third_money == $check_buy_coin[2]->coin * 1000) {
                        $json['id'] = $check_email->id;
                        $json['code'] = 200;
                        $json['message'] = "D??? li???u g???i v??o ch??nh x??c, xin ch??? trong gi??y l??t.";
                        echo json_encode($json);
                    } else if ($first != $check_buy_coin[0]->day_name || $first_money != $check_buy_coin[0]->coin * 1000) {
                        $json['code'] = 202;
                        $json['error'] = "Nh???p sai l???n n???p 1";
                        echo json_encode($json);
                    } else if ($second != $check_buy_coin[1]->day_name || $second_money != $check_buy_coin[1]->coin * 1000) {
                        $json['code'] = 202;
                        $json['error'] = "Nh???p sai l???n n???p 2";
                        echo json_encode($json);
                    } else if ($third != $check_buy_coin[2]->day_name || $third_money != $check_buy_coin[2]->coin * 1000) {
                        $json['code'] = 202;
                        $json['error'] = "Nh???p sai l???n n???p 3";
                        echo json_encode($json);
                    }
                } else {
                    if ($first == $check_buy_coin[0]->day_name && $first_money == $check_buy_coin[0]->coin * 1000 && $second == $check_buy_coin[1]->day_name && $second_money == $check_buy_coin[1]->coin * 1000 && $third == $check_buy_coin[2]->day_name && $third_money == $check_buy_coin[2]->coin * 1000) {
                        $json['id'] = $check_email->id;
                        $json['code'] = 200;
                        $json['message'] = "D??? li???u g???i v??o ch??nh x??c, xin ch??? trong gi??y l??t.";
                        echo json_encode($json);
                    } else if ($first != $check_buy_coin[0]->day_name || $first_money != $check_buy_coin[0]->coin * 1000) {
                        $json['code'] = 202;
                        $json['error'] = "Nh???p sai l???n n???p 1";
                        echo json_encode($json);
                    } else if ($second != $check_buy_coin[1]->day_name || $second_money != $check_buy_coin[1]->coin * 1000) {
                        $json['code'] = 202;
                        $json['error'] = "Nh???p sai l???n n???p 2";
                        echo json_encode($json);
                    } else if ($third != $check_buy_coin[2]->day_name || $third_money != $check_buy_coin[2]->coin * 1000) {
                        $json['code'] = 202;
                        $json['error'] = "Nh???p sai l???n n???p 3";
                        echo json_encode($json);
                    }
                }
            } else {
                $json['code'] = 201;
                $json['error'] = "Sai s??? ch???ng minh th?? nh??n d??n/CCCD";
                echo json_encode($json);
            }
        } else {
            $json['code'] = 201;
            $json['error'] = "Sai ?????a ch??? email";
            echo json_encode($json);
        }
    }

    function changeInfo(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'phone' => ['required', 'min:11',],
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $query = User::find(Auth::user()->id)->update([
                'name' => $request->name,
            ]);
            $info_user = InfoAdmin::find(Auth::user()->id)->update([
                'phone' => $request->phone,
            ]);

            if (!$query && !$info_user) {
                return response()->json(['status' => 0, 'msg' => 'L???i.']);
            } else {
                return response()->json(['status' => 1, 'msg' => 'S???a th??nh c??ng.']);
            }
        }
    }
    function changePassword(Request $request)
    {
        //Validate form

        $validator = \Validator::make($request->all(), [
            'old_pass' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        return $fail(__('M???t kh???u kh??ng ????ng'));
                    }
                },
                'min:7',
                'max:30'
            ],
            'new_pass' => 'required|min:7|max:30',
            're_new_pass' => 'required|same:new_pass'
        ], [
            'old_pass.required' => 'Nh???p m???t kh???u hi???n t???i',
            'old_pass.min' => 'M???t kh???u y??u c???u 8 k?? t??? tr??? l??n',
            'new_pass.required' => 'Nh???p m???t kh???u m???i',
            'new_pass.min' => 'M???t kh???u y??u c???u 8 k?? t??? tr??? l??n',
            're_new_pass.required' => 'X??c nh???n m???t kh???u m???i',
            're_new_pass.same' => 'M???t kh???u kh??ng kh???p v???i m???t kh???u m???i'
        ]);
        if (!$validator->passes()) {

            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {

            $update = User::find(Auth::user()->id)->update(['password' => \Hash::make($request->new_pass)]);

            if (!$update) {
                return response()->json(['status' => 0, 'msg' => '?????i m???t kh???u th???t b???i']);
            } else {
                return response()->json(['status' => 1, 'msg' => '?????i m???t kh???u th??nh c??ng']);
            }
        }
    }

    public function phone(Request $rq)
    {
        $id = $rq->id;
        // dd($id);
        // Ki???m tra ph??n quy???n v?? th??ng tin nh???p v??o
        $role = DB::table('model_has_roles')->where('role_id', '>', '2')->where('model_id', '=', $id)->first();
        $validator = \Validator::make($rq->all(), [
            'phone' => ['required', 'min:10', 'unique:info_admin', 'unique:info_user'],
        ], [
            'phone.required' => 'Kh??ng ???????c b??? tr???ng',
            'phone.unique' => 'S??? ??i???n tho???i ???? ???????c s??? d???ng',
        ]);
        if (!$validator->passes()) {

            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            // Ki???m tra t???n t???i s??? ??i???n tho???i c???a ng?????i d??ng
            if ($role) {
                $find = InfoUser::query()->where('user_id', '=', $id)->first();
                // dd($find);
                if ($find) {
                    $update = InfoUser::where('user_id', '=', $id)->update(['phone' => $rq->phone]);
                }
            } else {
                $find = InfoAdmin::query()->where('user_id', '=', $id)->first();
                // dd($find);
                if ($find) {
                    $update = InfoAdmin::where('user_id', '=', $id)->update(['phone' => $rq->phone]);
                } else {
                    $create = InfoAdmin::create(['phone' => $rq->phone, 'user_id' => $id]);
                }
            }
            $time =  Carbon::now('Asia/Ho_Chi_Minh');
            $time_expire =  Carbon::now('Asia/Ho_Chi_Minh')->addMinutes(5);
            $otp = rand(100000, 999999);
            Redis::set('otp', $otp, 'EX', 300);
            // $add_otp = Otp::create(['otp' => $otp, 'user_id' => $id, 'created_at' => $time, 'updated_at' => $time_expire]);
            $message = "M?? OTP c???a b???n l??:\n"
                . "$otp"
                . " th???i gian s??? d???ng l?? 5 ph??t\n";
            // dd($message);
            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHANNEL_ID', ''),
                'parse_mode' => 'HTML',
                'text' => $message
            ]);
            return response()->json(['status' => 1]);
        }
    }
    public function changePasswordUser(Request $request)
    {
        $email = $request->get('email');
        $repassword = $request->get('repassword');
        $password = $request->get('password');
        $password_confirmation = $request->get('password_confirmation');
        if ($password_confirmation !== $password) {
            $json['error'] = "Kh??ng kh???p v???i m???t kh???u m???i";
            $json['code'] = 400;
            echo json_encode($json);
        } else {
            $checkInfo = User::where('email', $email)->select('password')->first();
            if (Hash::check($repassword, $checkInfo->password)) {
                $data = User::where('email', $email)->update([
                    'password' => Hash::make($password)
                ]);
                $json['message'] = "Thay ?????i m???t kh???u th??nh c??ng";
                $json['code'] = 200;
                echo json_encode($json);
            } else {
                $json['error'] = "Sai m???t kh???u";
                $json['code'] = 401;
                echo json_encode($json);
            }
        }
    }
    public function getPhoneUser(Request $request)
    {
        $id = Auth::user()->id;
        if ($request->get('phone')) {
            $phone = $request->get('phone');
            $phone_check = InfoUser::where('user_id', '=', $id)->where('phone', '=', $phone)->first();
            if ($phone_check) {
                $otp = rand(100000, 999999);
                Redis::set('otp', $otp, 'EX', 300);
                $message = "M?? OTP c???a b???n l??:\n"
                    . "$otp"
                    . " th???i gian s??? d???ng l?? 5 ph??t\n";
                // dd($message);
                Telegram::sendMessage([
                    'chat_id' => env('TELEGRAM_CHANNEL_ID', ''),
                    'parse_mode' => 'HTML',
                    'text' => $message
                ]);
                $json['status'] = $request->get('status');
                $json['code'] = 200;
                echo json_encode($json);
            } else {
                $json['code'] = 401;
                $json['error'] = 'Sai s??? ??i???n tho???i';
                echo json_encode($json);
            }
        } else {
            $select = InfoUser::where('user_id', '=', $id)->select('status')->first();
            echo json_encode($select);
        }
    }
    public function sendAuthen(Request $request)
    {
        $id = Auth::user()->id;
        if ($request->get('otp')) {
            $otp = $request->get('otp');
            $status = $request->get('status');
            $cache = Redis::get('otp');
            if ($otp == $cache) {
                // if ($log) {
                $update = InfoUser::where('user_id', '=', $id)->update(['status' => $status]);
                $json['code'] = 200;
                $json['message'] = "Thay ?????i th??nh c??ng";
                echo json_encode($json);
            } else {
                $json['code'] = 401;
                $json['error'] = "M?? code sai ho???c ???? h???t h???n";
                echo json_encode($json);
            }
        } else {
            $status = InfoUser::where('user_id', '=', $id)->select('status')->first();
            echo json_encode($status);
        }
    }
}