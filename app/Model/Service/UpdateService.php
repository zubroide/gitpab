<?php

namespace App\Model\Service;

use App\Model\Service\Eloquent\EloquentIssueService;
use App\Model\Service\Eloquent\EloquentNoteService;
use App\Model\Service\Eloquent\EloquentSpentService;
use App\Model\Service\Import\Import;
use App\Model\Service\Import\ImportFactory;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Collection;

class UpdateService
{
    /** @var Import */
    protected $projectImportService;

    /** @var Import */
    protected $issueImportService;

    /** @var Import */
    protected $noteImportService;

    /** @var EloquentIssueService */
    protected $issueEloquentService;

    /** @var EloquentNoteService */
    protected $noteEloquentService;

    /** @var EloquentSpentService */
    protected $spentEloquentService;

    public function __construct()
    {
        $this->projectImportService = ImportFactory::make(AppServiceProvider::PROJECT);
        $this->issueImportService = ImportFactory::make(AppServiceProvider::ISSUE);
        $this->noteImportService = ImportFactory::make(AppServiceProvider::NOTE);

        $this->issueEloquentService = app(AppServiceProvider::ELOQUENT_ISSUE_SERVICE);
        $this->noteEloquentService = app(AppServiceProvider::ELOQUENT_NOTE_SERVICE);
        $this->spentEloquentService = app(AppServiceProvider::ELOQUENT_SPENT_SERVICE);
    }

    /**
     * @param bool $full
     * @return array
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws ServiceException
     */
    public function update(bool $full = false)
    {
        $result = [
            'projects' => 0,
            'issues' => 0,
            'notes' => 0,
        ];

        $projectList = $this->projectImportService->import([]);
        $result['projects'] += $projectList->count();

        foreach ($projectList as $project) {
            $requestParameters = [];
            if (!$full) {
                $updatedAtFrom = $this->issueEloquentService->getLastUpdateAt($project['id']);
                if ($updatedAtFrom) {
                    $requestParameters['updated_after'] = $updatedAtFrom;
                }
            }
            $issueList = $this->issueImportService->import([
                ':project_id' => $project['id'],
            ], $requestParameters);
            $result['issues'] += $issueList->count();

            foreach ($issueList as $issue) {
                $noteList = $this->noteImportService->import([
                    ':project_id' => $project['id'],
                    ':issue_iid' => $issue['iid'],
                ]);
                $result['notes'] += $noteList->count();

                $this->processNotes($project['id'], $issue['id']);
            }
        }

        return $result;
    }

    /**
     * Parse spent time by every note
     * @param null $projectId
     * @param null $issueId
     * @return Collection
     * @throws ServiceException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function processNotes($projectId = null, $issueId = null): Collection
    {
        $parameters = [
            'project_id' => $projectId,
            'issue_id' => $issueId,
            'order' => 'note.id',
            'orderDirection' => 'asc',
        ];
        $list = $this->noteEloquentService->getCompleteList($parameters);
        $spentList = $this->noteEloquentService->parseSpentTime($list);

        $this->spentEloquentService->storeList($spentList);

        return $spentList;
    }
}