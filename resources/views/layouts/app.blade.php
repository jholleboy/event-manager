<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Event Manager')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/layout.css'])
</head>

<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <a href="{{ route('home') }}" class="text-lg font-semibold">Event Manager</a>
            <div>
                @auth
                    <a href="{{ route('dashboard') }}" class="px-3 py-1 bg-white text-blue-600 rounded">Painel</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-1 bg-white text-blue-600 rounded">Entrar</a>
                    <a href="{{ route('register') }}" class="px-3 py-1 bg-green-500 text-white rounded">Registrar</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="content-container">
        @if (session('success'))
            <div class="session-message session-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="session-message session-error">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>

</html>