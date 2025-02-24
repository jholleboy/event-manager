@extends('layouts.app')

@section('title', 'Editar Evento')

@vite(['resources/css/admin/event-edit.css']) 

@section('content')
<div class="edit-event-container">
    <div class="edit-event-card">
        <h2 class="edit-event-title">
            {{ __('Editar Evento') }}
        </h2>

        @if ($errors->any())
            <div class="edit-event-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.events.update', $event->id) }}" class="edit-event-form">
            @csrf
            @method('PUT')

            <div>
                <x-input-label for="title" :value="__('Título do Evento')" />
                <x-text-input id="title" type="text" name="title" value="{{ old('title', $event->title) }}" required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="description" :value="__('Descrição')" />
                <textarea id="description" name="description" required>{{ old('description', $event->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="start_date" :value="__('Data de Início')" />
                <x-text-input id="start_date" type="datetime-local" name="start_date" value="{{ old('start_date', \Carbon\Carbon::parse($event->start_date)->format('Y-m-d\TH:i')) }}" required />
                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="end_date" :value="__('Data de Término')" />
                <x-text-input id="end_date" type="datetime-local" name="end_date" value="{{ old('end_date', \Carbon\Carbon::parse($event->end_date)->format('Y-m-d\TH:i')) }}" required />
                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="location" :value="__('Localização')" />
                <x-text-input id="location" type="text" name="location" value="{{ old('location', $event->location) }}" required />
                <x-input-error :messages="$errors->get('location')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="capacity" :value="__('Capacidade')" />
                <x-text-input id="capacity" type="number" name="capacity" min="1" value="{{ old('capacity', $event->capacity) }}" required />
                <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="status" :value="__('Status')" />
                <select id="status" name="status" required>
                    <option value="aberto" {{ old('status', $event->status) == 'aberto' ? 'selected' : '' }}>{{ __('Aberto') }}</option>
                    <option value="encerrado" {{ old('status', $event->status) == 'encerrado' ? 'selected' : '' }}>{{ __('Encerrado') }}</option>
                    <option value="cancelado" {{ old('status', $event->status) == 'cancelado' ? 'selected' : '' }}>{{ __('Cancelado') }}</option>
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

            <div class="edit-event-actions">
                <a href="{{ route('admin.dashboard') }}" class="edit-event-cancel">Cancelar</a>
                <button type="submit" class="edit-event-button">
                    {{ __('Salvar Alterações') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
