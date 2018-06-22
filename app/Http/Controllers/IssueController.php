<?php

namespace App\Http\Controllers;

use App\Model\Service\Eloquent\EloquentIssueService;

class IssueController extends CrudController
{
    /**
     * @return EloquentIssueService
     */
    protected function getService()
    {
        return app(EloquentIssueService::class);
    }

}
