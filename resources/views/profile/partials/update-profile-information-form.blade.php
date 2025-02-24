<section class="profile-update-container">
    <header>
        <h2 class="profile-update-header">
            Informações do Perfil
        </h2>

        <p class="profile-update-description">
            Atualize as informações do seu perfil e endereço de e-mail.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="profile-update-label">Nome</label>
            <input id="name" name="name" type="text" class="profile-update-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @if ($errors->has('name'))
                <p class="profile-update-error">{{ $errors->first('name') }}</p>
            @endif
        </div>

        <div>
            <label for="email" class="profile-update-label">E-mail</label>
            <input id="email" name="email" type="email" class="profile-update-input" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @if ($errors->has('email'))
                <p class="profile-update-error">{{ $errors->first('email') }}</p>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        Seu endereço de e-mail não foi verificado.

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            Clique aqui para reenviar o e-mail de verificação.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="profile-update-success">
                            Um novo link de verificação foi enviado para seu endereço de e-mail.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="profile-update-button">
                Salvar
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="profile-update-success"
                >Salvo.</p>
            @endif
        </div>
    </form>
</section>
