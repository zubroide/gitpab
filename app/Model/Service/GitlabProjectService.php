<?php

namespace App\Model\Service;


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
}