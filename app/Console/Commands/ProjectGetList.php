<?php

namespace App\Console\Commands;

use App\Model\Service\Eloquent\EloquentProjectService;
use App\Model\Service\Gitlab\GitlabProjectService;
use App\Providers\AppServiceProvider;

/**
 * @property EloquentProjectService $eloquentService
 * @property GitlabProjectService $gitlabService
 */
class ProjectGetList extends GitlabCommandAbstract
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:get-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get project list from Gitlab';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->eloquentService = app(AppServiceProvider::ELOQUENT_PROJECT_SERVICE);
        $this->gitlabService = app(AppServiceProvider::GITLAB_PROJECT_SERVICE);
    }

    protected function getHeaders(): array
    {
        return [
            'id',
            'path_with_namespace',
            'name',
            'created_at',
        ];
    }

}
