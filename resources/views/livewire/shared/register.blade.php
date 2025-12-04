<div class="min-h-screen bg-white">
    <livewire:shared.header />

    <div class="min-h-screen bg-[#F7F7F7] py-12 flex items-center justify-center">
        <div class="max-w-2xl w-full mx-auto px-4 sm:px-6 lg:px-8">
            
            @if($step === 1)
            <!-- Étape 1: Choix du type de compte -->
            <div class="bg-white rounded-2xl p-8 shadow-md border border-gray-100">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl mb-2 text-black font-extrabold">
                        Créer votre compte
                    </h1>
                </div>

                <!-- Question -->
                <div class="mb-8">
                    <h2 class="text-lg text-black font-bold mb-6">
                        Quel type de compte souhaitez-vous créer ?
                    </h2>

                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Option Client -->
                        <label class="relative cursor-pointer">
                            <input 
                                type="radio" 
                                wire:model="accountType" 
                                value="client"
                                class="peer sr-only"
                            />
                            <div class="p-6 border-2 rounded-xl transition-all peer-checked:border-[#2B5AA8] peer-checked:bg-blue-50 hover:border-gray-400 border-gray-300 bg-white">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-[#2B5AA8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-black mb-1">Client</h3>
                                        <p class="text-sm text-[#2a2a2a] font-medium">Je recherche des services</p>
                                    </div>
                                </div>
                            </div>
                        </label>

                        <!-- Option Intervenant -->
                        <label class="relative cursor-pointer">
                            <input 
                                type="radio" 
                                wire:model="accountType" 
                                value="intervenant"
                                class="peer sr-only"
                            />
                            <div class="p-6 border-2 rounded-xl transition-all peer-checked:border-[#B82E6E] peer-checked:bg-pink-50 hover:border-gray-400 border-gray-300 bg-white">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-[#B82E6E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-black mb-1">Intervenant</h3>
                                        <p class="text-sm text-[#2a2a2a] font-medium">Je propose mes services</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Bouton Continuer -->
                <div class="flex flex-col items-center gap-4">
                    <button
                        wire:click="continueToForm"
                        class="px-8 py-3 bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91] transition-all font-bold shadow-md flex items-center gap-2"
                    >
                        Continuer
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    <button
                        wire:click="navigateToLogin"
                        class="text-sm text-[#2B5AA8] hover:underline font-semibold"
                    >
                        Retour à la page d'accueil
                    </button>
                </div>
            </div>

            @elseif($step === 2)
            <!-- Étape 2: Formulaire d'inscription -->
            <div class="bg-white rounded-2xl p-8 shadow-md border border-gray-100">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl mb-2 text-black font-extrabold">
                        Créer votre compte
                    </h1>
                    <p class="text-base text-[#1a1a1a] font-medium">
                        Compte {{ $accountType === 'client' ? 'Client' : 'Intervenant' }}
                    </p>
                </div>

                <!-- Form -->
                <form wire:submit.prevent="register" class="space-y-5">
                    <!-- Nom complet -->
                    <div>
                        <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                            Nom complet
                        </label>
                        <input
                            type="text"
                            wire:model="name"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a]"
                            placeholder="Jean Dupont"
                            required
                        />
                        @error('name') 
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                            Email
                        </label>
                        <input
                            type="email"
                            wire:model="email"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a]"
                            placeholder="jean.dupont@email.com"
                            required
                        />
                        @error('email') 
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                            Téléphone (optionnel)
                        </label>
                        <input
                            type="tel"
                            wire:model="phone"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a]"
                            placeholder="+33 6 12 34 56 78"
                        />
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                            Mot de passe
                        </label>
                        <input
                            type="password"
                            wire:model="password"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a]"
                            placeholder="••••••••"
                            required
                        />
                        @error('password') 
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirmation mot de passe -->
                    <div>
                        <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                            Confirmer le mot de passe
                        </label>
                        <input
                            type="password"
                            wire:model="password_confirmation"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a]"
                            placeholder="••••••••"
                            required
                        />
                    </div>

                    <!-- Conditions d'utilisation -->
                    <div class="flex items-start gap-2">
                        <input
                            type="checkbox"
                            id="terms"
                            wire:model="terms"
                            class="w-4 h-4 text-[#2B5AA8] border-gray-300 rounded focus:ring-[#2B5AA8] mt-1"
                            required
                        />
                        <label for="terms" class="text-sm text-[#3a3a3a] font-medium">
                            J'accepte les <a href="#" class="text-[#2B5AA8] hover:underline">conditions d'utilisation</a> et la <a href="#" class="text-[#2B5AA8] hover:underline">politique de confidentialité</a>
                        </label>
                    </div>
                    @error('terms') 
                        <span class="text-red-500 text-sm block">{{ $message }}</span>
                    @enderror

                    <!-- Boutons -->
                    <div class="flex flex-col gap-3 pt-4">
                        <button
                            type="submit"
                            class="w-full py-3.5 bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91] transition-all font-bold shadow-md"
                        >
                            Créer mon compte
                        </button>

                        <button
                            type="button"
                            wire:click="goBack"
                            class="w-full py-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all text-[#0a0a0a] font-semibold"
                        >
                            Retour
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-[#3a3a3a] font-medium">
                        Vous avez déjà un compte ?{' '}
                        <button
                            wire:click="navigateToLogin"
                            class="text-[#2B5AA8] hover:underline font-bold"
                        >
                            Se connecter
                        </button>
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <livewire:shared.footer />
</div>