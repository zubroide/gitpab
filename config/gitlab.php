<?php

return [

    'urls' => [
        'project-list' => 'https://gitlab.com/api/v3/projects?private_token=:token',
        'project-item' => 'https://gitlab.com/api/v3/projects/:project_id?private_token=:token',
        'project-issue-list' => 'https://gitlab.com/api/v3/projects/:project_id/issues?private_token=:token',
        'project-issue-item' => 'https://gitlab.com/api/v3/projects/:project_id/issues/:issue_id?private_token=:token',
        'project-issue-comment-list' => 'https://gitlab.com/api/v3/projects/:project_id/issues/:issue_id/notes?private_token=:token',
    ],

    'token' => env('GITLAB_PRIVATE_TOKEN'),

];
