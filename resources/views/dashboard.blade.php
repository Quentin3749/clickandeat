<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Dashboard') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{ __("You're logged in!") }}

                {{-- Afficher les informations de l'utilisateur connecté --}}
                <h3 class="mt-4">Bienvenue, {{ Auth::user()->name }}!</h3>
                <p>Email : {{ Auth::user()->email }}</p>

                {{-- Formulaire de déconnexion --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md">
                        {{ __('Déconnexion') }}
                    </button>
                </form>

                <p> je suis restaurateur</p>
            </div>
        </div>
    </div>
</div>
