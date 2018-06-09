<?php

namespace App\Model\Service\Gitlab;

use Illuminate\Support\Collection;

class GitlabProjectService extends GitlabServiceAbstract
{

    protected function getListUrl(): string
    {
        return config('gitlab.urls.project-list');
    }

    protected function getItemUrl(): string
    {
        return config('gitlab.urls.project-item');
    }

    public function getList(array $urlParameters = [], array $requestParameters = []): Collection
    {
        if (!isset($requestParameters['membership'])){
            $requestParameters['membership'] = self::BOOLEAN_TRUE;
        }

        $list = parent::getList($urlParameters, $requestParameters);

        foreach ($list as $key => $item) {
            $item['namespace_id'] = $item['namespace']['id'] ?? null;
            $list->put($key, $item);
        }

        return $list;
    }
}