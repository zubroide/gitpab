<?php

namespace App\Model\Service\Eloquent;

use App\Providers\AppServiceProvider;
use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EloquentUserService extends CrudServiceAbstract
{
    public function __construct()
    {
        $this->repository = app(AppServiceProvider::USER_REPOSITORY);
    }

    /**
     * Store linked data
     *
     * @param User $object
     * @param array $attributes
     */
    protected function saveObjectRelationships($object, $attributes)
    {
        $user = Auth::user();
        if ($user->hasPermissionTo(User::PERMISSION_EDIT_USERS)) {
            $roleIds = Arr::get($attributes, 'roles', []);
            DB::beginTransaction();
            try {
                $object->syncRoles($roleIds);
                DB::commit();
            }
            catch (\Throwable $e) {
                DB::rollback();
                throw $e;
            }
        }
    }
}
