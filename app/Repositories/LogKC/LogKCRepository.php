<?php

namespace App\Repositories\LogKC;

use App\Models\logKC;
use App\Repositories\EloquentRepository;

class LogKCRepository extends EloquentRepository implements LogKCRepositoryInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\logKC::class;
    }
    public function paginate($id, $paginate)
    {
        $result = logKC::query()->where('user_id', $id)->orderBy('user_id', 'desc')->paginate($paginate);
        return $result;
    }
}