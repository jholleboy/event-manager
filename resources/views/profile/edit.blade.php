@extends('layouts.user')

@section('title', 'Perfil do Usuário')

@vite(['resources/css/profile/user-profile.css']) 
@vite(['resources/css/profile/profile-update.css'])
@vite(['resources/css/profile/update-password.css'])
@vite(['resources/css/profile/delete-account.css'])

@section('content')
    <div class="user-profile-container">
        <div class="space-y-6">
            
            <!-- Atualizar Informações do Perfil -->
            <div class="user-profile-card">
                <div>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Atualizar Senha -->
            <div class="user-profile-card">
                <div>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Deletar Conta -->
            <div class="user-profile-card">
                <div>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
@endsection
