<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Event;

class RegistrationConfirmed extends Notification
{
    use Queueable;

    public $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; 
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('✅ Inscrição Confirmada - ' . $this->event->title)
            ->line('Parabéns! Sua inscrição no evento foi confirmada.')
            ->line('Obrigado por participar!');
    }

    public function toArray($notifiable)
    {
        return [
            'event_id' => $this->event->id,
            'title' => $this->event->title,
            'message' => 'Sua inscrição foi confirmada para este evento.',
        ];
    }
}
