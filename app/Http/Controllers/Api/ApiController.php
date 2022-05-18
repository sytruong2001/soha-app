<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\InfoAdmin;
use App\Models\InfoUser;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Services\StatisticService;
use Illuminate\Support\Facades\Redis;

class ApiController extends Controller
{
    private $statictis;
    public function __construct(StatisticService $statictis)
    {
        $this->statictis = $statictis;
    }
    public function showREV(Request $request)
    {
        $start_date = $this->statictis->get_start_date($request);
        $end_date = $this->statictis->get_end_date($request);
        $result = $this->statictis->get_info_rev($start_date, $end_date);
        return response()->json(['result' => $result]);
    }
    public function showNRU(Request $request)
    {
        $start_date = $this->statictis->get_start_date($request);
        $end_date = $this->statictis->get_end_date($request);
        $result = $this->statictis->get_info_nru($start_date, $end_date);
        return response()->json(['result' => $result]);
    }
    public function showDAU(Request $request)
    {
        $start_date = $this->statictis->get_start_date($request);
        $end_date = $this->statictis->get_end_date($request);
        $result = $this->statictis->get_info_dau($start_date, $end_date);
        return response()->json(['result' => $result]);
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
        $role = DB::table('model_has_roles')->where('role_id', '>', '2')->where('model_id', '=', $id)->first();
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
}