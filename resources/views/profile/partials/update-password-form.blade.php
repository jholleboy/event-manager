<section class="update-password-container">
    <header>
        <h2 class="update-password-header">
            Atualizar Senha
        </h2>

        <p class="update-password-description">
            Certifique-se de que sua conta está usando uma senha longa e segura.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="update-password-label">Senha Atual</label>
            <input id="update_password_current_password" name="current_password" type="password" class="update-password-input" autocomplete="current-password">
            @if ($errors->updatePassword->has('current_password'))
                <p class="update-password-error">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password" class="update-password-label">Nova Senha</label>
            <input id="update_password_password" name="password" type="password" class="update-password-input" autocomplete="new-password">
            @if ($errors->updatePassword->has('password'))
                <p class="update-password-error">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="update-password-label">Confirmar Nova Senha</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="update-password-input" autocomplete="new-password">
            @if ($errors->updatePassword->has('password_confirmation'))
                <p class="update-password-error">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="update-password-button">
                Salvar
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="update-password-success"
                >Senha atualizada com sucesso.</p>
            @endif
        </div>
    </form>
</section>
