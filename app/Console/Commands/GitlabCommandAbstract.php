<?php

namespace App\Console\Commands;

use App\Model\Service\Eloquent\EloquentServiceAbstract;
use App\Model\Service\Gitlab\GitlabServiceAbstract;
use Illuminate\Console\Command;

abstract class GitlabCommandAbstract extends Command
{

    /**
     * @var GitlabServiceAbstract
     */
    protected $gitlabService;

    /**
     * @var EloquentServiceAbstract
     */
    protected $eloquentService;

    /**
     * @return string[]
     */
    abstract protected function getHeaders(): array;

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function handle()
    {
        $urlParameters = $this->getUrlParameters();
        $list = $this->gitlabService->getList($urlParameters);

        // Print list
        $headers = $this->getHeaders();
        $data = [];
        foreach ($list as $item) {
            $row = [];
            foreach ($headers as $header) {
                $row[$header] = $item[$header];
            }
            $data[] = $row;
        }
        $this->table($headers, $data);

        $this->eloquentService->storeList($list);
        $this->info('Data stored in database');
    }

    protected function getUrlParameters(): array
    {
        return [];
    }
}
