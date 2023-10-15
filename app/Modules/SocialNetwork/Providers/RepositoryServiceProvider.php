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
        $this->app->bind(\Modules\SocialNetwork\Repositories\PostRepository::class, \Modules\SocialNetwork\Repositories\PostRepositoryEloquent::class);
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
        $this->app->bind(\Modules\SocialNetwork\Repositories\ChatRepository::class, \Modules\SocialNetwork\Repositories\ChatRepositoryEloquent::class);
        $this->app->bind(\Modules\SocialNetwork\Repositories\CommentRepository::class, \Modules\SocialNetwork\Repositories\CommentRepositoryEloquent::class);
        $this->app->bind(\Modules\SocialNetwork\Repositories\NotificationRepository::class, \Modules\SocialNetwork\Repositories\NotificationRepositoryEloquent::class);
        $this->app->bind(\Modules\SocialNetwork\Repositories\StoryRepository::class, \Modules\SocialNetwork\Repositories\StoryRepositoryEloquent::class);
        $this->app->bind(\Modules\SocialNetwork\Repositories\UserRepository::class, \Modules\SocialNetwork\Repositories\UserRepositoryEloquent::class);
        //:end-bindings::end-bindings:
    }
}
