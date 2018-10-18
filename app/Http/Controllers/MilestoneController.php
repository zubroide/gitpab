<?php

namespace App\Http\Controllers;

use App\Model\Service\Eloquent\EloquentMilestoneService;

class MilestoneController extends CrudController
{
    /**
     * @return EloquentMilestoneService
     */
    protected function getService()
    {
        return app(EloquentMilestoneService::class);
    }

}
