<?php

namespace App\Providers;

use App\Model\Repository;
use App\Model\Service;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    const ELOQUENT_ISSUE_SERVICE = 'service.eloquent.issue';
    const ELOQUENT_NOTE_SERVICE = 'service.eloquent.note';
    const ELOQUENT_PROJECT_SERVICE = 'service.eloquent.project';

    const GITLAB_ISSUE_SERVICE = 'service.gitlab.issue';
    const GITLAB_NOTE_SERVICE = 'service.gitlab.note';
    const GITLAB_PROJECT_SERVICE = 'service.gitlab.project';

    const ISSUE_REPOSITORY = 'repository.issue';
    const NOTE_REPOSITORY = 'repository.note';
    const PROJECT_REPOSITORY = 'repository.project';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $repositories = [
            self::ISSUE_REPOSITORY => Repository\IssueRepositoryEloquent::class,
            self::NOTE_REPOSITORY => Repository\NoteRepositoryEloquent::class,
            self::PROJECT_REPOSITORY => Repository\ProjectRepositoryEloquent::class,
        ];
        foreach ($repositories as $key => $class) {
            $this->app->bind($key, $class);
        }

        $eloquentServices = [
            self::ELOQUENT_ISSUE_SERVICE => [
                'class' => Service\Eloquent\EloquentIssueService::class,
                'repo' => self::ISSUE_REPOSITORY,
            ],
            self::ELOQUENT_NOTE_SERVICE => [
                'class' => Service\Eloquent\EloquentNoteService::class,
                'repo' => self::NOTE_REPOSITORY,
            ],
            self::ELOQUENT_PROJECT_SERVICE => [
                'class' => Service\Eloquent\EloquentProjectService::class,
                'repo' => self::PROJECT_REPOSITORY,
            ],
        ];
        foreach ($eloquentServices as $key => $item) {
            $this->app->bind($key, function () use ($item) {
                $class = $item['class'];
                $repo = app($item['repo']);
                return new $class($repo);
            });
        }

        $gitlabServices = [
            self::GITLAB_ISSUE_SERVICE => Service\Gitlab\GitlabIssueService::class,
            self::GITLAB_NOTE_SERVICE => Service\Gitlab\GitlabNoteService::class,
            self::GITLAB_PROJECT_SERVICE => Service\Gitlab\GitlabProjectService::class,
        ];
        foreach ($gitlabServices as $key => $class) {
            $this->app->bind($key, function () use ($class) {
                $guzzle = new Client();
                return new $class($guzzle, config('gitlab.token'));
            });
        }
    }
}
