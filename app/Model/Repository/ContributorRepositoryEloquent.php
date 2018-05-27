<?php

namespace App\Model\Repository;

use App\Model\Entity\Contributor;

class ContributorRepositoryEloquent extends RepositoryAbstractEloquent
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contributor::class;
    }

}