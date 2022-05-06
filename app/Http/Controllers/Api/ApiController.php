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
}