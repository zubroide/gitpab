<?php

namespace App\Console\Commands;

use App\Model\Service\GitlabProjectService;
use App\Providers\AppServiceProvider;

/**
 * @property GitlabProjectService $service
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
        $this->service = app(AppServiceProvider::GITLAB_PROJECT_SERVICE);
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
