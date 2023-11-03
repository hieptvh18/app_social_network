<?php

namespace Modules\Core\Providers;

use Modules\Core\Events\AfterUserCreatedExam;
use Modules\Core\Listeners\AssignInfoMission;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Core\Events\CheckExamMission;
use Modules\Core\Events\CreateExamConfigEvent;
use Modules\Core\Events\UserDoneGiftExchangeEvent;
use Modules\Core\Events\UserMissionDoneEvent;
use Modules\Core\Listeners\CheckExamMissionListener;
use Modules\Core\Listeners\CreateExamConfig;
use Modules\Core\Listeners\UserDoneGiftExchangeListener;
use Modules\Core\Listeners\UserMissionDoneListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [

        AfterUserCreatedExam::class => [
            AssignInfoMission::class,
        ],
        CheckExamMission::class => [
            CheckExamMissionListener::class
        ],
        UserMissionDoneEvent::class => [
            UserMissionDoneListener::class
        ],
        UserDoneGiftExchangeEvent::class => [
            UserDoneGiftExchangeListener::class
        ],
        CreateExamConfigEvent::class => [
            CreateExamConfig::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
