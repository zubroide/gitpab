<?php

namespace App\Model\Service\Eloquent;

use App\Model\Repository\IssueRepositoryEloquent;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Collection;

/**
 * @property IssueRepositoryEloquent $repository
 */
class EloquentIssueService extends CrudServiceAbstract
{
    use StoreContributorsTrait;
    use StoreLabelsTrait;

    /** @var int[]|null */
    protected $filterProjectIds = null;

    public function __construct()
    {
        $this->repository = app(AppServiceProvider::ISSUE_REPOSITORY);
        $this->filterProjectIds = config('gitlab.restrictions.project_ids');
    }

    /**
     * @inheritdoc
     */
    public function storeList(Collection $list)
    {
        // If selected only concrete projects, we update only them
        if ($this->filterProjectIds !== null) {
            foreach ($list as $key => $item) {
                if (!in_array($item['project_id'], $this->filterProjectIds)) {
                    $list->pull($key);
                }
            }
        }

        $this->storeContributors($list, ['author', 'assignee']);
        $this->storeLabels($list, 'labels');
        parent::storeList($list);
    }

    public function getLastUpdateAt(int $projectId)
    {
        $issue = $this->repository->getLastUpdatedIssue($projectId);
        if (!$issue) {
            return null;
        }
        return $issue->gitlab_updated_at;
    }
}