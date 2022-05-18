<?php

namespace App\Repositories\KC;

use App\Models\KC;
use App\Repositories\EloquentRepository;

class KCRepository extends EloquentRepository implements KCRepositoryInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\KC::class;
    }
    public function get_with_user_id($id)
    {
        $result = KC::where('user_id', $id)->first();
        return $result;
    }
    public function update_with_user_id($id, array $data)
    {
        $result = KC::where('user_id', $id)
            ->update($data);
        return $result;
    }
}