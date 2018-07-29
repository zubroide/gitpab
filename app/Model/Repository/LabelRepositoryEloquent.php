<?php

namespace App\Model\Repository;

use App\Model\Entity\Label;

class LabelRepositoryEloquent extends RepositoryAbstractEloquent
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Label::class;
    }

}