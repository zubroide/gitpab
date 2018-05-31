<?php

namespace App\Model\Service\Gitlab;

use App\Providers\AppServiceProvider;

class GitlabServiceFactory
{
    public static function make(string $entityName): GitlabServiceAbstract
    {
        return app(AppServiceProvider::GITLAB_SERVICE_NAMESPACE . '.' . $entityName);
    }
}