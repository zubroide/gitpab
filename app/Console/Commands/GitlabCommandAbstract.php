<?php

namespace App\Console\Commands;

use App\Model\Service\GitlabServiceAbstract;
use Illuminate\Console\Command;

abstract class GitlabCommandAbstract extends Command
{

    /**
     * @var GitlabServiceAbstract
     */
    protected $service;

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
        $list = $this->service->getList($urlParameters);

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

        $this->service->storeList($list);
        $this->info('Data stored in database');
    }

    protected function getUrlParameters(): array
    {
        return [];
    }
}
