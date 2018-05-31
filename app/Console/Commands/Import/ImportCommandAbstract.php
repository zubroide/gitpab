<?php

namespace App\Console\Commands\Import;

use App\Model\Service\Import\ImportFactory;
use Illuminate\Console\Command;

abstract class ImportCommandAbstract extends Command
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
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function handle()
    {
        $importService = ImportFactory::make($this->getEntityName());

        $urlParameters = $this->getUrlParameters();
        $list = $importService->import($urlParameters);

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

        $this->info('Data stored in database');
    }

    protected function getUrlParameters(): array
    {
        return [];
    }
}
