<?php

namespace App\Model\Repository;

use App\Model\Entity\Note;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class NoteRepositoryEloquent extends RepositoryAbstractEloquent
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Note::class;
    }

    public function getListQuery(array $parameters): Builder
    {
        $query = parent::getListQuery($parameters);

        if ($issueId = Arr::get($parameters, 'issue_id'))
        {
            $query->where('issue_id', '=', $issueId);
        }

        return $query;
    }

}