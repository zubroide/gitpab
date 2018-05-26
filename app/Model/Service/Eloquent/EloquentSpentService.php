<?php

namespace App\Model\Service\Eloquent;

use App\Providers\AppServiceProvider;

class EloquentSpentService extends EloquentServiceAbstract
{
    public function __construct()
    {
        $this->repository = app(AppServiceProvider::SPENT_REPOSITORY);
    }

}