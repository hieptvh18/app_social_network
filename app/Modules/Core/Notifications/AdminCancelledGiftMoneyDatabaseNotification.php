<?php

namespace Modules\Core\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminCancelledGiftMoneyDatabaseNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $action;
    protected $mission_gift;
    protected $point;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $mission_gift, $action, $point)
    {
        $this->onQueue('notification');
        $this->user = $user;
        $this->action = $action;
        $this->mission_gift = $mission_gift;
        $this->point = $point;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'action' => __('notification.action.' . $this->action),
            'mission_gift' => $this->mission_gift,
            'point' => $this->point
        ];
    }
}
