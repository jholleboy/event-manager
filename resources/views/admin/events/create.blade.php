@extends('layouts.app')

@section('title', 'Criar Novo Evento')

@vite(['resources/css/admin/event-create.css']) 

@section('content')
<div class="create-event-container">
    <div class="create-event-card">
        <h2 class="create-event-title">
            {{ __('Criar Novo Evento') }}
        </h2>

        <form method="POST" action="{{ route('admin.events.store') }}" class="create-event-form">
            @csrf

            <div>
                <x-input-label for="title" :value="__('Título do Evento')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="description" :value="__('Descrição')" />
                <textarea id="description" name="description" required>{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="start_date" :value="__('Data de Início')" />
                <x-text-input id="start_date" class="block mt-1 w-full" type="datetime-local" name="start_date" :value="old('start_date')" required />
                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="end_date" :value="__('Data de Término')" />
                <x-text-input id="end_date" class="block mt-1 w-full" type="datetime-local" name="end_date" :value="old('end_date')" required />
                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="location" :value="__('Localização')" />
                <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required />
                <x-input-error :messages="$errors->get('location')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="capacity" :value="__('Capacidade')" />
                <x-text-input id="capacity" class="block mt-1 w-full" type="number" name="capacity" min="1" :value="old('capacity')" required />
                <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="status" :value="__('Status')" />
                <select id="status" name="status" required>
                    <option value="aberto" {{ old('status') == 'aberto' ? 'selected' : '' }}>{{ __('Aberto') }}</option>
                    <option value="encerrado" {{ old('status') == 'encerrado' ? 'selected' : '' }}>{{ __('Encerrado') }}</option>
                    <option value="cancelado" {{ old('status') == 'cancelado' ? 'selected' : '' }}>{{ __('Cancelado') }}</option>
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" class="create-event-button">
                    {{ __('Criar Evento') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
