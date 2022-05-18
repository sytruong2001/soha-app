<?php

namespace App\Repositories\InfoUser;

use App\Models\InfoUser;
use App\Repositories\EloquentRepository;

class InfoUserRepository extends EloquentRepository implements InfoUserRepositoryInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\InfoUser::class;
    }
    public function update_with_user_id($id, array $data)
    {
        $result = InfoUser::where('user_id', $id)
            ->update($data);
        return $result;
    }
}