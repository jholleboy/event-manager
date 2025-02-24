@extends('layouts.app')

@section('title', 'Detalhes do Evento')

@vite(['resources/css/admin/event-show.css']) 

@section('content')
<div class="event-details-container">
    <h2 class="event-title">{{ $event->title }}</h2>

    <p class="event-info"><strong>Descrição:</strong> {{ $event->description }}</p>
    <p class="event-info"><strong>Localização:</strong> {{ $event->location }}</p>
    <p class="event-info"><strong>Data de Início:</strong> {{ $event->start_date }}</p>
    <p class="event-info"><strong>Data de Término:</strong> {{ $event->end_date }}</p>
    <p class="event-info"><strong>Capacidade:</strong> {{ $event->capacity }}</p>
    <p class="event-info"><strong>Status:</strong> {{ ucfirst($event->status) }}</p>

    <h3 class="event-title">Participantes Inscritos:</h3>

    <table class="event-table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($event->registrations as $registration)
                <tr>
                    <td>{{ $registration->user->name }}</td>
                    <td>{{ $registration->user->email }}</td>
                    <td class="event-actions">
                        <form method="POST" action="{{ route('admin.events.removeParticipant', [$event->id, $registration->user->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="event-remove-button" onclick="return confirm('Tem certeza que deseja remover este participante?');">
                                Remover
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center p-4 text-gray-500">Nenhum participante inscrito.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h3 class="event-title">Adicionar Participante:</h3>

    <form method="POST" action="{{ route('admin.events.addParticipant', $event->id) }}" class="event-add-form">
        @csrf
        <div>
            <label for="user_id" class="block text-gray-700 dark:text-gray-300">Selecionar Usuário</label>
            <select id="user_id" name="user_id">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="event-add-button">
            Adicionar Participante
        </button>
    </form>

    <a href="{{ route('admin.dashboard') }}" class="event-back-button">Voltar</a>
</div>
@endsection
