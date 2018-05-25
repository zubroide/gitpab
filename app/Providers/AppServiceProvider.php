<?php

namespace App\Providers;

use App\Model\Repository;
use App\Model\Service;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    const GITLAB_PROJECT_SERVICE = 'service.gitlab.project';
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
            self::PROJECT_REPOSITORY => Repository\ProjectRepositoryEloquent::class,
        ];
        foreach ($repositories as $key => $class) {
            $this->app->bind($key, $class);
        }

        $gitlabServices = [
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
