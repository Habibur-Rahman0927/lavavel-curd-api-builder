<?php

namespace App\Providers;

use App\Repositories\Role\IRoleRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\IUserRepository;
use App\Repositories\User\UserRepository;
use App\Services\Role\IRoleService;
use App\Services\Role\RoleService;
use App\Services\User\IUserService;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class ServiceRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $repositories = [
            IRoleRepository::class => RoleRepository::class,
            IUserRepository::class => UserRepository::class,
        ];

        $services = [
            IRoleService::class => RoleService::class,
            IUserService::class => UserService::class,
        ];
        $bindings = array_merge($repositories, $services);
        $this->bindServiceRepositories($bindings);
    }

    /**
     * Helper function to bind repository interfaces to their implementations
     */
    protected function bindServiceRepositories(array $repositories): void
    {
        foreach ($repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
