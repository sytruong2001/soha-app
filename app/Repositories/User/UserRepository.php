<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\EloquentRepository;

class UserRepository extends EloquentRepository implements UserRepositoryInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\User::class;
    }
    public function get_with_info_user($id)
    {
        $result = User::query()->with('info_user', 'info_kc', 'logKc', 'logCoin')->where('users.id', $id)->first();
        return $result;
    }
}