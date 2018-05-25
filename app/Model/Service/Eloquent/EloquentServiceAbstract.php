<?php

namespace App\Model\Service\Eloquent;

use App\Model\Repository\RepositoryAbstractEloquent;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

abstract class EloquentServiceAbstract
{

    /**
     * @var RepositoryAbstractEloquent
     */
    protected $repository;

    public function __construct(RepositoryAbstractEloquent $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Collection $list
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function storeList(Collection $list)
    {
        foreach ($list as $item) {
            $this->store((array)$item);
        }
    }

    /**
     * @param array $attributes
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(array $attributes)
    {
        try {
            $result = $this->repository->create($attributes);
        }
        catch (QueryException  $e) {
            // Record exists
            if ($e->getCode() == 23505) {
                $result = $this->repository->update($attributes, $attributes['id']);
            }
            else {
                throw $e;
            }
        }
        return $result;
    }
}