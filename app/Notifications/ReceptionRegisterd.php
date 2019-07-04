<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ReceptionRegisterd extends Notification
{
    use Queueable;

    protected $reception;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reception)
    {
        //
        $this->reception = $reception;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database' , 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => $notifiable->type,
            'id' => $notifiable->id,
            //'reception_id' => $this->reception->id,
        ];
    }
}
