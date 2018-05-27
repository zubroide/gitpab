<?php

namespace App\Model\Service\Eloquent;

use App\Providers\AppServiceProvider;

class EloquentContributorService extends EloquentServiceAbstract
{
    public function __construct()
    {
        $this->repository = app(AppServiceProvider::CONTRIBUTOR_REPOSITORY);
    }
}