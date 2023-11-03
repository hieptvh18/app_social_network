<?php

namespace Modules\Core\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\AnonymousNotifiable;

class NotifyContactAdmin extends Notification implements ShouldQueue
{
    use Queueable;

    protected $contact;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $data = $this->toArray($notifiable);
        return (new MailMessage)
            ->subject('Thông tin liên hệ mới')
            ->theme('default')
            // ->action($this->contact['actionText'], $this->contact['actionURL'])
            ->markdown('core::vendor.notifications.adminContactEmail', $data);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $data = [
            'name' => $this->contact['name'],
            'email' => $this->contact['body']->email,
            'message' => $this->contact['body']->message
        ];
        return $data;
    }
}
