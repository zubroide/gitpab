<?php

namespace App\Model\Service\Eloquent;

use App\Providers\AppServiceProvider;

class EloquentMilestoneService extends CrudServiceAbstract
{
    public function __construct()
    {
        $this->repository = app(AppServiceProvider::MILESTONE_REPOSITORY);
    }
}