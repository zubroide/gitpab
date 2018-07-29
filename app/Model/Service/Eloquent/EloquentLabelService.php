<?php

namespace App\Model\Service\Eloquent;

use App\Model\Repository\IssueRepositoryEloquent;
use App\Providers\AppServiceProvider;

/**
 * @property IssueRepositoryEloquent $repository
 */
class EloquentLabelService extends CrudServiceAbstract
{

    public function __construct()
    {
        $this->repository = app(AppServiceProvider::LABEL_REPOSITORY);
    }

    public function getAllLabels()
    {
        return $this->repository->get()->pluck('name')->toArray();
    }

}