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

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
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
                        <button
                            type="button"
                            wire:click="navigateToForgotPassword"
                            class="text-sm text-[#2B5AA8] hover:underline font-semibold"
                        >
                            Mot de passe oublié ?
                        </button>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full py-3.5 bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91] transition-all font-bold shadow-md"
                    >
                        Se connecter
                    </button>
                </form>

                <!-- Divider -->
                <div class="my-6 flex items-center gap-4">
                    <div class="flex-1 h-px bg-gray-200"></div>
                    <span class="text-sm text-gray-500">ou continuer avec</span>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>

                <!-- Google Button -->
                <button
                    type="button"
                    class="w-full py-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all flex items-center justify-center gap-3 shadow-sm"
                >
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path
                            fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                        />
                        <path
                            fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                        />
                        <path
                            fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                        />
                        <path
                            fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                        />
                    </svg>
                    <span class="text-gray-700 font-medium">Google</span>
                </button>

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