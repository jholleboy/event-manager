@extends('layouts.user')

@section('title', 'Eventos Disponíveis')

@vite(['resources/css/events.css'])

@section('content')
    <h1 class="text-2xl font-bold mb-4">Eventos Abertos para Inscrição</h1>
    
    @livewire('NotificationComponent')
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($events as $event)
            <div class="event-card">
                <h2 class="event-title">{{ $event->title }}</h2>
                <p class="event-description">{{ $event->description }}</p>
                <p class="event-dates">{{ $event->formatted_start_date }} - {{ $event->formatted_end_date }}</p>
                <p class="event-location">📍 Local: {{ $event->location }}</p>
                <p class="event-capacity">🧑‍🤝‍🧑 Vagas Disponíveis: {{ $event->capacityRestanty }}</p>

                @if ($event->isUserRegistered())
                    <form method="POST" action="{{ route('event.unsubscribe', $event->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="button button-unsubscribe">❌ Desinscrever-se</button>
                    </form>
                @elseif ($event->capacityRestanty > 0)
                    <form method="POST" action="{{ route('event.subscribe', $event->id) }}">
                        @csrf
                        <button class="button button-subscribe">✅ Inscrever-se</button>
                    </form>
                @else
                    <span class="button button-full">🚫 Lotado</span>
                @endif
            </div>
        @endforeach
    </div>
@endsection
