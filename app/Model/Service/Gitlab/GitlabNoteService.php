<?php

namespace App\Model\Service\Gitlab;

use Illuminate\Support\Collection;

class GitlabNoteService extends GitlabServiceAbstract
{

    protected function getListUrl(): string
    {
        return config('gitlab.urls.project-issue-note-list');
    }

    protected function getItemUrl(): string
    {
        return config('gitlab.urls.project-issue-note-item');
    }

    public function getList(array $urlParameters = [], array $requestParameters = []): Collection
    {
        $list = parent::getList($urlParameters, $requestParameters);

        foreach ($list as $key => $item) {
            $item['author_id'] = $item['author']['id'] ?? null;

            $item['gitlab_created_at'] = $item['created_at'];
            unset($item['created_at']);

            $item['gitlab_updated_at'] = $item['updated_at'];
            unset($item['updated_at']);

            $item['issue_id'] = $item['noteable_id'];
            unset($item['noteable_id']);

            $list->put($key, $item);
        }

        return $list;
    }
}