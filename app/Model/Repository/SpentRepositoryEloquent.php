<?php

namespace App\Model\Repository;

use App\Model\Entity\Spent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

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

    public function stat($parameters): Collection
    {
        /** @var Builder $query */
        $query = $this->model;

        $query = $query
            ->select([
                'note.gitlab_created_at',
                'project.path_with_namespace as project',
                'issue.iid',
                'issue.title as issue_title',
                'spent.hours',
                'spent.description as note_description',
            ])
            ->join('note', 'note.id', '=', 'spent.note_id')
            ->join('issue', 'issue.id', '=', 'note.issue_id')
            ->join('project', 'project.id', '=', 'issue.project_id');

        if ($dateStart = Arr::get($parameters, 'date_start')) {
            $query->where('note.gitlab_created_at', '>=', $dateStart);
        }

        if ($dateFinish = Arr::get($parameters, 'date_finish')) {
            $query->where('note.gitlab_created_at', '<', $dateFinish);
        }

        if ($userId = Arr::get($parameters, 'user_id')) {
            $query->where('note.author_id', '=', $userId);
        }

        if ($projectId = Arr::get($parameters, 'project_id')) {
            $query->where('issue.project_id', '=', $projectId);
        }

        if ($issueId = Arr::get($parameters, 'issue_id')) {
            $query->where('note.issue_id', '=', $issueId);
        }

        if ($order = Arr::get($parameters, 'order')) {
            $query->orderBy($order);
        }

        $query
            ->orderBy('issue.iid', 'asc')
            ->orderBy('note.gitlab_created_at', 'asc');

        return $query->get();
    }

}