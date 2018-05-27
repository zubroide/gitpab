<?php

namespace App\Model\Service\Eloquent;

use App\Model\Repository\IssueRepositoryEloquent;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Collection;

/**
 * @property IssueRepositoryEloquent $repository
 */
class EloquentIssueService extends EloquentServiceAbstract
{
    use StoreContributorsTrait;

    public function __construct()
    {
        $this->repository = app(AppServiceProvider::ISSUE_REPOSITORY);
    }

    /**
     * @inheritdoc
     */
    public function storeList(Collection $list)
    {
        $this->storeContributors($list, ['author', 'assignee']);
        parent::storeList($list);
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