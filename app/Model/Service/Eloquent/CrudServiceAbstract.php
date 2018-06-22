<?php

namespace App\Model\Service\Eloquent;

use App\Model\Entity\EntityAbstract;
use Illuminate\Support\Facades\DB;

class CrudServiceAbstract extends EloquentServiceAbstract
{

    /**
     * @param int $id
     * @return mixed
     */
    public function getObjectForEdit($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $attributes
     * @return EntityAbstract
     * @throws \Throwable
     */
    public function create(array $attributes)
    {
        return $this->save($attributes);
    }

    /**
     * @param array $attributes
     * @param $id
     * @return EntityAbstract
     * @throws \Throwable
     */
    public function update(array $attributes, $id)
    {
        return $this->save($attributes, $id);
    }

    public function restore($id)
    {
        return $this->repository->restore($id);
    }

    /**
     * @param array $attributes
     * @param null $id
     * @return EntityAbstract
     * @throws \Throwable
     */
    protected function save(array $attributes, $id = null)
    {
        try {
            DB::beginTransaction();

            if ($id !== null) {
                $object = $this->repository->update($attributes, $id);
            }
            else {
                $object = $this->repository->create($attributes);
            }

            $this->saveObjectRelationships($object, $attributes);

            DB::commit();
            return $object;
        }
        catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Сохранение связей
     *
     * @param $object
     * @param $attributes
     */
    protected function saveObjectRelationships($object, $attributes)
    {
    }
}