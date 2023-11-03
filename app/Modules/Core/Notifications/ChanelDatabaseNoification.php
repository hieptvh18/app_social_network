<?php

namespace Modules\Core\Notifications;

use Illuminate\Bus\Queueable;
use Modules\Quiz\Models\ExamChanel;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ChanelDatabaseNoification extends Notification
{
    use Queueable;

    protected $action;
    protected $chanel;
    protected $subject;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ExamChanel $chanel, $action, $subject)
    {
        $this->onQueue('notification');
        $this->chanel = $chanel;
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
            'avatar_url' => $this->chanel->avatar,
            'first_name' => $this->chanel->name,
            'last_name' => '',
            'action' => __('notification.action.' . $this->action),
            'subject' => $this->subject
        ];
    }
}
