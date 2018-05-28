<?php

$gitlabHost = env('GITLAB_HOST', 'https://gitlab.com/');

return [

    'urls' => [
        'host' => $gitlabHost,
        'project-list' => $gitlabHost . 'api/v3/projects',
        'project-item' => $gitlabHost . 'api/v3/projects/:project_id',
        'project-issue-list' => $gitlabHost . 'api/v3/projects/:project_id/issues',
        'project-issue-item' => $gitlabHost . 'api/v3/projects/:project_id/issues/:issue_id',
        'project-issue-note-list' => $gitlabHost . 'api/v3/projects/:project_id/issues/:issue_id/notes',
    ],

    'token' => env('GITLAB_PRIVATE_TOKEN'),

    'default_per_page' => env('GITLAB_DEFAULT_PER_PAGE', 100),

    'restrictions' => [
        // int[]|null
        'project_ids' => env('GITLAB_RESTRICTIONS_PROJECT_IDS')
            ? explode(',', env('GITLAB_RESTRICTIONS_PROJECT_IDS'))
            : null,
    ],

];
