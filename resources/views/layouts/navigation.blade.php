<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    {{-- Menu de navigation principal --}}
    {{-- Affiche les liens de navigation selon le rôle et l'état de connexion --}}
    {{-- Utilise Bootstrap/Tailwind pour la mise en page --}}
    {{-- Explique chaque section, condition et lien --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{-- Logo ou nom du site --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                {{-- Liens affichés selon l'état de connexion --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    {{-- Lien vers le tableau de bord --}}
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    {{-- Lien pour réserver un restaurant --}}
                    <x-nav-link :href="route('restaurants.book')" :active="request()->routeIs('restaurants.book')">
                        {{ __('Réserver un Restaurant') }}
                    </x-nav-link>
                    {{-- Lien vers les commandes --}}
                    <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                        {{ __('Mes Commandes') }}
                    </x-nav-link>
                    {{-- Lien pour la gestion des commandes (restaurateur) --}}
                    @if(auth()->check() && auth()->user()->isRestaurateur())
                        <x-nav-link :href="route('restaurateur.commandes.index')" :active="request()->routeIs('restaurateur.commandes.index')">
                            {{ __('Gestion des Commandes') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            {{-- Menu déroulant pour les notifications et le profil --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    {{-- Menu déroulant pour les notifications --}}
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <div>Notifications</div>

                                    @php
                                        $unreadNotificationsCount = Auth::user()->unreadNotifications->count();
                                    @endphp

                                    {{-- Affiche le nombre de notifications non lues --}}
                                    @if ($unreadNotificationsCount > 0)
                                        <span class="inline-flex items-center justify-center px-2 py-1 ms-2 text-xs font-bold leading-none text-red-100 bg-red-500 rounded-full">
                                            {{ $unreadNotificationsCount }}
                                        </span>
                                    @endif
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                {{-- Lien pour voir toutes les notifications --}}
                                <x-dropdown-link :href="route('notifications.index')">
                                    {{ __('Voir toutes les notifications') }}
                                </x-dropdown-link>
                                {{-- Liste des 5 dernières notifications non lues --}}
                                @forelse (Auth::user()->unreadNotifications->take(5) as $notification)
                                    <x-dropdown-link :href="route('orders.show', $notification->data['order_id'] ?? '#')"
                                        @class(['font-semibold' => !$notification->read_at])
                                    >
                                        {{ __('Statut de la commande ') }} #{{ $notification->data['order_id'] ?? 'N/A' }} : {{ $notification->data['new_status'] ?? 'Mis à jour' }}
                                    </x-dropdown-link>
                                @empty
                                    {{-- Message si aucune notification --}}
                                    <x-dropdown-link>
                                        {{ __('Aucune nouvelle notification') }}
                                    </x-dropdown-link>
                                @endforelse
                            </x-slot>
                        </x-dropdown>
                    </div>

                    {{-- Menu déroulant pour le profil --}}
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            {{-- Lien pour éditer le profil --}}
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            {{-- Formulaire pour se déconnecter --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                              this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    {{-- Lien pour se connecter --}}
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">{{ __('Log in') }}</a>

                    {{-- Lien pour s'inscrire --}}
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">{{ __('Register') }}</a>
                    @endif
                @endauth
            </div>

            {{-- Bouton pour afficher le menu sur mobile --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menu déroulant pour les liens de navigation sur mobile --}}
    <div class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            {{-- Lien vers le tableau de bord --}}
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            {{-- Lien pour réserver un restaurant --}}
            <x-responsive-nav-link :href="route('restaurants.book')" :active="request()->routeIs('restaurants.book')">
                {{ __('Réserver un Restaurant') }}
            </x-responsive-nav-link>
            {{-- Lien vers les commandes --}}
            <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                {{ __('Mes Commandes') }}
            </x-responsive-nav-link>
            {{-- Lien pour la gestion des commandes (restaurateur) --}}
            @if(auth()->check() && auth()->user()->isRestaurateur())
                <x-responsive-nav-link :href="route('restaurateur.commandes.index')" :active="request()->routeIs('restaurateur.commandes.index')">
                    {{ __('Gestion des Commandes') }}
                </x-responsive-nav-link>
            @endif
        </div>

        {{-- Section pour les informations de l'utilisateur --}}
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            @auth
                {{-- Informations de l'utilisateur --}}
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                {{-- Liens pour éditer le profil et se déconnecter --}}
                <div class="mt-3 space-y-1">
                    {{-- Lien pour éditer le profil --}}
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    {{-- Formulaire pour se déconnecter --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                              this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                {{-- Liens pour se connecter et s'inscrire --}}
                <div class="py-2 border-t border-gray-200 dark:border-gray-600">
                    {{-- Lien pour se connecter --}}
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>

                    {{-- Lien pour s'inscrire --}}
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')">
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>