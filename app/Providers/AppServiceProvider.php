<?php

namespace App\Providers;

use App\Model\Repository;
use App\Model\Service;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    const GITLAB_ISSUE_SERVICE = 'service.gitlab.issue';
    const GITLAB_PROJECT_SERVICE = 'service.gitlab.project';

    const ISSUE_REPOSITORY = 'repository.issue';
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
            self::PROJECT_REPOSITORY => Repository\ProjectRepositoryEloquent::class,
        ];
        foreach ($repositories as $key => $class) {
            $this->app->bind($key, $class);
        }

        $gitlabServices = [
            self::GITLAB_ISSUE_SERVICE => [
                'class' => Service\GitlabIssueService::class,
                'repo' => self::ISSUE_REPOSITORY,
            ],
            self::GITLAB_PROJECT_SERVICE => [
                'class' => Service\GitlabProjectService::class,
                'repo' => self::PROJECT_REPOSITORY,
            ],
        ];
        foreach ($gitlabServices as $key => $item) {
            $this->app->bind($key, function () use ($item) {
                $class = $item['class'];
                $repo = app($item['repo']);
                $guzzle = new Client();
                return new $class($repo, $guzzle, config('gitlab.token'));
            });
        }
    }
}
