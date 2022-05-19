<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\InfoUser;
use App\Repositories\Locked\LockedRepositoryInterface;
use App\Repositories\InfoUser\InfoUserRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\ReqService;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class ApiUserController extends Controller
{
    private $req;
    private $lockedRepository;
    private $userRepository;
    private $infoUserRepository;
    public function __construct(ReqService $req, LockedRepositoryInterface $lockedRepository, UserRepositoryInterface $userRepository, InfoUserRepositoryInterface $infoUserRepository)
    {
        $this->req = $req;
        $this->lockedRepository = $lockedRepository;
        $this->userRepository = $userRepository;
        $this->infoUserRepository = $infoUserRepository;
    }
    // lấy thông tin người dùng
    public function getInfoUser(Request $request)
    {
        $id = Auth::user()->id;
        $user = $this->userRepository->get_with_info_user($id);
        echo json_encode($user);
    }

    // cập nhật thông tin người dùng
    public function updateInfoUser(Request $request, $id)
    {
        $data = $request->all();
        $user_id = Auth::user()->id;
        $name = $request->get('name');
        $phone = $request->get('phone');
        $check_phone = DB::table('info_user')->where('phone', $phone)->where('user_id', '<>', $user_id)->count();
        if ($check_phone == 0) {
            $update_info_user = $this->infoUserRepository->update($id, $data);
            $name_user = ['name' => $name];
            $update_user = $this->userRepository->update($user_id, $name_user);
            $json['success'] = "Cập nhật thành công";
            $json['code'] = 200;
            echo json_encode($json);
        } else {
            $json['success'] = "Số điện thoại đã tồn tại";
            $json['code'] = 401;
            echo json_encode($json);
        }
    }

    public function CSKH(Request $request)
    {
        $id = Auth::user()->id;
        $time = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
        $data = $request->all();
        $update = $this->lockedRepository->update_with_locked_id($id, [
            'status' => 1,
            'updated_at' => $time,
        ]);
        $create_or_update_req = $this->req->createOrUpdate($id, $request);
        $json['code'] = 200;
        echo json_encode($json);
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