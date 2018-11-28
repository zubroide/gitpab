<?php

namespace App;

use App\Model\Entity\Contributor;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property int $contributor_id
 */
class User extends Authenticatable
{
    const ROLE_ADMIN = 'Admin';
    const ROLE_FINANCE = 'Finance';
    const ROLE_CONTRIBUTOR = 'Contributor';

    const PERMISSION_EDIT_USERS = 'user.edit';
    const PERMISSION_SHOW_PAYMENTS = 'payment.show';

    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'contributor_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function contributor()
    {
        return $this->belongsTo(Contributor::class, 'contributor_id', 'id');
    }

}
