<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequest;
use App\Model\Repository\ContributorRepositoryEloquent;
use App\Model\Repository\LabelRepositoryEloquent;
use App\Model\Repository\MilestoneRepositoryEloquent;
use App\Model\Repository\ProjectRepositoryEloquent;
use App\Model\Service\Eloquent\EloquentIssueService;
use App\Providers\AppServiceProvider;

class IssueController extends CrudController
{
    /**
     * @return EloquentIssueService
     */
    protected function getService()
    {
        return app(AppServiceProvider::ELOQUENT_ISSUE_SERVICE);
    }

    protected function prepareDataForIndex(FormRequest $request, array $data)
    {
        /** @var ContributorRepositoryEloquent $contributorRepository */
        $contributorRepository = app(AppServiceProvider::CONTRIBUTOR_REPOSITORY);

        /** @var ProjectRepositoryEloquent $projectRepository */
        $projectRepository = app(AppServiceProvider::PROJECT_REPOSITORY);

        /** @var LabelRepositoryEloquent $labelRepository */
        $labelRepository = app(AppServiceProvider::LABEL_REPOSITORY);

        /** @var MilestoneRepositoryEloquent $milestoneRepository */
        $milestoneRepository = app(AppServiceProvider::MILESTONE_REPOSITORY);

        $totalEstimate = $this->getService()->getTotalEstimate($request->all());
        $totalTime = $this->getService()->getTotalTime($request->all());

        return array_merge(
            $data,
            [
                'assigneeList' => $contributorRepository->getItemsForSelect(),
                'projectsList' => $projectRepository->getItemsForSelect(),
                'labelList' => $labelRepository->getItemsForSelect(null, null, 'name'),
                'milestonelList' => $milestoneRepository->getItemsForSelect(null, null, 'id', 'title'),
                'total' => [
                    'estimate' => $totalEstimate,
                    'time' => $totalTime,
                ],
            ]
        );
    }
}
