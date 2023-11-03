<?php

namespace Modules\Core\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyActivePlan extends Notification
{
    use Queueable;

    protected $order, $planSubscription;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $planSubscription)
    {
        $this->onQueue('notification');
        $this->order = $order;
        $this->planSubscription = $planSubscription;
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
            ->subject('Nâng cấp tài khoản VIP thành công')
            ->markdown('email.invoice_paid', $data);
        // ->action('Notification Action', 'https://laravel.com')
        // ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $order_code = 100000 + $this->order->id;
        $qty = $this->order->items->quantity;
        // dd($this->order);
        $payment = $this->order->paymentMethod;
        $data = [
            'fullname' => $notifiable->info->first_name,
            'order_code' => '#' . $order_code,
            'month' => $qty,
            'payment_method' => $payment->name,
            'qr_code' => $payment->qr_code,
            'order_total' => number_format($this->order->total_amount) . 'VNĐ',
            'subscription_start_date' => $this->planSubscription->starts_at->format('H:i:s d-m-Y'),
            'subscription_end_date' => $this->planSubscription->ends_at->format('H:i:s d-m-Y')
        ];
        return $data;
    }
}
