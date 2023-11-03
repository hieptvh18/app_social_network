<?php

namespace Modules\Core\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyRefusedApprove extends Notification
{
    use Queueable;

    protected $mission;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mission)
    {
        $this->mission = $mission;
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
            ->subject('Từ chối phê duyệt')
            ->theme('default')
            ->markdown('core::vendor.notifications.refusedApproveMission', $data);
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
            'fullname' => $this->mission->user->info->first_name  .' '. $this->mission->user->info->last_name,
            'mission_name' => $this->mission->name,
            'reason_refuse_approve' => $this->mission->reason_refuse_approve
        ];
        return $data;
    }
}
