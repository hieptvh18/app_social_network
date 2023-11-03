<?php

namespace Modules\Core\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class GiftMoneyDatabaseNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $action;
    protected $info_method_receive;
    protected $method_receive;
    protected $subject;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $action, $subject, $info_method_receive, $method_receive)
    {
        $this->onQueue('notification');
        $this->user = $user;
        $this->action = $action;
        $this->subject = $subject;
        $this->info_method_receive = $info_method_receive;
        $this->method_receive = $method_receive;
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
            'avatar_url' => $this->user->info['avatar_url'],
            'first_name' => $this->user->info['first_name'],
            'last_name' => $this->user->info['last_name'],
            'action' => __('notification.action.' . $this->action),
            'subject' => $this->subject,
            'info_method_receive' => $this->info_method_receive,
            'method_receive' => $this->method_receive
        ];
    }
}
