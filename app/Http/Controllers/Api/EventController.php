<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Services\Api\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(): JsonResponse
    {
        return $this->eventService->getAll();
    }

    public function store(StoreEventRequest $request): JsonResponse
    {
        return $this->eventService->create($request);
    }

    public function show(string $id): JsonResponse
    {
        return $this->eventService->getById($id);
    }

    public function update(UpdateEventRequest $request, string $id): JsonResponse
    {
        return $this->eventService->update($request, $id);
    }

    public function destroy(string $id): JsonResponse
    {
        return $this->eventService->delete($id);
    }

    public function addParticipant(Request $request, string $id): JsonResponse
    {
        return $this->eventService->addParticipant($id, $request->user_id);
    }

    public function removeParticipant(string $eventId, string $userId): JsonResponse
    {
        return $this->eventService->removeParticipant($eventId, $userId);
    }
}
