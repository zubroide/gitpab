<?php

namespace App\Model\Service\Eloquent;

use App\Model\Repository\ProjectRepositoryEloquent;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Collection;

/**
 * @property ProjectRepositoryEloquent $repository
 */
class EloquentProjectService extends CrudServiceAbstract
{
    use StoreNamespacesTrait;

    /** @var int[]|null */
    protected $filterProjectIds = null;

    /** @var int[]|null */
    protected $filterGroupIds = null;

    public function __construct()
    {
        $this->repository = app(AppServiceProvider::PROJECT_REPOSITORY);
        $this->filterProjectIds = config('gitlab.restrictions.project_ids');
        $this->filterGroupIds = config('gitlab.restrictions.group_ids');
    }

    /**
     * @inheritdoc
     */
    public function storeList(Collection $list)
    {
        $projectIds = $this->filterProjectIds;
        $groupIds = $this->filterGroupIds;

        // If selected only concrete projects or groups, we update only them
        if (!empty($projectIds) || !empty($groupIds)) {
            foreach ($list as $key => $item) {
                if (!(in_array($item['id'], $projectIds) || (
                    ($item['namespace']['id'] ?? null) &&
                    ($item['namespace']['kind'] ?? null) == 'group' &&
                    in_array($item['namespace']['id'], $groupIds)
                ))) {
                    $list->pull($key);
                }
            }
        }

        $this->storeNamespaces($list, ['namespace']);
        parent::storeList($list);
    }

    public function getContributorsAmounts(int $projectId): Collection
    {
        return $this->repository->getContributorsAmounts($projectId);
    }
}