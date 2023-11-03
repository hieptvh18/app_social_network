<?php

namespace Modules\Core\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserDatabaseNotification extends Notification
{
    use Queueable;

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    // public $queue = 'notification';

    protected $action;
    protected $causer;
    protected $subject;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $causer, $action, $subject)
    {
        $this->onQueue('notification');
        $this->causer = $causer;
        $this->action = $action;
        $this->subject = $subject;
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
            'avatar_url' => $this->causer->info->avatar_url,
            'first_name' => $this->causer->info->first_name,
            'last_name' => $this->causer->info->last_name,
            'action' => __('notification.action.' . $this->action),
            'subject' => $this->subject
        ];
    }
}
