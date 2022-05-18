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
use Illuminate\Support\Facades\Redis;
use App\Services\ChartService;


class ApiController extends Controller
{
    public function updateDAU(Request $request)
    {
        $date = $this->chart->getDateRequest($request);
        $charts = $this->chart->showDAU($date); 
        $entries = $this->chart->getChartReport($charts);

        return response()->json(['charts' => $charts, 'entries' => $entries]);
    }
    public function updateREV(Request $request)
    {
        $date = $this->chart->getDateRequest($request);
        $charts = $this->chart->showREV($date); 
        $entries = $this->chart->getChartReport($charts);

        return response()->json(['charts' => $charts, 'entries' => $entries]);
    }

    public function updateNRU(Request $request)
    {
        $date = $this->chart->getDateRequest($request);
        $charts = $this->chart->showNRU($date);
        $entries = $this->chart->getChartReport($charts);

        return response()->json(['charts' => $charts, 'entries' => $entries]);
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
            $json['success'] = "Cập nhật thành công";
            $json['code'] = 200;
            echo json_encode($json);
        } else {
            $json['success'] = "Số điện thoại đã tồn tại";
            $json['code'] = 401;
            echo json_encode($json);
        }
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

    public function phone(Request $rq)
    {
        $id = $rq->id;
        // dd($id);
        // Kiểm tra phân quyền và thông tin nhập vào
        $role = $this->auth->hasRole($id);
        $validator = \Validator::make($rq->all(), [
            'phone' => ['required', 'min:10', 'unique:info_admin', 'unique:info_user'],
        ], [
            'phone.required' => 'Không được bỏ trống',
            'phone.unique' => 'Số điện thoại đã được sử dụng',
        ]);
        if (!$validator->passes()) {

            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            // Kiểm tra tồn tại số điện thoại của người dùng
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
            $message = "Mã OTP của bạn là:\n"
                . "$otp"
                . " thời gian sử dụng là 5 phút\n";
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
            $json['error'] = "Không khớp với mật khẩu mới";
            $json['code'] = 400;
            echo json_encode($json);
        } else {
            $checkInfo = User::where('email', $email)->select('password')->first();
            if (Hash::check($repassword, $checkInfo->password)) {
                $data = User::where('email', $email)->update([
                    'password' => Hash::make($password)
                ]);
                $json['message'] = "Thay đổi mật khẩu thành công";
                $json['code'] = 200;
                echo json_encode($json);
            } else {
                $json['error'] = "Sai mật khẩu";
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
                $message = "Mã OTP của bạn là:\n"
                    . "$otp"
                    . " thời gian sử dụng là 5 phút\n";
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
                $json['error'] = 'Sai số điện thoại';
                echo json_encode($json);
            }
        } else {
            $select = InfoUser::where('user_id', '=', $id)->select('status')->first();
            echo json_encode($select);
        }
    }
    public function reSend(Request $request)
    {
        $id = $request->id;
        $role = $this->auth->hasRole($id);
        if ($role) {
            $info = DB::table('info_user')->where('user_id', '=', $id)->first();
        } else {
            $info = DB::table('info_admin')->where('user_id', '=', $id)->first();
        }
        $otp = rand(100000, 999999);

        Redis::set('otp', $otp, 'EX', 300);
        $message = "Mã OTP của bạn là:\n"
            . "$otp"
            . " thời gian sử dụng là 5 phút\n";
        if ($info->telegram_id) {
            Telegram::sendMessage([
                'chat_id' => $info->telegram_id,
                'parse_mode' => 'HTML',
                'text' => $message
            ]);
        } else {
            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHANNEL_ID', ''),
                'parse_mode' => 'HTML',
                'text' => $message
            ]);
        }
        return response()->json(['status' => 1]);
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
                $json['message'] = "Thay đổi thành công";
                echo json_encode($json);
            } else {
                $json['code'] = 401;
                $json['error'] = "Mã code sai hoặc đã hết hạn";
                echo json_encode($json);
            }
        } else {
            $status = InfoUser::where('user_id', '=', $id)->select('status')->first();
            echo json_encode($status);
        }
    }
}