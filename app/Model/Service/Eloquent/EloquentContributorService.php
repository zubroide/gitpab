<?php

namespace App\Model\Service\Eloquent;

use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentContributorService extends CrudServiceAbstract
{
    public function __construct()
    {
        $this->repository = app(AppServiceProvider::CONTRIBUTOR_REPOSITORY);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getObjectForEdit($id)
    {
        // Get contributor with balance
        $list = $this->repository->getListQuery(['id' => $id]);
        if ($list->count() > 0) {
            return $list->first();
        }
        throw new ModelNotFoundException('Entity was not found');
    }

}