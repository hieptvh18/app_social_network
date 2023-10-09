<?php

namespace Modules\Notification\Providers;

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
        $this->app->bind(\Modules\Notification\Repositories\DeviceTokenRepository::class, \Modules\Notification\Repositories\DeviceTokenRepositoryEloquent::class);
        //:end-bindings::end-bindings:
    }
}
