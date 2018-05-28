<?php

namespace App\Model\Service\Eloquent;

use App\Providers\AppServiceProvider;
use Illuminate\Support\Collection;

class EloquentProjectService extends EloquentServiceAbstract
{
    use StoreNamespacesTrait;

    /** @var int[]|null */
    protected $filterProjectIds = null;

    public function __construct()
    {
        $this->repository = app(AppServiceProvider::PROJECT_REPOSITORY);
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
                if (!in_array($item['id'], $this->filterProjectIds)) {
                    $list->pull($key);
                }
            }
        }

        $this->storeNamespaces($list, ['namespace']);
        parent::storeList($list);
    }
}