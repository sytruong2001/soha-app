<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ModelHasRoleService
{
    public function update_role($model_id, $role_id)
    {
        $update = DB::table("model_has_roles")
            ->where('model_id', $model_id)
            ->update([
                'role_id' => $role_id,
            ]);
    }
}