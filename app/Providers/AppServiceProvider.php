<?php

namespace App\Providers;

use App\Model\Repository;
use App\Model\Service;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    const GROUP_MILESTONE   = 'group_milestone';
    const ISSUE             = 'issue';
    const NOTE              = 'note';
    const PROJECT           = 'project';
    const PROJECT_MILESTONE = 'project_milestone';
    const USER              = 'user';

    const ELOQUENT_SERVICE_NAMESPACE = 'service.eloquent';
    const GITLAB_SERVICE_NAMESPACE   = 'service.gitlab';

    const ELOQUENT_CONTRIBUTOR_SERVICE       = 'service.eloquent.contributor';
    const ELOQUENT_GROUP_MILESTONE_SERVICE   = 'service.eloquent.group_milestone';
    const ELOQUENT_ISSUE_SERVICE             = 'service.eloquent.issue';
    const ELOQUENT_LABEL_SERVICE             = 'service.eloquent.label';
    const ELOQUENT_NAMESPACES_SERVICE        = 'service.eloquent.namespaces';
    const ELOQUENT_NOTE_SERVICE              = 'service.eloquent.note';
    const ELOQUENT_PROJECT_MILESTONE_SERVICE = 'service.eloquent.project_milestone';
    const ELOQUENT_PROJECT_SERVICE           = 'service.eloquent.project';
    const ELOQUENT_SPENT_SERVICE             = 'service.eloquent.spent';
    const ELOQUENT_USER_SERVICE              = 'service.eloquent.user';

    const GITLAB_GROUP_MILESTONE_SERVICE   = 'service.gitlab.group_milestone';
    const GITLAB_ISSUE_SERVICE             = 'service.gitlab.issue';
    const GITLAB_NOTE_SERVICE              = 'service.gitlab.note';
    const GITLAB_PROJECT_MILESTONE_SERVICE = 'service.gitlab.project_milestone';
    const GITLAB_PROJECT_SERVICE           = 'service.gitlab.project';

    const UPDATE_SERVICE = 'service.update';

    const CONTRIBUTOR_REPOSITORY = 'repository.contributor';
    const ISSUE_REPOSITORY       = 'repository.issue';
    const LABEL_REPOSITORY       = 'repository.label';
    const MILESTONE_REPOSITORY   = 'repository.milestone';
    const NAMESPACES_REPOSITORY  = 'repository.namespaces';
    const NOTE_REPOSITORY        = 'repository.note';
    const PROJECT_REPOSITORY     = 'repository.project';
    const ROLE_REPOSITORY        = 'repository.role';
    const SPENT_REPOSITORY       = 'repository.spent';
    const USER_REPOSITORY        = 'repository.user';

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
            self::LABEL_REPOSITORY       => Repository\LabelRepositoryEloquent::class,
            self::MILESTONE_REPOSITORY   => Repository\MilestoneRepositoryEloquent::class,
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
            self::ELOQUENT_CONTRIBUTOR_SERVICE       => Service\Eloquent\EloquentContributorService::class,
            self::ELOQUENT_GROUP_MILESTONE_SERVICE   => Service\Eloquent\EloquentMilestoneService::class,
            self::ELOQUENT_ISSUE_SERVICE             => Service\Eloquent\EloquentIssueService::class,
            self::ELOQUENT_LABEL_SERVICE             => Service\Eloquent\EloquentLabelService::class,
            self::ELOQUENT_NAMESPACES_SERVICE        => Service\Eloquent\EloquentNamespacesService::class,
            self::ELOQUENT_NOTE_SERVICE              => Service\Eloquent\EloquentNoteService::class,
            self::ELOQUENT_PROJECT_MILESTONE_SERVICE => Service\Eloquent\EloquentMilestoneService::class,
            self::ELOQUENT_PROJECT_SERVICE           => Service\Eloquent\EloquentProjectService::class,
            self::ELOQUENT_SPENT_SERVICE             => Service\Eloquent\EloquentSpentService::class,
            self::ELOQUENT_USER_SERVICE              => Service\Eloquent\EloquentUserService::class,
        ];
        foreach ($eloquentServices as $key => $class) {
            $this->app->bind($key, $class);
        }

        $this->app->bind(self::UPDATE_SERVICE, Service\UpdateService::class);

        $gitlabServices = [
            self::GITLAB_GROUP_MILESTONE_SERVICE   => Service\Gitlab\GitlabGroupMilestoneService::class,
            self::GITLAB_ISSUE_SERVICE             => Service\Gitlab\GitlabIssueService::class,
            self::GITLAB_NOTE_SERVICE              => Service\Gitlab\GitlabNoteService::class,
            self::GITLAB_PROJECT_MILESTONE_SERVICE => Service\Gitlab\GitlabProjectMilestoneService::class,
            self::GITLAB_PROJECT_SERVICE           => Service\Gitlab\GitlabProjectService::class,
        ];
        foreach ($gitlabServices as $key => $class) {
            $this->app->bind($key, function () use ($class) {
                $guzzle = new Client();
                return new $class($guzzle, config('gitlab.token'), config('gitlab.default_per_page'));
            });
        }
    }
}
