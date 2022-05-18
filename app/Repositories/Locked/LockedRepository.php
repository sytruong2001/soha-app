<?php

namespace App\Repositories\Locked;

use App\Models\Lock;
use App\Repositories\EloquentRepository;

class LockedRepository extends EloquentRepository implements LockedRepositoryInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Lock::class;
    }
    public function update_with_locked_id($id, array $data)
    {
        $result = Lock::where('locked_id', $id)
            ->update($data);
        return $result;
    }
}