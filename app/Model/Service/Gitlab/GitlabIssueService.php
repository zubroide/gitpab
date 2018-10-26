<?php

namespace App\Model\Service\Gitlab;

use Illuminate\Support\Collection;

class GitlabIssueService extends GitlabServiceAbstract
{

    protected function getListUrl(): string
    {
        return config('gitlab.urls.project-issue-list');
    }

    protected function getItemUrl(): string
    {
        return config('gitlab.urls.project-issue-item');
    }

    public function getList(array $urlParameters = [], array $requestParameters = []): Collection
    {
        $list = parent::getList($urlParameters, $requestParameters);

        foreach ($list as $key => $item) {
            $item['author_id'] = $item['author']['id'] ?? null;
            $item['assignee_id'] = $item['assignee']['id'] ?? null;

            $item['gitlab_created_at'] = $item['created_at'];
            unset($item['created_at']);

            $item['gitlab_updated_at'] = $item['updated_at'];
            unset($item['updated_at']);

            $item['milestone_id'] = $item['milestone']['id'] ?? null;

            $item['estimate'] = !empty($item['time_stats']['time_estimate'])
                ? $item['time_stats']['time_estimate'] / 60 / 60
                : null;

            $list->put($key, $item);
        }

        return $list;
    }
}