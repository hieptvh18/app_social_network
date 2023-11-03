<?php

namespace Modules\Core\Providers;

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

        $this->app->bind(\Modules\Core\Repositories\PlanRepository::class, \Modules\Core\Repositories\PlanRepositoryEloquent::class);
        $this->app->bind(\Modules\Core\Repositories\FaqRepository::class, \Modules\Core\Repositories\FaqRepositoryEloquent::class);
        $this->app->bind(\Modules\Core\Repositories\FaqCategoryRepository::class, \Modules\Core\Repositories\FaqCategoryRepositoryEloquent::class);
        $this->app->bind(\Modules\Core\Repositories\PlanFeatureRepository::class, \Modules\Core\Repositories\PlanFeatureRepositoryEloquent::class);

        $this->app->bind(\Modules\Core\Repositories\ActivityLogRepository::class, \Modules\Core\Repositories\ActivityLogRepositoryEloquent::class);
        $this->app->bind(\Modules\Core\Repositories\ContactRepository::class, \Modules\Core\Repositories\ContactRepositoryEloquent::class);

        $this->app->bind(\Modules\Core\Repositories\BlogCategoryRepository::class, \Modules\Core\Repositories\BlogCategoryRepositoryEloquent::class);
        $this->app->bind(\Modules\Core\Repositories\BlogTagRepository::class, \Modules\Core\Repositories\BlogTagRepositoryEloquent::class);
        $this->app->bind(\Modules\Core\Repositories\BlogRepository::class, \Modules\Core\Repositories\BlogRepositoryEloquent::class);
        $this->app->bind(\Modules\Core\Repositories\InfoMissionRepository::class, \Modules\Core\Repositories\InfoMissionRepositoryEloquent::class);
        $this->app->bind(\Modules\Core\Repositories\UserMissionRepository::class, \Modules\Core\Repositories\UserMissionRepositoryEloquent::class);
        $this->app->bind(\Modules\Core\Repositories\MissionGiftRepository::class, \Modules\Core\Repositories\MissionGiftRepositoryEloquent::class);
        $this->app->bind(\Modules\Core\Repositories\HistoryGiftRepository::class, \Modules\Core\Repositories\HistoryGiftRepositoryEloquent::class);
        $this->app->bind(\Modules\Core\Repositories\RewardPointRepository::class, \Modules\Core\Repositories\RewardPointRepositoryEloquent::class);
        $this->app->bind(\Modules\Core\Repositories\CustomerFeedbackRepository::class, \Modules\Core\Repositories\CustomerFeedbackRepositoryEloquent::class);
        $this->app->bind(\Modules\Core\Repositories\BizappRepository::class, \Modules\Core\Repositories\BizappRepositoryEloquent::class);
        //:end-bindings::end-bindings:
    }
}
