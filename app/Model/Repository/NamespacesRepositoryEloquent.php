<?php

namespace App\Model\Repository;

use App\Model\Entity\Namespaces;

class NamespacesRepositoryEloquent extends RepositoryAbstractEloquent
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Namespaces::class;
    }

}