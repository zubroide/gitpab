<?php

namespace App\Model\Repository;

use Illuminate\Database\Eloquent\Builder;
use App\Model\Entity\Project;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

        // Amount
        $query->selectSub(function($q) {
            $q
                ->from('spent')
                ->join('note', 'note.id', '=', 'spent.note_id')
                ->join('issue', 'issue.id', '=', 'note.issue_id')
                ->join('contributor_extra', 'contributor_extra.contributor_id', '=', 'note.author_id')
                ->selectRaw('round(sum(
                    spent.hours * contributor_extra.hour_rate * 
                    (100 + contributor_extra.taxes_percent) / 
                    (100 - contributor_extra.costs_percent)
                ), 2)')
                ->whereRaw('issue.project_id = project.id');
        }, 'amount');

        return $query;
    }

    public function getContributorsAmounts(int $projectId): Collection
    {
        return $this->model
            ->select(
                'contributor.name as name',
                DB::raw('sum(spent.hours) as hours'),
                DB::raw('round(sum(
                    spent.hours * contributor_extra.hour_rate * 
                    (100 + contributor_extra.taxes_percent) / 
                    (100 - contributor_extra.costs_percent)
                ), 2) as amount')
            )
            ->join('issue', 'issue.project_id', '=', 'project.id')
            ->join('note', 'note.issue_id', '=', 'issue.id')
            ->join('spent', 'spent.note_id', '=', 'note.id')
            ->join('contributor', 'contributor.id', '=', 'note.author_id')
            ->join('contributor_extra', 'contributor_extra.contributor_id', '=', 'contributor.id')
            ->where('project.id', '=', $projectId)
            ->groupBy('contributor.id')
            ->orderBy('contributor.name')
            ->get()
        ;
    }

}
