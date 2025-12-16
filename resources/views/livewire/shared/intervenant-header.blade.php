<nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" wire:navigate class="text-2xl font-bold text-[#2B5AA8]">
                    Helpora
                </a>
            </div>

            <!-- Logout Button -->
            <div class="hidden md:flex items-center">
                @auth
                    @if(auth()->user()->role === 'intervenant')
                        <button wire:click="logout" 
                                class="flex items-center px-4 py-2 bg-white rounded-lg shadow-sm border border-gray-200 text-gray-600 hover:text-red-600 hover:border-red-200 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Déconnexion
                        </button>
                    @endif
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
                @auth
                    @if(auth()->user()->role === 'intervenant')
                        <button wire:click="logout" 
                                class="w-full flex items-center justify-center px-4 py-2 bg-white rounded-lg shadow-sm border border-gray-200 text-gray-600 hover:text-red-600 hover:border-red-200 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Déconnexion
                        </button>
                    @endif
                @endauth
            </div>
        </div>
        @endif
    </div>
</nav>
