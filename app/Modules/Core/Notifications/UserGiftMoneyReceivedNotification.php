<?php

namespace Modules\Core\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserGiftMoneyReceivedNotification extends Notification
{
    use Queueable;

    protected $mission_gift;
    protected $user;
    protected $histoty_gift;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $mission_gift, $histoty_gift)
    {
        $this->onQueue('notification');
        $this->user = $user;
        $this->mission_gift = $mission_gift;
        $this->histoty_gift = $histoty_gift;
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
            ->subject('Đổi thưởng thành công')
            ->theme('default')
            ->markdown('core::vendor.notifications.userGiftMoneyReceived', $data);
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
            'name' =>  $this->user->info->first_name  . ' ' . $this->user->info->last_name,
            'mission_gift_name' => $this->mission_gift->name,
        ];
        return $data;
    }
}
