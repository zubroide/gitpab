<?php

namespace App\Model\Repository;

use App\Model\Entity\Issue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class IssueRepositoryEloquent extends RepositoryAbstractEloquent
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Issue::class;
    }

    public function getLastUpdatedIssue(int $projectId)
    {
        return $this->model
            ->where('project_id', '=', $projectId)
            ->orderBy('gitlab_updated_at', 'desc')
            ->first();
    }

    public function getListQuery(array $parameters): Builder
    {
        $query = parent::getListQuery($parameters);

        if ($id = Arr::get($parameters, 'id'))
        {
            $query->where('issue.id', '=', $id);
        }

        if ($assigneeIds = Arr::get($parameters, 'assignee'))
        {
            $query->whereIn('issue.assignee_id', $assigneeIds);
        }

        if ($issueIid = Arr::get($parameters, 'issue_iid'))
        {
            $query->where('issue.iid', '=', $issueIid);
        }

        if ($projectIds = Arr::get($parameters, 'projects'))
        {
            $query->whereIn('issue.project_id', $projectIds);
        }

        if ($labels = Arr::get($parameters, 'labels'))
        {
            $labelsString = implode("'::character varying, '", $labels);
            $labelsString = "'$labelsString'::character varying";
            $query->whereRaw("issue.labels @> array[$labelsString]");
        }

        if ($dateStart = Arr::get($parameters, 'date_start'))
        {
            $date = new \DateTime($dateStart);
            $query->where('issue.gitlab_created_at', '>=', $date->format('Y-m-d'));
        }

        if ($dateEnd = Arr::get($parameters, 'date_end'))
        {
            $date = new \DateTime($dateEnd);
            $date->add(new \DateInterval('P1D'));
            $query->where('issue.gitlab_created_at', '<', $date->format('Y-m-d'));
        }

        return $query;
    }
}