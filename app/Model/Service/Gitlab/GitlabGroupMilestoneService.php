<?php

namespace App\Model\Service\Gitlab;

use Illuminate\Support\Collection;

class GitlabGroupMilestoneService extends GitlabServiceAbstract
{

    protected function getListUrl(): string
    {
        return config('gitlab.urls.group-milestone-list');
    }

    protected function getItemUrl(): string
    {
        // Not used
        return config('gitlab.urls.group-milestone-item');
    }

    public function getList(array $urlParameters = [], array $requestParameters = []): Collection
    {
        $list = parent::getList($urlParameters, $requestParameters);

        foreach ($list as $key => $item) {
            $item['gitlab_created_at'] = $item['created_at'];
            unset($item['created_at']);

            $item['gitlab_updated_at'] = $item['updated_at'];
            unset($item['updated_at']);

            $list->put($key, $item);
        }

        return $list;
    }
}