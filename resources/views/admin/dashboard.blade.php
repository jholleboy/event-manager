@extends('layouts.app')

@section('title', 'Painel Administrativo')

@vite(['resources/css/admin/admin.css'])

@section('content')
    <div class="admin-container">
        <h1>Gerenciar Eventos</h1>

        <a href="{{ route('admin.events.create') }}" class="admin-button">Criar Novo Evento</a>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Data início</th>
                    <th>Data fim</th>
                    <th>Local</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    <tr>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->formatted_start_date }}</td>
                        <td>{{ $event->formatted_end_date }}</td>
                        <td>{{ $event->location }}</td>
                        <td>{{ ucfirst($event->status) }}</td>
                        <td class="admin-actions">
                            <a href="{{ route('admin.events.show', $event->id) }}" class="admin-view">Detalhes</a>
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="admin-edit">Editar</a>
                            <form method="POST" action="{{ route('admin.events.destroy', $event->id) }}" onsubmit="return confirm('Tem certeza que deseja excluir este evento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-delete">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
