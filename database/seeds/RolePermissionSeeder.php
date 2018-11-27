<?php

use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Throwable
     */
    public function run()
    {
        $roles = [
            User::ROLE_CONTRIBUTOR => [
                User::PERMISSION_VIEW_PROJECTS,
                User::PERMISSION_VIEW_ISSUES,
                User::PERMISSION_VIEW_COMMENTS,
                User::PERMISSION_VIEW_SPENT_TIME,
                User::PERMISSION_VIEW_USERS,
            ],
            User::ROLE_FINANCE => [
                User::PERMISSION_VIEW_PROJECTS,
                User::PERMISSION_VIEW_ISSUES,
                User::PERMISSION_VIEW_COMMENTS,
                User::PERMISSION_VIEW_SPENT_TIME,
                User::PERMISSION_VIEW_USERS,
                User::PERMISSION_VIEW_PAYMENTS,
                User::PERMISSION_EDIT_PAYMENTS,
            ],
            User::ROLE_ADMIN => [
                User::PERMISSION_VIEW_PROJECTS,
                User::PERMISSION_VIEW_ISSUES,
                User::PERMISSION_VIEW_COMMENTS,
                User::PERMISSION_VIEW_SPENT_TIME,
                User::PERMISSION_VIEW_USERS,
                User::PERMISSION_EDIT_USERS,
            ],
        ];

        $permissions = [];
        foreach ($roles as $role => $rolePermissions) {
            foreach ($rolePermissions as $rolePermission) {
                $permissions[$rolePermission] = $rolePermission;
            }
        }

        // Create permissions
        foreach ($permissions as $permission) {
            try {
                Permission::create(['name' => $permission]);
            }
            catch (\Throwable $e) {
                if (!($e instanceof PermissionAlreadyExists)) {
                    throw $e;
                }
            }
        }

        // Create roles
        foreach ($roles as $role => $rolePermissions) {
            try {
                Role::create(['name' => $role]);
            }
            catch (\Throwable $e) {
                if (!($e instanceof RoleAlreadyExists)) {
                    throw $e;
                }
            }
        }

        // Assign permissions
        foreach ($roles as $role => $rolePermissions) {
            $role = Role::findByName($role);
            foreach ($rolePermissions as $rolePermission) {
                try {
                    $role->givePermissionTo($rolePermission);
                }
                catch (\Throwable $e) {
                    if (!($e instanceof QueryException && $e->getCode() == 23505)) {
                        throw $e;
                    }
                }
            }
        }
    }
}
