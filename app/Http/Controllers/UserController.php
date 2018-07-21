<?php

namespace App\Http\Controllers;

use App\Model\Service\Eloquent\EloquentUserService;

class UserController extends CrudController
{
    /**
     * @return EloquentUserService
     */
    protected function getService()
    {
        return app(EloquentUserService::class);
    }

}
