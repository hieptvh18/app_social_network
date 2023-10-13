<?php

namespace Modules\SocialNetwork\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function boot()
    {
        $this->app->bind(\Modules\SocialNetwork\Repositories\PostRepository::class, \Modules\SocialNetwork\Repositories\PostRepositoryEloquent::class);
        //:end-bindings::end-bindings:
    }
}
