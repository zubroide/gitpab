<?php

namespace App\Model\Service\Eloquent;

use App\Model\Repository\LabelRepositoryEloquent;
use App\Providers\AppServiceProvider;

/**
 * @property LabelRepositoryEloquent $repository
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