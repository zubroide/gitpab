<?php

namespace App\Model\Service\Import;

use App\Providers\AppServiceProvider;

class ImportFactory
{
    public static function make(string $entityName): Import
    {
        return new Import(
            app(AppServiceProvider::ELOQUENT_SERVICE_NAMESPACE . '.' . $entityName),
            app(AppServiceProvider::GITLAB_SERVICE_NAMESPACE . '.' . $entityName)
        );
    }
}