<?php

namespace App\Console\Commands;

use App\Model\Repository\RoleRepositoryEloquent;
use App\Model\Service\Eloquent\EloquentUserService;
use App\Providers\AppServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->ask('User name');
        $email = $this->ask('User email');
        $password = Hash::make($this->secret('User password'));

        /** @var RoleRepositoryEloquent $roleRepo */
        $roleRepo = app(AppServiceProvider::ROLE_REPOSITORY);
        $roles = $roleRepo->all()->pluck('name')->toArray();
        $roles = $this->anticipate('Role', $roles);

        /** @var EloquentUserService $userService */
        $userService = app(AppServiceProvider::ELOQUENT_USER_SERVICE);
        $userService->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'roles' => $roles,
        ]);
    }
}
