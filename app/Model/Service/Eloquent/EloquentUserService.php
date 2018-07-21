<?php

namespace App\Model\Service\Eloquent;

use App\Providers\AppServiceProvider;

class EloquentUserService extends CrudServiceAbstract
{
    public function __construct()
    {
        $this->repository = app(AppServiceProvider::USER_REPOSITORY);
    }
}