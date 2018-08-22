<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $role = Role::create(['name' => User::ROLE_CONTRIBUTOR]);
            $permissions = [
                Permission::create(['name' => User::PERMISSION_VIEW_PROJECTS]),
                Permission::create(['name' => User::PERMISSION_VIEW_ISSUES]),
                Permission::create(['name' => User::PERMISSION_VIEW_COMMENTS]),
                Permission::create(['name' => User::PERMISSION_VIEW_SPENT_TIME]),
                Permission::create(['name' => User::PERMISSION_VIEW_USERS]),
            ];
            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }

            $role = Role::create(['name' => User::ROLE_ADMIN]);
            $permissions[] = Permission::create(['name' => User::PERMISSION_EDIT_USERS]);
            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }
            DB::commit();
        }
        catch (\Throwable $e) {
            DB::rollback();
            if (!($e instanceof RoleAlreadyExists)) {
                throw $e;
            }
        }
    }
}
