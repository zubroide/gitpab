<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequest;
use App\Http\Requests\TimeListRequest;
use App\Model\Repository\ContributorRepositoryEloquent;
use App\Model\Repository\ProjectRepositoryEloquent;
use App\Model\Service\Eloquent\EloquentSpentService;
use App\Providers\AppServiceProvider;

class TimeController extends CrudController
{
    protected $requestMap = [
        'index' => TimeListRequest::class,
    ];

    /**
     * @return EloquentSpentService
     */
    protected function getService()
    {
        return app(EloquentSpentService::class);
    }

    protected function prepareDataForIndex(FormRequest $request, array $data)
    {
        /** @var ContributorRepositoryEloquent $contributorRepository */
        $contributorRepository = app(AppServiceProvider::CONTRIBUTOR_REPOSITORY);

        /** @var ProjectRepositoryEloquent $projectRepository */
        $projectRepository = app(AppServiceProvider::PROJECT_REPOSITORY);

        return array_merge(
            $data,
            [
                'authorsList' => $contributorRepository->getItemsForSelect(),
                'projectsList' => $projectRepository->getItemsForSelect(),
            ]
        );
    }
}
