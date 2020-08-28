<?php

namespace App\Model\Service\Eloquent;

use App\Model\Repository\SpentRepositoryEloquent;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @property SpentRepositoryEloquent $repository
 */
class EloquentSpentService extends CrudServiceAbstract
{
    const DEFAULT_ORDER_COLUMN = 'spent.spent_at';

    public function __construct()
    {
        $this->repository = app(AppServiceProvider::SPENT_REPOSITORY);
    }

    public function stat(array $parameters): Collection
    {
        return $this->repository->stat($parameters);
    }

    public function getTotalTime(array $parameters)
    {
        $query = $this->repository->getListQuery($parameters);
        $query->select(DB::raw('sum(hours) as total'));
        return $query->first()->total;
    }

    public function getTNMList($parameters)
    {
        $query = $this->repository->getTNMListQuery($parameters);
        return $query->cursor();
    }

    public function getTNMLabelsList($parameters)
    {
        $query = $this->repository->getTNMLabelsListQuery($parameters);
        return $query->cursor();
    }

}