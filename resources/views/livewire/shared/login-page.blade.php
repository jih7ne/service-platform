<div class="min-h-screen bg-white">
    <livewire:shared.header />

    <div class="min-h-screen bg-[#F7F7F7] py-12 flex items-center justify-center">
        <div class="max-w-md w-full mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Message d'alerte pour compte suspendu -->
            @if ($suspendedMessage)
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <h3 class="text-sm font-bold text-red-800 mb-1">Compte Suspendu</h3>
                            <p class="text-sm text-red-700">{{ $suspendedMessage }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Card de connexion -->
            <div class="bg-white rounded-2xl p-8 shadow-md border border-gray-100">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl mb-2 text-black font-extrabold">
                        Connexion
                    </h1>
                    <p class="text-base text-[#1a1a1a] font-medium">
                        Accédez à votre espace Helpora
                    </p>
                </div>

                <!-- Form -->
                <form wire:submit.prevent="login" class="space-y-5">
                    <!-- Email -->
                    <div>
                        <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                            Email
                        </label>
                        <div class="relative">
                            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <input
                                type="email"
                                wire:model="email"
                                class="w-full pl-10 pr-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a]"
                                placeholder="jean.dupont@email.com"
                                required
                            />
                        </div>
                        @error('email') 
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                            Mot de passe
                        </label>
                        <div class="relative">
                            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <input
                                type="{{ $showPassword ? 'text' : 'password' }}"
                                wire:model="password"
                                class="w-full pl-10 pr-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a]"
                                placeholder="••••••••"
                                required
                            />
                        </div>
                        @error('password') 
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            id="remember"
                            wire:model="remember"
                            class="w-4 h-4 text-[#2B5AA8] border-gray-300 rounded focus:ring-[#2B5AA8]"
                        />
                        <label for="remember" class="text-sm text-[#3a3a3a] font-medium">
                            Se souvenir de moi
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full py-3.5 bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91] transition-all font-bold shadow-md"
                    >
                        Se connecter
                    </button>
                </form>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-[#3a3a3a] font-medium">
                        Vous n'avez pas de compte ?
                        <button
                            wire:click="navigateToRegister"
                            class="text-[#2B5AA8] hover:underline font-bold"
                        >
                            Créer un compte
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <livewire:shared.footer />
</div>