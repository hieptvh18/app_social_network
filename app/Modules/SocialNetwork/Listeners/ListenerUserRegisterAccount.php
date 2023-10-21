<?php

namespace Modules\SocialNetwork\Listeners;

use Illuminate\Support\Facades\Notification;
use Modules\SocialNetwork\Events\EventUserRegisterAccount;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\SocialNetwork\Notifications\NotificationUserRegisterAccount;

class ListenerUserRegisterAccount implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param EventUserRegisterAccount $event
     * @return void
     */
    public function handle(EventUserRegisterAccount $event): void
    {
        $user = $event->user;
        Notification::route('mail',$user->email)->notify(new NotificationUserRegisterAccount($user));
    }
}
