<?php

namespace App\Model\Repository;

use App\Model\Entity\Issue;

class IssueRepositoryEloquent extends RepositoryAbstractEloquent
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Issue::class;
    }
}