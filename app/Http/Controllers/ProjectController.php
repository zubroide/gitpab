<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequest;
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

    protected function prepareDataForShow(FormRequest $request, array $data)
    {
        /** @var EloquentProjectService $service */
        $service = app(AppServiceProvider::ELOQUENT_PROJECT_SERVICE);
        $id = $this->getRouteParamId($request);
        return array_merge(
            $data,
            [
                'contributorAmountList' => $service->getContributorsAmounts($id),
            ]
        );
    }

}
