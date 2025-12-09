<div class="min-h-screen bg-white">
    <livewire:shared.header />

    <div class="min-h-screen bg-[#F7F7F7] py-12 flex items-center justify-center">
        <div class="max-w-2xl w-full mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Messages Flash -->
            @if (session()->has('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

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
                <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
                    @csrf
                    <!-- Prénom et Nom (côte à côte) -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Prénom -->
                        <div>
                            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                                Prénom <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="firstName"
                                value="{{ old('firstName') }}"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a] @error('firstName') border-red-500 @enderror"
                                placeholder="Jean"
                                required
                            />
                            @error('firstName') 
                                <span class="text-red-500 text-sm mt-1 block flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Nom -->
                        <div>
                            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                                Nom <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="lastName"
                                value="{{ old('lastName') }}"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a] @error('lastName') border-red-500 @enderror"
                                placeholder="Dupont"
                                required
                            />
                            @error('lastName') 
                                <span class="text-red-500 text-sm mt-1 block flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span>
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
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a] @error('email') border-red-500 @enderror"
                            placeholder="jean.dupont@email.com"
                            required
                        />
                        @error('email') 
                            <span class="text-red-500 text-sm mt-1 block flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span>
                        @enderror
                    </div>

                    <!-- Telephone et Date de Naissance -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Telephone -->
                        <div>
                            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                                Téléphone <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="tel"
                                name="telephone"
                                value="{{ old('telephone') }}"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a] @error('telephone') border-red-500 @enderror"
                                placeholder="06XXXXXXXX"
                                required
                            />
                            @error('telephone') 
                                <span class="text-red-500 text-sm mt-1 block flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Date de Naissance -->
                        <div>
                            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                                Date de Naissance <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="date"
                                name="dateNaissance"
                                value="{{ old('dateNaissance') }}"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a] @error('dateNaissance') border-red-500 @enderror"
                                required
                            />
                            @error('dateNaissance') 
                                <span class="text-red-500 text-sm mt-1 block flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                            Mot de passe <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a] pr-12 @error('password') border-red-500 @enderror"
                                placeholder="••••••••"
                                required
                            />
                            <button 
                                type="button"
                                onclick="togglePassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                            >
                                <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password') 
                            <span class="text-red-500 text-sm mt-1 block flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </span>
                        @enderror
                        <div class="mt-2 text-xs text-gray-500">
                            Le mot de passe doit contenir au moins 8 caractères
                        </div>
                    </div>

                    <!-- Champs obligatoires -->
                    <div class="text-sm text-[#6b7280] flex items-center gap-1">
                        <span class="text-red-500">*</span> 
                        <span>Champs obligatoires</span>
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
                            wire:loading.attr="disabled"
                            wire:target="register"
                            class="flex-1 py-3 bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91] transition-all font-bold shadow-md flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span wire:loading.remove wire:target="register">
                                Continuer
                            </span>
                            <span wire:loading wire:target="register">
                                Inscription en cours...
                            </span>
                            <svg wire:loading.remove wire:target="register" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            <svg wire:loading wire:target="register" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-[#6b7280]">
                        Vous avez déjà un compte ?
                        <a href="/connexion" class="text-[#2B5AA8] hover:underline font-semibold ml-1">
                            Se connecter
                        </a>
                    </p>
                    <a
                        href="/"
                        class="inline-block mt-3 text-sm text-[#2B5AA8] hover:underline font-semibold"
                    >
                        Retour à la page d'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <livewire:shared.footer />

    @push('scripts')
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }

        // Rafraîchir le token CSRF toutes les 10 minutes
        setInterval(function() {
            fetch('/refresh-csrf')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.token);
                    Livewire.emit('refreshCsrf');
                })
                .catch(error => console.error('Erreur rafraîchissement CSRF:', error));
        }, 600000); // 10 minutes
    </script>
    @endpush
</div>