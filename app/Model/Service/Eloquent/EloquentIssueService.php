<?php

namespace App\Model\Service\Eloquent;

use App\Providers\AppServiceProvider;

class EloquentIssueService extends EloquentServiceAbstract
{
    public function __construct()
    {
        $this->repository = app(AppServiceProvider::ISSUE_REPOSITORY);
    }
}