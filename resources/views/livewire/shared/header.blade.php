<nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" wire:navigate class="text-2xl font-bold text-[#2B5AA8]">
                    Helpora
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-8 flex-1 justify-center">
                <a href="/" wire:navigate 
                   class="text-sm font-semibold hover:text-[#2B5AA8] transition-colors {{ request()->is('/') ? 'text-[#2B5AA8]' : 'text-gray-700' }}">
                    Accueil
                </a>
                <a href="/services" wire:navigate 
                   class="text-sm font-semibold hover:text-[#2B5AA8] transition-colors {{ request()->is('services') ? 'text-[#2B5AA8]' : 'text-gray-700' }}">
                    Services
                </a>
                
                @auth
                    @if(auth()->user()->role === 'client')
                        <a href="/mes-demandes" wire:navigate 
                           class="text-sm font-semibold hover:text-[#2B5AA8] transition-colors {{ request()->is('mes-demandes') ? 'text-[#2B5AA8]' : 'text-gray-700' }}">
                            Mes Demandes
                        </a>
                        <a href="/mes-avis" wire:navigate 
                           class="text-sm font-semibold hover:text-[#2B5AA8] transition-colors {{ request()->is('mes-avis') ? 'text-[#2B5AA8]' : 'text-gray-700' }}">
                            Mes Avis
                        </a>
                        <a href="/mes-reclamations" wire:navigate 
                           class="text-sm font-semibold hover:text-[#2B5AA8] transition-colors {{ request()->is('mes-reclamations') ? 'text-[#2B5AA8]' : 'text-gray-700' }}">
                            Mes Réclamations
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Auth Section (Fixed width to prevent layout shift) -->
            <div class="hidden md:flex items-center" style="min-width: 240px; justify-content: flex-end;">
                @auth
                    @if(auth()->user()->role === 'client')
                        <!-- User Profile Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                                @if(auth()->user()->photo)
                                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" 
                                         alt="{{ auth()->user()->prenom }}"
                                         class="h-8 w-8 rounded-full object-cover border-2 border-[#2B5AA8]">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-[#2B5AA8] flex items-center justify-center text-white font-semibold text-xs">
                                        {{ strtoupper(substr(auth()->user()->prenom, 0, 1)) }}{{ strtoupper(substr(auth()->user()->nom, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="text-sm font-semibold text-gray-700">
                                    {{ auth()->user()->prenom }}
                                </span>
                                <svg class="h-4 w-4 text-gray-500 transition-transform" 
                                     :class="{ 'rotate-180': open }"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 top-full mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-100 py-2 z-50"
                                 style="display: none;">
                                
                                <!-- User Info -->
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ auth()->user()->prenom }} {{ auth()->user()->nom }}
                                    </p>
                                    <p class="text-xs text-gray-500 truncate">
                                        {{ auth()->user()->email }}
                                    </p>
                                </div>

                                <!-- Menu Items -->
                                <a href="/profil" wire:navigate 
                                   class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Mon Profil
                                </a>

                                <a href="/mes-demandes" wire:navigate 
                                   class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Mes Demandes
                                </a>

                                <a href="/mes-avis" wire:navigate 
                                   class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    Mes Avis
                                </a>

                                <a href="/mes-reclamations" wire:navigate 
                                   class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    Mes Réclamations
                                </a>

                                <div class="border-t border-gray-100 mt-2"></div>

                                <button wire:click="logout" 
                                        class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Déconnexion
                                </button>
                            </div>
                        </div>
                    @endif
                @else
                    <!-- Liens Connexion/Inscription -->
                    <div class="flex items-center gap-3">
                        <a href="/connexion" wire:navigate 
                           class="px-5 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                            Connexion
                        </a>
                        <a href="/inscription" wire:navigate 
                           class="px-5 py-2 text-sm font-semibold bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91] transition-colors shadow-sm">
                            Inscription
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="$wire.toggleMenu()" type="button" 
                        class="text-gray-700 hover:text-[#2B5AA8] focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        @if($menuOpen)
        <div class="md:hidden border-t border-gray-100">
            <div class="px-4 pt-2 pb-4 space-y-2">
                <a href="/" wire:navigate 
                   class="block px-3 py-2 text-sm font-semibold rounded-lg {{ request()->is('/') ? 'bg-[#E1EAF7] text-[#2B5AA8]' : 'text-gray-700 hover:bg-gray-50' }}">
                    Accueil
                </a>
                <a href="/services" wire:navigate 
                   class="block px-3 py-2 text-sm font-semibold rounded-lg {{ request()->is('services') ? 'bg-[#E1EAF7] text-[#2B5AA8]' : 'text-gray-700 hover:bg-gray-50' }}">
                    Services
                </a>
                
                @auth
                    @if(auth()->user()->role === 'client')
                        <a href="/mes-demandes" wire:navigate 
                           class="block px-3 py-2 text-sm font-semibold rounded-lg {{ request()->is('mes-demandes') ? 'bg-[#E1EAF7] text-[#2B5AA8]' : 'text-gray-700 hover:bg-gray-50' }}">
                            Mes Demandes
                        </a>
                        <a href="/mes-avis" wire:navigate 
                           class="block px-3 py-2 text-sm font-semibold rounded-lg {{ request()->is('mes-avis') ? 'bg-[#E1EAF7] text-[#2B5AA8]' : 'text-gray-700 hover:bg-gray-50' }}">
                            Mes Avis
                        </a>
                        <a href="/mes-reclamations" wire:navigate 
                           class="block px-3 py-2 text-sm font-semibold rounded-lg {{ request()->is('mes-reclamations') ? 'bg-[#E1EAF7] text-[#2B5AA8]' : 'text-gray-700 hover:bg-gray-50' }}">
                            Mes Réclamations
                        </a>
                    @endif
                @endauth
                
                <!-- Mobile User Section -->
                @auth
                    @if(auth()->user()->role === 'client')
                        <div class="pt-2 border-t border-gray-100">
                            <div class="flex items-center gap-3 px-3 py-3 bg-gray-50 rounded-lg mb-2">
                                @if(auth()->user()->photo)
                                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" 
                                         alt="{{ auth()->user()->prenom }}"
                                         class="h-10 w-10 rounded-full object-cover border-2 border-[#2B5AA8]">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-[#2B5AA8] flex items-center justify-center text-white font-semibold text-sm">
                                        {{ strtoupper(substr(auth()->user()->prenom, 0, 1)) }}{{ strtoupper(substr(auth()->user()->nom, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ auth()->user()->prenom }} {{ auth()->user()->nom }}
                                    </p>
                                    <p class="text-xs text-gray-500 truncate">
                                        {{ auth()->user()->email }}
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <a href="/profil" wire:navigate 
                                   class="flex items-center gap-2 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 rounded-lg">
                                    <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Mon Profil
                                </a>

                                <div class="border-t border-gray-100 my-2"></div>

                                <button wire:click="logout" 
                                        class="w-full flex items-center gap-2 px-3 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-lg">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Déconnexion
                                </button>
                            </div>
                        </div>
                    @endif
                @else
                    <!-- Mobile Auth Links -->
                    <div class="pt-2 border-t border-gray-100 space-y-2">
                        <a href="/connexion" wire:navigate 
                           class="block px-3 py-2 text-sm font-semibold text-center text-gray-700 hover:bg-gray-50 rounded-lg">
                            Connexion
                        </a>
                        <a href="/inscription" wire:navigate 
                           class="block px-3 py-2 text-sm font-semibold text-center bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91]">
                            Inscription
                        </a>
                    </div>
                @endauth
            </div>
        </div>
        @endif
    </div>
</nav>