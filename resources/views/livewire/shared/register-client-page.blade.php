<div class="min-h-screen bg-white">
    <livewire:shared.header />

    <div class="min-h-screen bg-[#F7F7F7] py-12 flex items-center justify-center">
        <div class="max-w-2xl w-full mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Formulaire d'inscription Client -->
            <div class="bg-white rounded-2xl p-8 shadow-md border border-gray-100">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl mb-2 text-black font-extrabold">
                        Informations personnelles
                    </h1>
                    <p class="text-base text-[#6b7280] font-medium">
                        Créez votre compte professionnel
                    </p>
                </div>

                <!-- Form -->
                <form wire:submit.prevent="register" class="space-y-5">
                    <!-- Prénom et Nom (côte à côte) -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Prénom -->
                        <div>
                            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                                Prénom <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                wire:model="firstName"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a]"
                                placeholder="Jean"
                                required
                            />
                            @error('firstName') 
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Nom -->
                        <div>
                            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                                Nom <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                wire:model="lastName"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a]"
                                placeholder="Dupont"
                                required
                            />
                            @error('lastName') 
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                            Email <span class="text-red-500">*</span>
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

                    <!-- Mot de passe -->
                    <div>
                        <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                            Mot de passe <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                wire:model="password"
                                id="password"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a] pr-12"
                                placeholder="••••••••"
                                required
                            />
                            <button 
                                type="button"
                                onclick="togglePassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password') 
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Champs obligatoires -->
                    <div class="text-sm text-[#6b7280]">
                        <span class="text-red-500">*</span> Champs obligatoires
                    </div>

                    <!-- Boutons -->
                    <div class="flex gap-3 pt-4">
                        <a
                            href="/inscription"
                            class="px-8 py-3 bg-[#e5e7eb] text-[#374151] rounded-lg hover:bg-[#d1d5db] transition-all font-semibold flex items-center gap-2"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Retour
                        </a>

                        <button
                            type="submit"
                            class="flex-1 py-3 bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91] transition-all font-bold shadow-md flex items-center justify-center gap-2"
                        >
                            Continuer
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <a
                        href="/"
                        class="text-sm text-[#2B5AA8] hover:underline font-semibold"
                    >
                        Retour à la page d'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <livewire:shared.footer />

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        }
    </script>
</div>