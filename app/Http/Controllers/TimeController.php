<?php

namespace App\Http\Controllers;

use App\Model\Service\Eloquent\EloquentSpentService;

class TimeController extends CrudController
{
    /**
     * @return EloquentSpentService
     */
    protected function getService()
    {
        return app(EloquentSpentService::class);
    }

}
