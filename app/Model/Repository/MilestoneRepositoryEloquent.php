<?php

namespace App\Model\Repository;

use Illuminate\Database\Eloquent\Builder;
use App\Model\Entity\Milestone;

class MilestoneRepositoryEloquent extends RepositoryAbstractEloquent
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Milestone::class;
    }

    public function getListQuery(array $parameters): Builder
    {
        $query = parent::getListQuery($parameters)
            ->leftJoin('project', 'project.id', '=', 'milestone.project_id')
            ->leftJoin('namespace', 'namespace.id', '=', 'milestone.group_id');

        // Estimate
        $query->selectSub(function($q) {
            $q
                ->from('issue')
                ->selectRaw('sum(issue.estimate)')
                ->whereRaw('issue.milestone_id = milestone.id');
        }, 'estimate');

        // Spent time
        $query->selectSub(function($q) {
            $q
                ->from('spent')
                ->join('note', 'note.id', '=', 'spent.note_id')
                ->join('issue', 'issue.id', '=', 'note.issue_id')
                ->selectRaw('sum(spent.hours)')
                ->whereRaw('issue.milestone_id = milestone.id');
        }, 'spent');

        return $query;
    }

}