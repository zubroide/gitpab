<?php

use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    const TYPE_VIEW = 'view';
    const TYPE_WRITE = 'write';

    protected $defaultResources = [
        self::TYPE_VIEW => [
            'index',
            'create',
            'show',
            'edit',
        ],
        self::TYPE_WRITE => [
            'store',
            'update',
        ]
    ];

    protected function generatePermissions(string $group, string $type)
    {
        $permissions = [];
        foreach ($this->defaultResources[$type] as $defaultResource) {
            $permissions[$group . '.' . $defaultResource] = $group . '.' . $defaultResource;
        }
        return $permissions;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Throwable
     */
    public function run()
    {
        // Hack for supporting upgrade from version 1.0.*
        DB::statement("UPDATE permissions SET name = 'project.index' WHERE name = 'View projects'");
        DB::statement("UPDATE permissions SET name = 'issue.index' WHERE name = 'View issues'");
        DB::statement("UPDATE permissions SET name = 'comment.index' WHERE name = 'View comments'");
        DB::statement("UPDATE permissions SET name = 'time.index' WHERE name = 'View spent time'");
        DB::statement("UPDATE permissions SET name = 'user.index' WHERE name = 'View users'");
        DB::statement("UPDATE permissions SET name = 'user.edit' WHERE name = 'Edit users'");
        Artisan::call('cache:clear');

        $defaultPermissions =
            ['home' => 'home'] +
            $this->generatePermissions('project', self::TYPE_VIEW) +
            $this->generatePermissions('milestone', self::TYPE_VIEW) +
            $this->generatePermissions('issue', self::TYPE_VIEW) +
            $this->generatePermissions('note', self::TYPE_VIEW) +
            $this->generatePermissions('comment', self::TYPE_VIEW) +
            $this->generatePermissions('time', self::TYPE_VIEW) +
            $this->generatePermissions('user', self::TYPE_VIEW);

        $roles = [
            User::ROLE_CONTRIBUTOR =>
                $defaultPermissions,
            User::ROLE_FINANCE =>
                $defaultPermissions +
                [
                    'contributor.rate' => 'contributor.rate',
                ] +
                $this->generatePermissions('contributor', self::TYPE_VIEW) +
                $this->generatePermissions('contributor', self::TYPE_WRITE) +
                $this->generatePermissions('payment', self::TYPE_VIEW) +
                $this->generatePermissions('payment', self::TYPE_WRITE),
            User::ROLE_ADMIN =>
                $defaultPermissions +
                $this->generatePermissions('user', self::TYPE_WRITE),
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
