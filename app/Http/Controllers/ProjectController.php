<?php

namespace App\Http\Controllers;

use App\Model\Service\Eloquent\EloquentProjectService;
use App\Providers\AppServiceProvider;

class ProjectController extends CrudController
{
    /**
     * @return EloquentProjectService
     */
    protected function getService()
    {
        return app(AppServiceProvider::ELOQUENT_PROJECT_SERVICE);
    }

}
