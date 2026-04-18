<nav x-data="{ open: false }" class="sticky top-0 z-50 nm-glass nm-shadow border-b border-outline-variant/20">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 md:h-20">
            <div class="flex items-center gap-10">
                <a href="{{ route('dashboard') }}" class="text-2xl md:text-3xl font-headline font-bold italic tracking-tight text-primary nm-focus-ring rounded-sm">
                    SambaApp
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('artists.index') }}"
                        class="text-sm uppercase tracking-[0.14em] {{ request()->routeIs('artists.*') ? 'text-primary border-b-2 border-primary pb-1' : 'text-on-surface-variant hover:text-primary' }} transition-colors nm-focus-ring rounded-sm">
                        Artistas
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="text-sm uppercase tracking-[0.14em] {{ request()->routeIs('dashboard') ? 'text-primary border-b-2 border-primary pb-1' : 'text-on-surface-variant hover:text-primary' }} transition-colors nm-focus-ring rounded-sm">
                        Dashboard
                    </a>
                    <a href="{{ route('repertoires.index') }}"
                        class="text-sm uppercase tracking-[0.14em] {{ request()->routeIs('repertoires.*') ? 'text-primary border-b-2 border-primary pb-1' : 'text-on-surface-variant hover:text-primary' }} transition-colors nm-focus-ring rounded-sm">
                        Repertórios
                    </a>
                    <a href="{{ route('songs.index') }}"
                        class="text-sm uppercase tracking-[0.14em] {{ request()->routeIs('songs.*') ? 'text-primary border-b-2 border-primary pb-1' : 'text-on-surface-variant hover:text-primary' }} transition-colors nm-focus-ring rounded-sm">
                        Músicas
                    </a>
                </div>
            </div>

            <div class="hidden md:flex md:items-center">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center gap-2 px-3 py-2 border border-outline-variant/20 text-sm rounded-md text-on-surface-variant hover:text-primary hover:border-primary/40 transition-colors">
                                <span class="material-symbols-outlined text-lg">account_circle</span>
                                {{ Auth::user()->name }}
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Perfil') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Sair') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-sm text-on-surface-variant hover:text-primary transition-colors">Entrar</a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 nm-gradient-gold text-on-primary-container text-xs font-bold rounded-md hover:brightness-110 transition-all">
                            Começar
                        </a>
                    </div>
                @endauth
            </div>

            <div class="md:hidden flex items-center">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-on-surface-variant hover:text-primary hover:bg-surface-container-high transition-colors nm-focus-ring">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden md:hidden border-t border-outline-variant/20 bg-surface-container-low">
        <div class="px-4 py-4 space-y-1">
            <a href="{{ route('artists.index') }}"
                class="block px-3 py-3 text-sm font-semibold rounded-md {{ request()->routeIs('artists.*') ? 'text-primary bg-surface-container-high' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} transition-colors nm-focus-ring">
                Artistas
            </a>
            <a href="{{ route('dashboard') }}"
                class="block px-3 py-3 text-sm font-semibold rounded-md {{ request()->routeIs('dashboard') ? 'text-primary bg-surface-container-high' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} transition-colors nm-focus-ring">
                Dashboard
            </a>
            <a href="{{ route('repertoires.index') }}"
                class="block px-3 py-3 text-sm font-semibold rounded-md {{ request()->routeIs('repertoires.*') ? 'text-primary bg-surface-container-high' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} transition-colors nm-focus-ring">
                Repertórios
            </a>
            <a href="{{ route('songs.index') }}"
                class="block px-3 py-3 text-sm font-semibold rounded-md {{ request()->routeIs('songs.*') ? 'text-primary bg-surface-container-high' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} transition-colors nm-focus-ring">
                Músicas
            </a>
        </div>

        @auth
            <div class="px-4 pb-4 border-t border-outline-variant/20 pt-3">
                <div class="px-3 py-2 text-sm text-on-surface">{{ Auth::user()->name }}</div>
                <div class="space-y-1 mt-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="rounded-md">
                        {{ __('Perfil') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="rounded-md">
                            {{ __('Sair') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="px-4 pb-4 border-t border-outline-variant/20 pt-3 flex flex-col gap-2">
                <a href="{{ route('login') }}" class="px-3 py-3 text-sm text-on-surface-variant hover:text-primary transition-colors">Entrar</a>
                <a href="{{ route('register') }}" class="px-3 py-3 text-center text-xs font-bold rounded-md nm-gradient-gold text-on-primary-container">
                    Começar
                </a>
            </div>
        @endauth
    </div>
</nav>