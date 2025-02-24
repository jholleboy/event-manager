<?php

namespace App\Services\Api;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\User;
use App\Notifications\EventNotification;
use Illuminate\Http\JsonResponse;

class EventService
{
    public function getAll(): JsonResponse
    {
        $events = Event::withCount('registrations')->get();

        return response()->json([
            'events' => $events->map(fn($event) => new EventResource($event, false))
        ], 200);
    }

    public function create(StoreEventRequest $request): JsonResponse
    {
        $event = Event::create($request->validated());

        $users = User::where('role', 'user')->get();
        foreach ($users as $user) {
            $user->notify(new EventNotification($event, "Um novo evento foi criado: {$event->title}"));
        }

        return response()->json([
            'message' => 'Evento criado com sucesso!',
            'event' => new EventResource($event)
        ], 201);
    }

    public function getById(string $id): JsonResponse
    {
        $event = Event::with('registrations.user')->findOrFail($id);

        return response()->json([
            'event' => new EventResource($event, true)
        ], 200);
    }

    public function update(UpdateEventRequest $request, string $id): JsonResponse
    {
        $event = Event::findOrFail($id);
        $event->update($request->validated());

        $users = User::where('role', 'user')->get();
        foreach ($users as $user) {
            $user->notify(new EventNotification($event, "O evento '{$event->title}' foi atualizado."));
        }

        return response()->json([
            'message' => 'Evento atualizado com sucesso!',
            'event' => new EventResource($event)
        ], 200);
    }

    public function delete(string $id): JsonResponse
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json([], 204);
    }

    public function addParticipant(string $id, int $userId): JsonResponse
    {
        $event = Event::findOrFail($id);

        if ($event->registrations()->where('user_id', $userId)->exists()) {
            return response()->json(['error' => 'Usuário já está inscrito neste evento.'], 409);
        }

        if ($event->registrations()->count() >= $event->capacity) {
            return response()->json(['error' => 'O evento atingiu sua capacidade máxima.'], 403);
        }

        $event->registrations()->create(['user_id' => $userId]);

        return response()->json(['message' => 'Participante adicionado com sucesso!'], 201);
    }

    public function removeParticipant(string $eventId, string $userId): JsonResponse
    {
        $event = Event::findOrFail($eventId);
        $event->registrations()->where('user_id', $userId)->delete();

        return response()->json([], 204);
    }
}
