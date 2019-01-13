<?php

namespace App\Model\Repository;

use Illuminate\Database\Eloquent\Builder;
use App\Model\Entity\Project;

class ProjectRepositoryEloquent extends RepositoryAbstractEloquent
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Project::class;
    }

    public function getListQuery(array $parameters): Builder
    {
        $query = parent::getListQuery($parameters);

        // Estimate
        $query->selectSub(function($q) {
            $q
                ->from('issue')
                ->selectRaw('sum(issue.estimate)')
                ->whereRaw('issue.project_id = project.id');
        }, 'estimate');

        // Spent time
        $query->selectSub(function($q) {
            $q
                ->from('spent')
                ->join('note', 'note.id', '=', 'spent.note_id')
                ->join('issue', 'issue.id', '=', 'note.issue_id')
                ->selectRaw('sum(spent.hours)')
                ->whereRaw('issue.project_id = project.id');
        }, 'spent');

        return $query;
    }

}
