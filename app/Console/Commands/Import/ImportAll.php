<?php

namespace App\Console\Commands\Import;

use App\Model\Service\UpdateService;
use App\Providers\AppServiceProvider;
use Illuminate\Console\Command;

class ImportAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:all {--full : Import all (not only changed data) }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all projects ant its issues and comments';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @throws \App\Model\Service\ServiceException
     */
    public function handle()
    {
        /** @var UpdateService $service */
        $service = app(AppServiceProvider::UPDATE_SERVICE);
        $counts = $service->update($this->option('full'));

        $data = [];
        foreach ($counts as $key => $value) {
            $data[] = [$key, $value];
        }

        $this->table(['Entity', 'Imported'], $data);
    }

}
