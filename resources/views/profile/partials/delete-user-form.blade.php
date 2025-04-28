<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Supprimer le compte') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.destroy') }}" class="mt-6 space-y-6">
        @csrf
        @method('delete')
        <div>
            <x-input-label for="password" :value="'Mot de passe'" class="sr-only" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="flex justify-end mt-4">
            <button type="submit" class="btn btn-danger">Supprimer le compte</button>
        </div>
    </form>
</section>
