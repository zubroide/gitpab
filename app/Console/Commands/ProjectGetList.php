<?php

namespace App\Console\Commands;

use App\Model\Service\GitlabProjectService;
use App\Providers\AppServiceProvider;
use Illuminate\Console\Command;

class ProjectGetList extends Command
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
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var GitlabProjectService $service */
        $service = app(AppServiceProvider::GITLAB_PROJECT_SERVICE);
        $list = $service->getList();

        // Print list
        $headers = ['id', "path_with_namespace", 'name', "created_at"];
        $data = [];
        foreach ($list as $item) {
            $row = [];
            foreach ($headers as $header) {
                $row[$header] = $item[$header];
            }
            $data[] = $row;
        }
        $this->table($headers, $data);

        $service->storeList($list);
    }
}
