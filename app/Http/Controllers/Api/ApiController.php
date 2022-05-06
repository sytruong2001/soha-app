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
use LengthException;
use Nette\Utils\Json;
use App\Models\loginLog;
use Illuminate\Support\Facades\Hash;
use App\Models\InfoAdmin;

class ApiController extends Controller
{
    public function updateREV()
    {
        $start_date = Carbon::today()->subDays(6);
        $end_date = Carbon::now()->toDateTimeString();
        $users = logKC::select(DB::raw("SUM(kc_numb)*200 as kc_numb"), DB::raw("Date(mua_kc_time) as day_name"))
            ->whereDate('mua_kc_time', '>=', $start_date)
            ->whereDate('mua_kc_time', '<=', $end_date)
            ->groupBy(DB::raw("Date(mua_kc_time)"))
            ->pluck('kc_numb', 'day_name');

        $labels = $users->keys();

        $data = $users->values();

        return response()->json(compact('labels', 'data', 'users'));
    }
    public function updateNRU()
    {
        $start_date = Carbon::today()->subDays(6);
        $end_date = Carbon::now()->toDateTimeString();
        $users = User::select(DB::raw("COUNT(created_at) as new_user"), DB::raw("Date(created_at) as day_name"))
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->groupBy(DB::raw("Date(created_at)"))
            ->pluck('new_user', 'day_name');
        $labels = $users->keys();
        $data = $users->values();

        return response()->json(['users' => $users, 'labels' => $labels, 'data' => $data]);
    }
    public function updateDAU()
    {
        $start_date = Carbon::today()->subDays(6);
        $end_date = Carbon::now()->toDateTimeString();
        $users = loginLog::select(DB::raw("COUNT(DISTINCT user_id) as user_log"), DB::raw("Date(login_time) as day_log"))
            ->whereDate('login_time', '>=', $start_date)
            ->whereDate('login_time', '<=', $end_date)
            ->groupBy(DB::raw("Date(login_time)"), 'user_id')
            ->pluck('user_log', 'day_log');
        $labels = $users->keys();
        $data = $users->values();

        return response()->json(['users' => $users, 'labels' => $labels, 'data' => $data]);
    }
    public function showDAU(Request $request)
    {
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $users = loginLog::select(DB::raw("COUNT(DISTINCT user_id) as user_log"), DB::raw("Date(login_time) as day_log"))
            ->whereDate('login_time', '>=', $start_date)
            ->whereDate('login_time', '<=', $end_date)
            ->groupBy(DB::raw("Date(login_time)"), 'user_id')
            ->pluck('user_log', 'day_log');

        $labels = $users->keys();
        $data = $users->values();

        return response()->json(['users' => $users, 'labels' => $labels, 'data' => $data]);
    }
    public function showREV(Request $request)
    {
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $users = logKC::select(DB::raw("SUM(kc_numb)*200 as kc_numb"), DB::raw("Date(mua_kc_time) as day_name"))
            ->whereDate('mua_kc_time', '>=', $start_date)
            ->whereDate('mua_kc_time', '<=', $end_date)
            ->groupBy(DB::raw("Date(mua_kc_time)"))
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
        $users = User::select(DB::raw("COUNT(created_at) as new_user"), DB::raw("Date(created_at) as day_name"))
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->groupBy(DB::raw("Date(created_at)"))
            ->pluck('new_user', 'day_name');

        $labels = $users->keys();
        $data = $users->values();
        return response()->json(['users' => $users, 'labels' => $labels, 'data' => $data]);
    }

    // lấy thông tin người dùng
    public function getInfoUser(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::query()->with('info_user')->where('users.id', $id)->first();
        echo json_encode($user);
    }

