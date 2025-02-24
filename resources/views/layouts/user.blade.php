<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Área do Usuário')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/user-layout.css'])
</head>

<body class="bg-gray-100">
    <nav class="user-navbar">
        <div class="user-navbar-container">
            <a href="{{ route('home') }}" class="user-navbar-logo">Event Manager</a>
            
            <div class="user-nav-buttons">
                @auth
                    <a href="{{ route('profile.edit') }}" class="user-profile">Perfil</a>
                    
                    <a href="{{ route('dashboard') }}" class="user-dashboard">Painel</a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="user-logout">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="user-profile">Entrar</a>
                    <a href="{{ route('register') }}" class="user-dashboard">Registrar</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="user-content-container">
        @if (session('success'))
            <div class="user-session-message user-session-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="user-session-message user-session-error">
                {{ session('error') }}
            </div>
        @endif
        @livewireStyles
        @livewireScripts
        @yield('content')
    </div>
</body>

</html>
