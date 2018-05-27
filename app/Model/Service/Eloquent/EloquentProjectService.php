<?php

namespace App\Model\Service\Eloquent;

use App\Providers\AppServiceProvider;
use Illuminate\Support\Collection;

class EloquentProjectService extends EloquentServiceAbstract
{
    use StoreNamespacesTrait;

    public function __construct()
    {
        $this->repository = app(AppServiceProvider::PROJECT_REPOSITORY);
    }

    /**
     * @inheritdoc
     */
    public function storeList(Collection $list)
    {
        $this->storeNamespaces($list, ['namespace']);
        parent::storeList($list);
    }
}