<?php

namespace App\Repositories\LogCoin;

use App\Models\logCoin;
use App\Repositories\EloquentRepository;

class LogCoinRepository extends EloquentRepository implements LogCoinRepositoryInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\logCoin::class;
    }
    public function paginate($id, $paginate)
    {
        $result = logCoin::query()->where('user_id', $id)->orderBy('user_id', 'desc')->paginate($paginate);
        return $result;
    }
}