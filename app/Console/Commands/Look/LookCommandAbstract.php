<?php

namespace App\Console\Commands\Look;

use App\Model\Service\Gitlab\GitlabServiceFactory;
use Illuminate\Console\Command;

abstract class LookCommandAbstract extends Command
{

    abstract protected function getEntityName(): string;

    /**
     * @return string[]
     */
    abstract protected function getHeaders(): array;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $gitlabService = GitlabServiceFactory::make($this->getEntityName());

        $urlParameters = $this->getUrlParameters();
        $list = $gitlabService->getList($urlParameters);

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
    }

    protected function getUrlParameters(): array
    {
        return [];
    }
}
