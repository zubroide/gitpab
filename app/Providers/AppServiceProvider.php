<?php

namespace App\Providers;

use App\Model\Repository;
use App\Model\Service;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    const ISSUE   = 'issue';
    const NOTE    = 'note';
    const PROJECT = 'project';
    const USER    = 'user';

    const ELOQUENT_SERVICE_NAMESPACE = 'service.eloquent';
    const GITLAB_SERVICE_NAMESPACE   = 'service.gitlab';

    const ELOQUENT_CONTRIBUTOR_SERVICE = 'service.eloquent.contributor';
    const ELOQUENT_ISSUE_SERVICE       = 'service.eloquent.issue';
    const ELOQUENT_NOTE_SERVICE        = 'service.eloquent.note';
    const ELOQUENT_NAMESPACES_SERVICE  = 'service.eloquent.namespaces';
    const ELOQUENT_PROJECT_SERVICE     = 'service.eloquent.project';
    const ELOQUENT_SPENT_SERVICE       = 'service.eloquent.spent';
    const ELOQUENT_USER_SERVICE        = 'service.eloquent.user';

    const GITLAB_ISSUE_SERVICE   = 'service.gitlab.issue';
    const GITLAB_NOTE_SERVICE    = 'service.gitlab.note';
    const GITLAB_PROJECT_SERVICE = 'service.gitlab.project';

    const UPDATE_SERVICE = 'service.update';

    const CONTRIBUTOR_REPOSITORY = 'repository.contributor';
    const ISSUE_REPOSITORY       = 'repository.issue';
    const NAMESPACES_REPOSITORY  = 'repository.namespaces';
    const NOTE_REPOSITORY        = 'repository.note';
    const PROJECT_REPOSITORY     = 'repository.project';
    const SPENT_REPOSITORY       = 'repository.spent';
    const USER_REPOSITORY        = 'repository.user';
    const ROLE_REPOSITORY        = 'repository.role';

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
            self::CONTRIBUTOR_REPOSITORY => Repository\ContributorRepositoryEloquent::class,
            self::ISSUE_REPOSITORY       => Repository\IssueRepositoryEloquent::class,
            self::NAMESPACES_REPOSITORY  => Repository\NamespacesRepositoryEloquent::class,
            self::NOTE_REPOSITORY        => Repository\NoteRepositoryEloquent::class,
            self::PROJECT_REPOSITORY     => Repository\ProjectRepositoryEloquent::class,
            self::SPENT_REPOSITORY       => Repository\SpentRepositoryEloquent::class,
            self::USER_REPOSITORY        => Repository\UserRepositoryEloquent::class,
            self::ROLE_REPOSITORY        => Repository\RoleRepositoryEloquent::class,
        ];
        foreach ($repositories as $key => $class) {
            $this->app->bind($key, $class);
        }

        $eloquentServices = [
            self::ELOQUENT_CONTRIBUTOR_SERVICE => Service\Eloquent\EloquentContributorService::class,
            self::ELOQUENT_ISSUE_SERVICE       => Service\Eloquent\EloquentIssueService::class,
            self::ELOQUENT_NAMESPACES_SERVICE  => Service\Eloquent\EloquentNamespacesService::class,
            self::ELOQUENT_NOTE_SERVICE        => Service\Eloquent\EloquentNoteService::class,
            self::ELOQUENT_PROJECT_SERVICE     => Service\Eloquent\EloquentProjectService::class,
            self::ELOQUENT_SPENT_SERVICE       => Service\Eloquent\EloquentSpentService::class,
            self::ELOQUENT_USER_SERVICE        => Service\Eloquent\EloquentUserService::class,
        ];
        foreach ($eloquentServices as $key => $class) {
            $this->app->bind($key, $class);
        }

        $this->app->bind(self::UPDATE_SERVICE, Service\UpdateService::class);

        $gitlabServices = [
            self::GITLAB_ISSUE_SERVICE   => Service\Gitlab\GitlabIssueService::class,
            self::GITLAB_NOTE_SERVICE    => Service\Gitlab\GitlabNoteService::class,
            self::GITLAB_PROJECT_SERVICE => Service\Gitlab\GitlabProjectService::class,
        ];
        foreach ($gitlabServices as $key => $class) {
            $this->app->bind($key, function () use ($class) {
                $guzzle = new Client();
                return new $class($guzzle, config('gitlab.token'), config('gitlab.default_per_page'));
            });
        }
    }
}
