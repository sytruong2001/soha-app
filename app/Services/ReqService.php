<?php

namespace App\Services;

use App\Models\Requested;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReqService
{
    public function get_info_req($id = null)
    {
        if ($id != null) {
            $accounts_requested = DB::table('requested')->where('user_id', $id)->count();
        } else {
            $accounts_requested = Requested::query()
                ->with('user')
                ->orderByDesc('updated_at')
                ->get();
        }
        return $accounts_requested;
    }
    public function createOrUpdate($id, $request)
    {
        $email = $request->get('email');
        $identify_numb = $request->get('identify_numb');
        $buy_coin_1 = $request->get('first');
        $price_1 = $request->get('first_money');
        $buy_coin_2 = $request->get('second');
        $price_2 = $request->get('second_money');
        $buy_coin_3 = $request->get('third');
        $price_3 = $request->get('third_money');
        $time = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
        $check_req = DB::table('requested')->where('user_id', $id)->count();
        if ($check_req == 1) {
            $req = DB::table('requested')
                ->where('user_id', $id)
                ->update([
                    'email' => $email,
                    'identify_numb' => $identify_numb,
                    'buy_coin_1' => $buy_coin_1,
                    'price_1' => $price_1,
                    'buy_coin_2' => $buy_coin_2,
                    'price_2' => $price_2,
                    'buy_coin_3' => $buy_coin_3,
                    'price_3' => $price_3,
                    'updated_at' => $time,
                ]);
        } else {
            $req = DB::table('requested')
                ->insert([
                    'user_id' => $id,
                    'email' => $email,
                    'identify_numb' => $identify_numb,
                    'buy_coin_1' => $buy_coin_1,
                    'price_1' => $price_1,
                    'buy_coin_2' => $buy_coin_2,
                    'price_2' => $price_2,
                    'buy_coin_3' => $buy_coin_3,
                    'price_3' => $price_3,
                    'created_at' => $time,
                    'updated_at' => $time,
                ]);
        }
        return $req;
    }
    public function delete($id)
    {
        $delete_req = DB::table("requested")
            ->where('user_id', $id)
            ->delete();
    }
}