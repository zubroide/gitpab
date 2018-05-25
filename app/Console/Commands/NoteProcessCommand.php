<?php

namespace App\Console\Commands;

use App\Model\Service\Eloquent\EloquentNoteService;
use App\Providers\AppServiceProvider;
use Illuminate\Console\Command;

class NoteProcessCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'note:process {--I|issue_id= : Issue id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse comments and store spent time into database';

    /**
     * @var EloquentNoteService
     */
    protected $noteService;

    /**
     * @var EloquentSpentService
     */
    protected $spentService;

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function handle()
    {
        $this->noteService = app(AppServiceProvider::ELOQUENT_NOTE_SERVICE);

        $parameters = [
            'issue_id' => $this->option('issue_id'),
            'order' => 'gitlab_created_at',
            'orderDirection' => 'desc',
        ];
        $list = $this->noteService->getCompleteList($parameters);
        $spentList = $this->noteService->parseSpentTime($list);

        // Print list
        $headers = [
            'gitlab_created_at',
            'hours',
            'description',
        ];
        $data = [];
        foreach ($spentList as $item) {
            $row = [];
            foreach ($headers as $header) {
                $row[$header] = $item[$header];
            }
            $data[] = $row;
        }
        $this->table($headers, $data);

//        $this->eloquentService->storeList($list);
//        $this->info('Data stored in database');
    }

    protected function getUrlParameters(): array
    {
        return [];
    }
}
