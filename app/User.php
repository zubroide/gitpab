<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 */
class User extends Authenticatable
{
    const ROLE_ADMIN = 'Admin';
    const ROLE_FINANCE = 'Finance';
    const ROLE_CONTRIBUTOR = 'Contributor';

    const PERMISSION_VIEW_PROJECTS = 'View projects';
    const PERMISSION_VIEW_ISSUES = 'View issues';
    const PERMISSION_VIEW_COMMENTS = 'View comments';
    const PERMISSION_VIEW_SPENT_TIME = 'View spent time';
    const PERMISSION_VIEW_USERS = 'View users';
    const PERMISSION_EDIT_USERS = 'Edit users';
    const PERMISSION_VIEW_FINANCES = 'View finances';
    const PERMISSION_EDIT_FINANCES = 'Edit finances';

    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
