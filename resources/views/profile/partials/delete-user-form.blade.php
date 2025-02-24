<section class="delete-account-container">
    <header>
        <h2 class="delete-account-header">
            Excluir Conta
        </h2>

        <p class="delete-account-description">
            Depois que sua conta for excluída, todos os seus dados serão permanentemente removidos. Antes de excluir sua conta, faça o download de qualquer informação que deseja manter.
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="delete-account-button"
    >
        Excluir Conta
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="delete-account-modal">
            @csrf
            @method('delete')

            <h2 class="delete-account-header">
                Tem certeza de que deseja excluir sua conta?
            </h2>

            <p class="delete-account-description">
                Depois que sua conta for excluída, todos os seus dados serão removidos permanentemente. Digite sua senha para confirmar que deseja excluir sua conta.
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">Senha</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="delete-account-input mt-1 block w-3/4"
                    placeholder="Digite sua senha"
                />

                @if ($errors->userDeletion->has('password'))
                    <p class="delete-account-error">{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" x-on:click="$dispatch('close')" class="delete-account-cancel">
                    Cancelar
                </button>

                <button type="submit" class="delete-account-button ms-3">
                    Excluir Conta
                </button>
            </div>
        </form>
    </x-modal>
</section>
