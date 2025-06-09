<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Informations du profil
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Modifiez les informations de votre profil et votre adresse e-mail.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="'Nom'" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="'E-mail'" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="alert alert-primary d-flex align-items-center mt-3" style="backdrop-filter: blur(6px); background: rgba(37,99,235,0.13); color:#2563eb; border: none; border-radius: 0.75rem;">
                    <i class="fa fa-info-circle me-2"></i>
                    <div>
                        Votre adresse e-mail n'est pas vérifiée.<br>
                        <button form="send-verification" class="btn btn-primary btn-sm mt-2">Renvoyer l'e-mail de vérification</button>
                    </div>
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 mt-4">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            @if (session('status') === 'profile-updated')
                <span class="badge bg-success ms-2">Enregistré</span>
            @endif
        </div>
    </form>
</section>
