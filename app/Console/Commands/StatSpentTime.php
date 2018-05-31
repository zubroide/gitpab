<?php

namespace App\Console\Commands;

use App\Model\Service\Eloquent\EloquentSpentService;
use App\Model\Service\TimeHelper;
use App\Providers\AppServiceProvider;
use Illuminate\Console\Command;

class StatSpentTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stat:spent-time 
        {--start= : Date from } 
        {--finish= : Date to }
        {--user-id= : User ID }
        {--project-id= : Project ID }
        {--issue-id= : Issue ID }
        {--order= : Order by column }
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Spent time statistics';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var EloquentSpentService $service */
        $service = app(AppServiceProvider::ELOQUENT_SPENT_SERVICE);
        $data = $service->stat([
            'date_start' => $this->option('start'),
            'date_finish' => $this->option('finish'),
            'user_id' => $this->option('user-id'),
            'project_id' => $this->option('project-id'),
            'issue_id' => $this->option('issue-id'),
            'order' => $this->option('order'),
        ]);

        $total = 0;
        $stat = [];
        foreach ($data as $item) {
            $stat[] = [
                $item['gitlab_created_at'],
                $item['project'],
                '#' . $item['iid'] . ' ' . $item['issue_title'],
                $item['hours'],
                $item['note_description'],
            ];
            $total += $item['hours'];
        }

        $this->table(['gitlab_created_at', 'project', 'issue', 'hours', 'description'], $stat);

        $this->warn(sprintf('Total spent time: %s', TimeHelper::getHoursIntervalAsString($total)));
    }

}
