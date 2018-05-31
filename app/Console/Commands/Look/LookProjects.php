<?php

namespace App\Console\Commands\Look;

use App\Providers\AppServiceProvider;

class LookProjects extends LookCommandAbstract
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'look:projects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display project list from Gitlab';

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
