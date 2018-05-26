<?php

namespace App\Model\Service\Eloquent;

use App\Model\Repository\IssueRepositoryEloquent;
use App\Providers\AppServiceProvider;

/**
 * @property IssueRepositoryEloquent $repository
 */
class EloquentIssueService extends EloquentServiceAbstract
{
    public function __construct()
    {
        $this->repository = app(AppServiceProvider::ISSUE_REPOSITORY);
    }

    public function getLastUpdateAt()
    {
        $issue = $this->repository->getLastUpdatedIssue();
        if (!$issue) {
            return null;
        }
        return $issue->gitlab_updated_at;
    }
}