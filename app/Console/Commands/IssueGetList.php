<?php

namespace App\Console\Commands;

use App\Model\Service\Eloquent\EloquentIssueService;
use App\Model\Service\Gitlab\GitlabIssueService;
use App\Providers\AppServiceProvider;

/**
 * @property EloquentIssueService $eloquentService
 * @property GitlabIssueService $gitlabService
 */
class IssueGetList extends GitlabCommandAbstract
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'issue:get-list {--P|project_id= : Project id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get issue list for specified project from Gitlab';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->eloquentService = app(AppServiceProvider::ELOQUENT_ISSUE_SERVICE);
        $this->gitlabService = app(AppServiceProvider::GITLAB_ISSUE_SERVICE);
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
