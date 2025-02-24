<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\User;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index()
    {
        $events = $this->eventService->getPublic();
        return view('dashboard', compact('events'));
    }

    public function adminDashboard()
    {
        $events = $this->eventService->getAll();
        return view('admin.dashboard', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(StoreEventRequest $request)
    {
        $this->eventService->create($request);
        return redirect()->route('admin.dashboard')->with('success', 'Evento criado com sucesso!');
    }

    public function show(string $id)
    {
        $event = $this->eventService->getById($id);
        $users = User::all();
        return view('admin.events.show', compact('event', 'users'));
    }

    public function edit(string $id)
    {
        $event = $this->eventService->getById($id);
        return view('admin.events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, string $id)
    {
        $this->eventService->update($request, $id);
        return redirect()->route('admin.dashboard')->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $this->eventService->delete($id);
        return redirect()->route('admin.dashboard')->with('success', 'Evento excluído com sucesso!');
    }

    public function addParticipant(Request $request, string $id)
    {
        $message = $this->eventService->addParticipant($id, $request->user_id);

        return redirect()->route('admin.events.show', $id)->with(
            str_contains($message, 'sucesso') ? 'success' : 'error', 
            $message
        );
    }

    public function removeParticipant(string $eventId, string $userId)
    {
        $this->eventService->removeParticipant($eventId, $userId);
        return redirect()->route('admin.events.show', $eventId)->with('success', 'Participante removido com sucesso!');
    }
}
