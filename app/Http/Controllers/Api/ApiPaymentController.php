<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\KC\KCRepositoryInterface;
use App\Repositories\LogCoin\LogCoinRepositoryInterface;
use App\Repositories\LogKC\LogKCRepositoryInterface;
use App\Repositories\InfoUser\InfoUserRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class ApiPaymentController extends Controller
{
    protected $userRepository;
    protected $infoUserRepository;
    protected $logCoinRepository;
    protected $logKCRepository;
    protected $kCRepository;
    public function __construct(KCRepositoryInterface $kCRepository,  UserRepositoryInterface $userRepository, InfoUserRepositoryInterface $infoUserRepository, LogCoinRepositoryInterface $logCoinRepository, LogKCRepositoryInterface $logKCRepository)
    {
        $this->userRepository = $userRepository;
        $this->infoUserRepository = $infoUserRepository;
        $this->logCoinRepository = $logCoinRepository;
        $this->logKCRepository = $logKCRepository;
        $this->kCRepository = $kCRepository;
    }

    // lấy thông tin về số lượng coin và kc
    public function getInfoPayment(Request $request)
    {
        $id = Auth::user()->id;
        $payment = $this->userRepository->get_with_info_user($id);
        $logKc = $this->logKCRepository->paginate($id, 3);
        $logCoin = $this->logCoinRepository->paginate($id, 3);
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
        $data_coin = [
            'coin' => $passCoin + $coin,
        ];
        $update_coin_user = $this->infoUserRepository->update_with_user_id($id, $data_coin);
        $data_log_coin = [
            'user_id' => $id,
            'coin_numb' => $coin,
            'nap_coin_time' => $time,
        ];
        $createNapCoinLog = $this->logCoinRepository->create($data_log_coin);
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
        $data_coin = [
            'coin' => $coin - ($kc / 5),
        ];
        $update_coin_user = $this->infoUserRepository->update_with_user_id($id, $data_coin); // lưu dữ liệu vào bảng info_user
        $checkInfoKc = $this->kCRepository->get_with_user_id($id); // kiểm tra xem có tồn tại kc của người dùng hay không?
        if ($checkInfoKc) { // nếu có thì cập nhật
            $KC = $checkInfoKc->kc_numb;
            $Kc_numb_current = $KC + $kc;
            $updateKC = $this->kCRepository->update_with_user_id($id, [
                'kc_numb' => $Kc_numb_current,
            ]);
        } else { // nếu không thì tạo mới
            $createKC = $this->kCRepository->create([
                'user_id' => $id,
                'kc_numb' => $kc,
            ]);
        }
        $data_kc = [
            'user_id' => $id,
            'kc_numb' => $kc,
            'mua_kc_time' => $time,
        ];
        $createLogKc = $this->logKCRepository->create($data_kc);
        $json['success'] = "Mua Kim Cương thành công!";
        $json['code'] = 200;
        echo json_encode($json);
    }
}