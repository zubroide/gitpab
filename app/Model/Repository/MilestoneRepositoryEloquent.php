<?php

namespace App\Model\Repository;

use App\Model\Entity\Milestone;

class MilestoneRepositoryEloquent extends RepositoryAbstractEloquent
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Milestone::class;
    }

}