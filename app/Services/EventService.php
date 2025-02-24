<?php

namespace App\Services;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\User;
use App\Notifications\EventNotification;
use Illuminate\Database\Eloquent\Collection;

class EventService
{
    public function getPublic(): Collection
    {
        return Event::abertos()->get();
    }

    public function getAll(): Collection
    {
        return Event::all();
    }

    public function create(StoreEventRequest $request): void
    {
        $event = Event::create($request->validated());

        $users = User::where('role', 'user')->get();
        foreach ($users as $user) {
            $user->notify(new EventNotification($event, "Um novo evento foi criado: {$event->title}"));
        }
    }

    public function getById(string $id): Event
    {
        return Event::with('registrations.user')->findOrFail($id);
    }

    public function update(UpdateEventRequest $request, string $id): void
    {
        $event = Event::findOrFail($id);
        $event->update($request->validated());
        $users = User::where('role', 'user')->get();
        foreach ($users as $user) {
            $user->notify(new EventNotification($event, "O evento '{$event->title}' foi atualizado."));
        }
    }

    public function delete(string $id): void
    {
        $event = Event::findOrFail($id);
        $event->delete();
    }

    public function addParticipant(string $eventId, int $userId): string
    {
        $event = Event::findOrFail($eventId);
        $user = User::findOrFail($userId);

        if ($event->registrations()->where('user_id', $user->id)->exists()) {
            return 'Usuário já está inscrito neste evento.';
        }

        if ($event->registrations()->count() >= $event->capacity) {
            return 'O evento já atingiu sua capacidade máxima.';
        }

        $event->registrations()->create(['user_id' => $user->id]);

        return 'Participante adicionado com sucesso!';
    }

    public function removeParticipant(string $eventId, string $userId): void
    {
        $event = Event::findOrFail($eventId);
        $event->registrations()->where('user_id', $userId)->delete();
    }
}
