<?php

namespace App\Console\Commands;

use App\Providers\AppServiceProvider;

class ImportProjects extends GitlabCommandAbstract
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:projects';

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
