<?php

namespace App\Model\Service;

use App\Model\Service\Import\Import;
use App\Model\Service\Import\ImportFactory;
use App\Providers\AppServiceProvider;

class UpdateService
{
    /** @var Import */
    protected $projectImportService;

    /** @var Import */
    protected $issueImportService;

    /** @var Import */
    protected $noteImportService;

    public function __construct()
    {
        $this->projectImportService = ImportFactory::make(AppServiceProvider::PROJECT);
        $this->issueImportService = ImportFactory::make(AppServiceProvider::ISSUE);
        $this->noteImportService = ImportFactory::make(AppServiceProvider::NOTE);
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update()
    {
        $result = [
            'projects' => 0,
            'issues' => 0,
            'notes' => 0,
        ];

        $projectList = $this->projectImportService->import([]);
        $result['projects'] += $projectList->count();

        foreach ($projectList as $project) {
            $issueList = $this->issueImportService->import([
                ':project_id' => $project['id'],
            ]);
            $result['issues'] += $issueList->count();

            foreach ($issueList as $issue) {
                $noteList = $this->noteImportService->import([
                    ':project_id' => $project['id'],
                    ':issue_id' => $issue['id'],
                ]);
                $result['notes'] += $noteList->count();
            }
        }

        return $result;
    }
}