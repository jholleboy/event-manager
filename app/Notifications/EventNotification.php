<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Event;

class EventNotification extends Notification
{
    public $event;
    public $message;

    public function __construct(Event $event, string $message)
    {
        $this->event = $event;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('📢 Novo Evento: ' . $this->event->title)
            ->line($this->message)
            ->line('Obrigado por usar nosso sistema!');
    }

    public function toArray($notifiable)
    {
        return [
            'event_id' => $this->event->id,
            'title' => $this->event->title,
            'message' => $this->message,
        ];
    }
}
