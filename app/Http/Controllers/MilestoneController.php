<?php

namespace App\Http\Controllers;

use App\Model\Service\Eloquent\EloquentMilestoneService;
use App\Providers\AppServiceProvider;

class MilestoneController extends CrudController
{
    /**
     * @return EloquentMilestoneService
     */
    protected function getService()
    {
        return app(AppServiceProvider::ELOQUENT_GROUP_MILESTONE_SERVICE);
    }

}
