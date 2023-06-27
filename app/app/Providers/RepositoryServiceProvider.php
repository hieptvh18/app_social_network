<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // user repository
        $this->app->bind(\App\Repositories\Interfaces\UserRepositoryInterface::class,\App\Repositories\UserRepository::class);
        // post repository
        $this->app->bind(\App\Repositories\Interfaces\PostRepositoryInterface::class,\App\Repositories\PostRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
