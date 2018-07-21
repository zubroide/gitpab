<?php

namespace App\Model\Repository;

use Spatie\Permission\Models\Role;

class RoleRepositoryEloquent extends RepositoryAbstractEloquent
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }
}