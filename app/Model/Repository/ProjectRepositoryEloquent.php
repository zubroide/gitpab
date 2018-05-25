<?php

namespace App\Model\Repository;

use App\Model\Entity\Project;

class ProjectRepositoryEloquent extends RepositoryAbstractEloquent
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Project::class;
    }
}