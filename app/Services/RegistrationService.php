<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Registration;
use App\Notifications\RegistrationCancelled;
use App\Notifications\RegistrationConfirmed;
use Illuminate\Support\Facades\Auth;

class RegistrationService
{
    public function registerUserToEvent(int $eventId): string
    {
        $event = Event::findOrFail($eventId);

        if ($event->status !== 'aberto') {
            return 'Este evento não está aberto para inscrições.';
        }

        if ($event->registrations()->count() >= $event->capacity) {
            return 'Este evento já atingiu a capacidade máxima.';
        }

        if (Registration::where('user_id', Auth::id())->where('event_id', $eventId)->exists()) {
            return 'Você já está inscrito neste evento.';
        }

        Registration::create([
            'user_id' => Auth::id(),
            'event_id' => $eventId,
        ]);

        auth()->user()->notify(new RegistrationConfirmed($event));

        return 'Inscrição realizada com sucesso!';
    }

    public function cancelUserRegistration(int $eventId): string
    {
        $registration = Registration::where('user_id', Auth::id())
            ->where('event_id', $eventId)
            ->first();

        if (!$registration) {
            return 'Inscrição não encontrada.';
        }

        $registration->delete();
        auth()->user()->notify(new RegistrationCancelled($registration->event));

        return 'Inscrição cancelada com sucesso.';
    }
}
