<?php

namespace App\Model\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Prettus\Repository\Eloquent\BaseRepository;

abstract class RepositoryAbstractEloquent extends BaseRepository
{
    /**
     * @param array $parameters
     * @return Builder
     */
    public function getListQuery(array $parameters): Builder
    {
        return $this->model->select($this->model->getTable() . '.*');
    }

    /**
     * @param string[]|null $firstOption
     * @param string[]|null $items
     * @param string $valueField
     * @param string $labelField
     * @return string[]|null
     */
    public function getItemsForSelect(array $firstOption = null, array $items = null, string $valueField = 'id', string $labelField = 'name')
    {
        if (empty($items))
        {
            $items = $this->model->all()->pluck($labelField, $valueField)->toArray();
        }
        if (!empty($firstOption) AND is_array($firstOption))
        {
            $items = $firstOption + $items;
        }
        return $items;
    }

    /**
     * @param array $parameters
     * @param string $valueField
     * @param string[]|null $columns
     * @return Builder
     */
    public function getItemsForAutocomplete(array $parameters, string $valueField = 'name', array $columns = null): Builder
    {
        $queryString = mb_strtolower(Arr::get($parameters, 'q'));

        if (empty($columns))
        {
            $columns = ['id'];
        }
        $columns[] = $valueField . ' AS text';

        $query = $this->model
            ->from($this->model->getTable())
            ->selectRaw(implode(', ', $columns))
            ->where($valueField, 'like', $queryString . '%');

        return $query;
    }

    public function truncate()
    {
        $this->model->truncate();
    }

    public function count(): int
    {
        return $this->model->count();
    }

    public function getPkFieldName()
    {
        return $this->model->getKeyName();
    }

}
