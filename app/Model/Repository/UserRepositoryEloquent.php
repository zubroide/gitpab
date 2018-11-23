<?php

namespace App\Model\Repository;

use App\User;
use Illuminate\Support\Facades\DB;

class UserRepositoryEloquent extends RepositoryAbstractEloquent
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    public function activeCount()
    {
        return $this
            ->model
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('model_has_roles')
                    ->whereRaw('model_has_roles.model_id = users.id')
                    ->where('model_has_roles.model_type', '=', 'App\User');
            })
            ->count();
    }
}
