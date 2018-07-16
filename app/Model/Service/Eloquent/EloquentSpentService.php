<?php

namespace App\Model\Service\Eloquent;

use App\Model\Repository\SpentRepositoryEloquent;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Collection;

/**
 * @property SpentRepositoryEloquent $repository
 */
class EloquentSpentService extends CrudServiceAbstract
{
    const DEFAULT_ORDER_COLUMN = 'note.gitlab_created_at';

    public function __construct()
    {
        $this->repository = app(AppServiceProvider::SPENT_REPOSITORY);
    }

    public function stat(array $parameters): Collection
    {
        return $this->repository->stat($parameters);
    }

}