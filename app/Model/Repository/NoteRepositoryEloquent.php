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
            $query->where('note.issue_id', '=', $issueId);
        }

        if ($projectId = Arr::get($parameters, 'project_id'))
        {
            $query
                ->join('issue', 'issue.id', '=', 'note.issue_id')
                ->where('issue.project_id', '=', $projectId);
        }

        return $query;
    }

}