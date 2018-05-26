<?php

namespace App\Console\Commands;

use App\Providers\AppServiceProvider;

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

    protected function getEntityName(): string
    {
        return AppServiceProvider::PROJECT;
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
