<?php

namespace App\Console\Commands\Look;

use App\Providers\AppServiceProvider;

class LookIssues extends LookCommandAbstract
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'look:issues {--P|project_id= : Project id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display issue list for specified project from Gitlab';

    protected function getEntityName(): string
    {
        return AppServiceProvider::ISSUE;
    }

    protected function getHeaders(): array
    {
        return [
            'id',
            'iid',
            'title',
            'gitlab_created_at',
        ];
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getUrlParameters(): array
    {
        if (!$this->option('project_id'))
        {
            throw new \Exception('project_id must be specified');
        }

        return [
            ':project_id' => $this->option('project_id'),
        ];
    }

}
