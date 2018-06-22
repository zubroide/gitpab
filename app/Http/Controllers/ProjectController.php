<?php

namespace App\Http\Controllers;

use App\Model\Service\Eloquent\EloquentProjectService;

class ProjectController extends CrudController
{
    /**
     * @return EloquentProjectService
     */
    protected function getService()
    {
        return app(EloquentProjectService::class);
    }

}
