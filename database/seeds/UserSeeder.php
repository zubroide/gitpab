<?php

use App\Model\Repository\RoleRepositoryEloquent;
use App\Model\Service\Eloquent\EloquentUserService;
use App\Providers\AppServiceProvider;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User
        DB::beginTransaction();
        try {
            $name = 'admin';
            $email = 'admin@admin';
            $password = Hash::make('admin');

            /** @var EloquentUserService $userService */
            $userService = app(AppServiceProvider::ELOQUENT_USER_SERVICE);
            /** @var \App\User $user */
            $user = $userService->create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);

            DB::commit();
        }
        catch (\Throwable $e) {
            DB::rollback();
            if (!($e instanceof QueryException && $e->getCode() == 23505)) {
                throw $e;
            }
            return;
        }

        // Roles
        DB::beginTransaction();
        try {
            /** @var RoleRepositoryEloquent $roleRepo */
            $roleRepo = app(AppServiceProvider::ROLE_REPOSITORY);
            $roles = $roleRepo->all()->pluck('name')->toArray();

            $user->syncRoles($roles);

            DB::commit();
        }
        catch (\Throwable $e) {
            DB::rollback();
            if (!($e instanceof QueryException && $e->getCode() == 23505)) {
                throw $e;
            }
        }
    }
}
