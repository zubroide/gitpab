<?php

namespace App\Http\Controllers;

use App\Model\Service\Eloquent\EloquentContributorService;

class ContributorController extends CrudController
{
    /**
     * @return EloquentContributorService
     */
    protected function getService()
    {
        return app(EloquentContributorService::class);
    }

}
