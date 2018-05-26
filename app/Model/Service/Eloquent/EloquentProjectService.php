<?php

namespace App\Model\Service\Eloquent;

use App\Providers\AppServiceProvider;

class EloquentProjectService extends EloquentServiceAbstract
{
    public function __construct()
    {
        $this->repository = app(AppServiceProvider::PROJECT_REPOSITORY);
    }
}