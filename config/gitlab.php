<?php

return [

    'urls' => [
        'project-list' => 'https://gitlab.com/api/v3/projects',
        'project-item' => 'https://gitlab.com/api/v3/projects/:project_id',
        'project-issue-list' => 'https://gitlab.com/api/v3/projects/:project_id/issues',
        'project-issue-item' => 'https://gitlab.com/api/v3/projects/:project_id/issues/:issue_id',
        'project-issue-note-list' => 'https://gitlab.com/api/v3/projects/:project_id/issues/:issue_id/notes',
    ],

    'token' => env('GITLAB_PRIVATE_TOKEN'),

    'default_per_page' => env('GITLAB_DEFAULT_PER_PAGE', 100),

];
