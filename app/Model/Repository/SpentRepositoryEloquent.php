<?php

namespace App\Model\Repository;

use App\Model\Entity\Spent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class SpentRepositoryEloquent extends RepositoryAbstractEloquent
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Spent::class;
    }

    public function getListQuery(array $parameters): Builder
    {
        $query = parent::getListQuery($parameters)
            ->join('note', 'note.id', '=', 'spent.note_id');

        if ($issueId = Arr::get($parameters, 'issue_id'))
        {
            $query->where('note.issue_id', '=', $issueId);
        }

        return $query;
    }

}