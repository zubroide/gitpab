<?php

namespace App\Providers;

use App\Model\Service\GitlabProjectService;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    const GITLAB_PROJECT_SERVICE = 'service.gitlab.project';

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
        $gitlabServices = [
            self::GITLAB_PROJECT_SERVICE => GitlabProjectService::class,
        ];

        foreach ($gitlabServices as $key => $class) {
            $this->app->bind($key, function () use ($class) {
                $guzzle = new Client();
                return new $class($guzzle, config('gitlab.token'));
            });
        }
    }
}
