<?php

namespace App\Console\Commands;

use App\Model\Service\Eloquent\EloquentNoteService;
use App\Model\Service\Gitlab\GitlabNoteService;
use App\Providers\AppServiceProvider;

/**
 * @property EloquentNoteService $eloquentService
 * @property GitlabNoteService $gitlabService
 */
class NoteGetList extends GitlabCommandAbstract
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'note:get-list {--P|project_id= : Project id} {--I|issue_id= : Issue id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get comments for specified project issue from Gitlab';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->eloquentService = app(AppServiceProvider::ELOQUENT_NOTE_SERVICE);
        $this->gitlabService = app(AppServiceProvider::GITLAB_NOTE_SERVICE);
    }

    protected function getHeaders(): array
    {
        return [
            'id',
            'body',
            'author_id',
        ];
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getUrlParameters(): array
    {
        if (!$this->option('project_id'))
        {
            throw new \Exception('project_id must be specified');
        }

        if (!$this->option('issue_id'))
        {
            throw new \Exception('issue_id must be specified');
        }

        return [
            ':project_id' => $this->option('project_id'),
            ':issue_id' => $this->option('issue_id'),
        ];
    }

}
