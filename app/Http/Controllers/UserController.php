<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequest;
use App\Model\Repository\ContributorRepositoryEloquent;
use App\Model\Repository\RoleRepositoryEloquent;
use App\Model\Service\Eloquent\EloquentUserService;
use App\Providers\AppServiceProvider;

class UserController extends CrudController
{
    /**
     * @return EloquentUserService
     */
    protected function getService()
    {
        return app(EloquentUserService::class);
    }

    protected function prepareDataForEdit(FormRequest $request, array $data)
    {
        /** @var RoleRepositoryEloquent $roleRepository */
        $roleRepository = app(AppServiceProvider::ROLE_REPOSITORY);

        /** @var ContributorRepositoryEloquent $contributorRepository */
        $contributorRepository = app(AppServiceProvider::CONTRIBUTOR_REPOSITORY);

        return array_merge(
            $data,
            [
                'rolesList' => $roleRepository->getItemsForSelect(),
                'contributorList' => $contributorRepository->getItemsForSelect(['' => '-']),
            ]
        );
    }
}