    // cập nhật thông tin người dùng
    public function updateInfoUser(Request $request)
    {
        $id = Auth::user()->id;
        $name = $request->get('name');
        $DOB = $request->get('date_of_birth');
        $identify_numb = $request->get('identify_numb');
        $phone = $request->get('phone');
        $region = $request->get('region');
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
        $json['success'] = "Cập nhật thành công";
        $json['code'] = 200;
        echo json_encode($json);
    }
    // lấy thông tin về số lượng coin và kc
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
        $createNapCoinLog = DB::table('nap_coin_log')->insert([ // thêm dữ liệu vào bảng log mua kc
            'user_id' => $id,
            'coin_numb' => $coin,
            'nap_coin_time' => $time,
        ]);
        $json['success'] = "Nạp coin thành công!";
        $json['code'] = 200;
        echo json_encode($json);
    }

    public function UpdateKC(Request $request)
    {
        $time =  Carbon::now('Asia/Ho_Chi_Minh');
        $id = Auth::user()->id;
        $kc = $request->get('kc'); //lấy số kc được mua
        $checkData = DB::table("info_user") // lấy số coin hiện tại
            ->where('user_id', $id)
            ->select('coin')->first();
        $coin = $checkData->coin;
        $passCoin = $coin - ($kc / 5); // số coin còn lại
        $data = DB::table("info_user") // lưu dữ liệu vào bảng info_user
            ->where('user_id', $id)
            ->update([
                "coin" => $passCoin,
            ]);
        $checkInfoKc = DB::table("info_kc")->where('user_id', $id)->select('kc_numb')->first(); // kiểm tra xem có tồn tại kc của người dùng hay không?
        if ($checkInfoKc) { // nếu có thì cập nhật
            $KC = $checkInfoKc->kc_numb;
            $Kc_numb_current = $KC + $kc;
            $updateKC = DB::table("info_kc") // cập nhật dữ liệu bảng info_kc
                ->where('user_id', $id)
                ->update([
                    "kc_numb" => $Kc_numb_current,
                ]);
            $createLogKc = DB::table('mua_kc_log')->insert([ // thêm dữ liệu vào bảng log mua kc
                'user_id' => $id,
                'kc_numb' => $kc,
                'mua_kc_time' => $time,
            ]);
        } else { // nếu không thì tạo mới
            $createKC = DB::table("info_kc")->insert([ // thêm dữ liệu vào bảng info_kc
                'user_id' => $id,
                'kc_numb' => $kc,
            ]);
            $createLogKc = DB::table('mua_kc_log')->insert([ // thêm dữ liệu vào bảng log mua kc
                'user_id' => $id,
                'kc_numb' => $kc,
                'mua_kc_time' => $time,
            ]);
        }
        $json['success'] = "Mua Kim Cương thành công!";
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
                        $json['message'] = "Dữ liệu gửi vào chính xác, xin chờ trong giây lát.";
                        echo json_encode($json);
                    } else {
                        $json['code'] = 202;
                        $json['error'] = "Nhập sai lần nạp 1";
                        echo json_encode($json);
                    }
                } else if ($count == 2) {
                    if ($first == $check_buy_coin[0]->day_name && $first_money == $check_buy_coin[0]->coin * 1000 && $second == $check_buy_coin[1]->day_name && $second_money == $check_buy_coin[1]->coin * 1000) {
                        $json['id'] = $check_email->id;
                        $json['code'] = 200;
                        $json['message'] = "Dữ liệu gửi vào chính xác, xin chờ trong giây lát.";
                        echo json_encode($json);
                    } else if ($first != $check_buy_coin[0]->day_name || $first_money != $check_buy_coin[0]->coin * 1000) {
                        $json['code'] = 202;
                        $json['error'] = "Nhập sai lần nạp 1";
                        echo json_encode($json);
                    } else if ($second != $check_buy_coin[1]->day_name || $second_money != $check_buy_coin[1]->coin * 1000) {
                        $json['code'] = 202;
                        $json['error'] = "Nhập sai lần nạp 2";
                        echo json_encode($json);
                    }
                } else if ($count == 3) {
                    if ($first == $check_buy_coin[0]->day_name && $first_money == $check_buy_coin[0]->coin * 1000 && $second == $check_buy_coin[1]->day_name && $second_money == $check_buy_coin[1]->coin * 1000 && $third == $check_buy_coin[2]->day_name && $third_money == $check_buy_coin[2]->coin * 1000) {
                        $json['id'] = $check_email->id;
                        $json['code'] = 200;
                        $json['message'] = "Dữ liệu gửi vào chính xác, xin chờ trong giây lát.";
                        echo json_encode($json);
                    } else if ($first != $check_buy_coin[0]->day_name || $first_money != $check_buy_coin[0]->coin * 1000) {
                        $json['code'] = 202;
                        $json['error'] = "Nhập sai lần nạp 1";
                        echo json_encode($json);
                    } else if ($second != $check_buy_coin[1]->day_name || $second_money != $check_buy_coin[1]->coin * 1000) {
                        $json['code'] = 202;
                        $json['error'] = "Nhập sai lần nạp 2";
                        echo json_encode($json);
                    } else if ($third != $check_buy_coin[2]->day_name || $third_money != $check_buy_coin[2]->coin * 1000) {
                        $json['code'] = 202;
                        $json['error'] = "Nhập sai lần nạp 3";
                        echo json_encode($json);
                    }
                } else {
                    if ($first == $check_buy_coin[0]->day_name && $first_money == $check_buy_coin[0]->coin * 1000 && $second == $check_buy_coin[1]->day_name && $second_money == $check_buy_coin[1]->coin * 1000 && $third == $check_buy_coin[2]->day_name && $third_money == $check_buy_coin[2]->coin * 1000) {
                        $json['id'] = $check_email->id;
                        $json['code'] = 200;
                        $json['message'] = "Dữ liệu gửi vào chính xác, xin chờ trong giây lát.";
                        echo json_encode($json);
                    } else if ($first != $check_buy_coin[0]->day_name || $first_money != $check_buy_coin[0]->coin * 1000) {
                        $json['code'] = 202;
                        $json['error'] = "Nhập sai lần nạp 1";
                        echo json_encode($json);
                    } else if ($second != $check_buy_coin[1]->day_name || $second_money != $check_buy_coin[1]->coin * 1000) {
                        $json['code'] = 202;
                        $json['error'] = "Nhập sai lần nạp 2";
                        echo json_encode($json);
                    } else if ($third != $check_buy_coin[2]->day_name || $third_money != $check_buy_coin[2]->coin * 1000) {
                        $json['code'] = 202;
                        $json['error'] = "Nhập sai lần nạp 3";
                        echo json_encode($json);
                    }
                }
            } else {
                $json['code'] = 201;
                $json['error'] = "Sai số chứng minh thư nhân dân/CCCD";
                echo json_encode($json);
            }
        } else {
            $json['code'] = 201;
            $json['error'] = "Sai địa chỉ email";
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
                return response()->json(['status' => 0, 'msg' => 'Lỗi.']);
            } else {
                return response()->json(['status' => 1, 'msg' => 'Sửa thành công.']);
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
                        return $fail(__('Mật khẩu không đúng'));
                    }
                },
                'min:7',
                'max:30'
            ],
            'new_pass' => 'required|min:7|max:30',
            're_new_pass' => 'required|same:new_pass'
        ], [
            'old_pass.required' => 'Nhập mật khẩu hiện tại',
            'old_pass.min' => 'Mật khẩu yêu cầu 8 ký tự trở lên',
            'new_pass.required' => 'Nhập mật khẩu mới',
            'new_pass.min' => 'Mật khẩu yêu cầu 8 ký tự trở lên',
            're_new_pass.required' => 'Xác nhận mật khẩu mới',
            're_new_pass.same' => 'Mật khẩu không khớp với mật khẩu mới'
        ]);
        if (!$validator->passes()) {

            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {

            $update = User::find(Auth::user()->id)->update(['password' => \Hash::make($request->new_pass)]);

            if (!$update) {
                return response()->json(['status' => 0, 'msg' => 'Đổi mật khẩu thất bại']);
            } else {
                return response()->json(['status' => 1, 'msg' => 'Đổi mật khẩu thành công']);
            }
        }
    }
}