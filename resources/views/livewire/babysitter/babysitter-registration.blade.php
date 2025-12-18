<div class="min-h-screen bg-gray-50 font-sans">
    <!-- Header Section with Gradient -->
    <div class="relative bg-white overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-[#B82E6E]/5 to-[#B82E6E]/10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 mb-8 text-sm font-medium text-gray-500">
                <a href="/" wire:navigate class="hover:text-[#B82E6E] transition-colors flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Accueil
                </a>
                <span class="text-gray-300">/</span>
                <a href="/services" wire:navigate class="hover:text-[#B82E6E] transition-colors">Services</a>
                <span class="text-gray-300">/</span>
                <span class="text-[#B82E6E] font-bold">Devenir Babysitter</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                <div>
                    <h1 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight mb-4">
                        Devenir <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#B82E6E] to-[#D94686]">Babysitter</span>
                    </h1>
                    <p class="text-lg text-gray-600 max-w-2xl leading-relaxed">
                        Rejoignez notre communauté de babysitters professionnels et trouvez des familles qui ont besoin de vos services.
                    </p>
                </div>
            </div>
        </div>
    </div>
        
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- En-tête -->
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900">Inscription Babysitter</h2>
                <p class="text-gray-600 text-sm mt-1">Créez votre compte professionnel en quelques étapes</p>
            </div>

            <!-- Bandeau informatif si utilisateur existant -->
            @if($isExistingUser)
                <div class="mb-6 bg-blue-50 border-2 border-blue-500 rounded-xl p-5">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="font-bold text-blue-900 mb-2">Ajout d'un nouveau service</h3>
                            <p class="text-sm text-blue-800">
                                Vous ajoutez un <strong>nouveau service</strong> à votre profil existant.<br>
                                Services actuels : <strong>{{ $currentServicesCount }}/2</strong>
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Stepper -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    @for ($i = 1; $i <= $totalSteps; $i++)
                        <div class="flex items-center {{ $i < $totalSteps ? 'flex-1' : '' }}">
                            <div class="flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold
                                    {{ $currentStep >= $i ? 'bg-pink-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                                    {{ $i }}
                                </div>
                                <span class="text-xs mt-1 font-medium {{ $currentStep >= $i ? 'text-pink-600' : 'text-gray-500' }}">
                                    @if($i == 1) Profil
                                    @elseif($i == 2) Contact
                                    @elseif($i == 3) Pro
                                    @elseif($i == 4) Compétences
                                    @else Documents
                                    @endif
                                </span>
                            </div>
                            @if ($i < $totalSteps)
                                <div class="flex-1 h-1 mx-2 {{ $currentStep > $i ? 'bg-pink-600' : 'bg-gray-200' }}"></div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>

            <!-- ÉTAPE 1 - PROFIL -->
            @if ($currentStep == 1)
                <div class="space-y-4">
                    <div class="bg-pink-50 rounded-lg p-3 flex items-center">
                        <div class="bg-pink-600 rounded-full p-2 mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">
                                @if($isExistingUser)
                                    Vos informations personnelles
                                @else
                                    Informations personnelles
                                @endif
                            </h3>
                            <p class="text-xs text-gray-600">
                                @if($isExistingUser)
                                    Vos informations sont déjà enregistrées
                                @else
                                    Commençons par créer votre profil
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($isExistingUser)
                        <div class="bg-gray-100 border border-gray-300 rounded-lg p-4">
                            <p class="text-sm text-gray-700 flex items-start gap-2">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Vos informations sont déjà enregistrées. Passez à l'étape suivante.
                            </p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Prénom <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="prenom"
                                @if($isExistingUser) disabled @endif
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @if($isExistingUser) bg-gray-100 cursor-not-allowed text-gray-600 @endif">
                            @error('prenom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nom <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="nom"
                                @if($isExistingUser) disabled @endif
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @if($isExistingUser) bg-gray-100 cursor-not-allowed text-gray-600 @endif">
                            @error('nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" wire:model="email"
                            @if($isExistingUser) disabled @endif
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @if($isExistingUser) bg-gray-100 cursor-not-allowed text-gray-600 @endif"
                            placeholder="votre.email@exemple.com">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Date de naissance <span class="text-red-500">*</span>
                        </label>
                        <input type="date" wire:model="date_naissance"
                            @if($isExistingUser) disabled @endif
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @if($isExistingUser) bg-gray-100 cursor-not-allowed text-gray-600 @endif">
                        @error('date_naissance') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    @if(!$isExistingUser)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Mot de passe <span class="text-red-500">*</span>
                                </label>
                                <input type="password" wire:model="mot_de_passe"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                                @error('mot_de_passe') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Confirmer le mot de passe <span class="text-red-500">*</span>
                                </label>
                                <input type="password" wire:model="mot_de_passe_confirmation"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                            </div>
                        </div>
                    @endif

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">À propos de vous</h4>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="flex items-center text-sm">
                                <input type="checkbox" wire:model="je_fume"
                                    class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                                <span class="ml-2 text-gray-700">Je fume</span>
                            </label>
                            <label class="flex items-center text-sm">
                                <input type="checkbox" wire:model="jai_enfants"
                                    class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                                <span class="ml-2 text-gray-700">J'ai des enfants</span>
                            </label>
                            <label class="flex items-center text-sm">
                                <input type="checkbox" wire:model="permis_conduire"
                                    class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                                <span class="ml-2 text-gray-700">Permis de conduire</span>
                            </label>
                            <label class="flex items-center text-sm">
                                <input type="checkbox" wire:model="jai_voiture"
                                    class="w-4 h-4 text-pink-600 border-gray-300 rounded focus:ring-pink-500">
                                <span class="ml-2 text-gray-700">J'ai une voiture</span>
                            </label>
                        </div>
                    </div>
                </div>
            @endif

            <!-- ÉTAPE 1.5 - VÉRIFICATION EMAIL -->
            @if($currentStep == 1.5 && !$isExistingUser)
                <div class="space-y-6">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Vérifiez votre email</h2>
                        <p class="text-gray-600">
                            Nous avons envoyé un code de vérification à<br>
                            <span class="font-semibold text-pink-600">{{ $email }}</span>
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2 text-center">
                            Code de vérification (10 chiffres)
                        </label>
                        <input
                            type="text"
                            wire:model="verificationCode"
                            maxlength="10"
                            class="w-full px-4 py-4 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent text-center text-2xl tracking-widest font-mono"
                            placeholder="0000000000"
                        />
                        @error('verificationCode') 
                            <span class="text-red-500 text-sm mt-1 block text-center">{{ $message }}</span>
                        @enderror
                    </div>

                    <button
                        type="button"
                        wire:click="verifyCode"
                        class="w-full py-3 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-all font-bold"
                    >
                        Vérifier le code
                    </button>

                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Vous n'avez pas reçu le code ?
                            <button
                                type="button"
                                wire:click="resendCode"
                                class="text-pink-600 font-semibold hover:underline"
                            >
                                Renvoyer
                            </button>
                        </p>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-sm text-yellow-800 flex items-start gap-2">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Le code expire dans 10 minutes. Vérifiez vos spams si vous ne le trouvez pas.
                        </p>
                    </div>
                </div>
            @endif

            <!-- ÉTAPE 2 - CONTACT (reste identique mais continue dans le prochain artifact) -->

            <!-- ÉTAPE 2 - CONTACT -->
            @if ($currentStep == 2)
                <div class="space-y-4">
                    <div class="bg-pink-50 rounded-lg p-3 flex items-center">
                        <div class="bg-pink-600 rounded-full p-2 mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Contact et localisation</h3>
                            <p class="text-xs text-gray-600">Comment les parents peuvent vous contacter</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Téléphone <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" wire:model="telephone"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                            placeholder="0612345678"
                            pattern="[0-9]+"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            maxlength="20">
                        @error('telephone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Géolocalisation automatique -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="auto_localisation"
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900">🌍 Activer la géolocalisation automatique</span>
                                <p class="text-xs text-gray-600 mt-1">Nous utiliserons votre position pour remplir automatiquement votre ville</p>
                            </div>
                        </label>
                        @if($auto_localisation && $ville)
                            <div class="mt-2 text-xs text-green-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Position détectée : {{ $ville }}
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Adresse complète 
                            @if(!$auto_localisation) <span class="text-red-500">*</span> @endif
                        </label>
                        <input type="text" wire:model="adresse"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $auto_localisation ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                            placeholder="Rue, Ville"
                            @if($auto_localisation) disabled @endif>
                        @if(!$auto_localisation)
                            @error('adresse') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        @else
                            <p class="text-xs text-gray-500 mt-1">Adresse non requise avec la géolocalisation automatique</p>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Photo de profil</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-pink-400 transition">
                            @if ($photo_profil)
                                <img src="{{ $photo_profil->temporaryUrl() }}" class="mx-auto h-24 w-24 rounded-full object-cover mb-3">
                            @else
                                <svg class="mx-auto h-10 w-10 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            @endif
                            <label class="cursor-pointer">
                                <span class="text-sm text-pink-600 hover:text-pink-700 font-medium">Choisir un fichier</span>
                                <input type="file" wire:model="photo_profil" accept="image/*" class="hidden">
                            </label>
                            <p class="text-xs text-gray-500 mt-1">JPG ou PNG, max 5MB</p>
                        </div>
                        <div wire:loading wire:target="photo_profil" class="mt-2 text-xs text-gray-600">
                            Téléchargement...
                        </div>
                    </div>
                </div>
            @endif

            <!-- ÉTAPE 3 - PROFESSIONNEL -->
            @if ($currentStep == 3)
                <div class="space-y-4">
                    <div class="bg-teal-50 rounded-lg p-3 flex items-center">
                        <div class="bg-teal-600 rounded-full p-2 mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Informations professionnelles</h3>
                            <p class="text-xs text-gray-600">Parlez-nous de votre expérience</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Prix horaire (MAD) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" wire:model="prix_horaire" placeholder="Ex: 50"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                            @error('prix_horaire') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Années d'expérience <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="annees_experience"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                                <option value="">Sélectionner...</option>
                                <option value="0-1">Moins d'un an</option>
                                <option value="1-3">1 à 3 ans</option>
                                <option value="3-5">3 à 5 ans</option>
                                <option value="5+">Plus de 5 ans</option>
                            </select>
                            @error('annees_experience') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Niveau d'études <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="niveau_etudes"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                            <option value="">Sélectionnez votre niveau d'études</option>
                            <option value="Aucun diplôme">Aucun diplôme</option>
                            <option value="Brevet des collèges">Brevet des collèges</option>
                            <option value="Baccalauréat">Baccalauréat</option>
                            <option value="Bac+1 (DUT, BTS)">Bac+1 (DUT, BTS)</option>
                            <option value="Bac+2 (DUT, BTS)">Bac+2 (DUT, BTS)</option>
                            <option value="Bac+3 (Licence)">Bac+3 (Licence)</option>
                            <option value="Bac+4 (Master 1)">Bac+4 (Master 1)</option>
                            <option value="Bac+5 (Master 2)">Bac+5 (Master 2)</option>
                            <option value="Doctorat">Doctorat</option>
                            <option value="Diplôme en petite enfance">Diplôme en petite enfance</option>
                            <option value="CAP Petite Enfance">CAP Petite Enfance</option>
                            <option value="Autre formation">Autre formation</option>
                        </select>
                        @error('niveau_etudes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    @if($niveau_etudes === 'Autre formation')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Précisez votre formation <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="autre_formation"
                            placeholder="Décrivez votre formation..."
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                        @error('autre_formation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea wire:model="description" rows="3"
                            placeholder="Parlez de vous, de votre passion pour le babysitting..."
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"></textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Avez-vous des maladies ou conditions médicales ? <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-4 mb-3">
                            <label class="flex items-center">
                                <input type="radio" wire:model.live="a_maladies" value="oui" class="mr-2">
                                <span>Oui</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" wire:model.live="a_maladies" value="non" class="mr-2">
                                <span>Non</span>
                            </label>
                        </div>
                        @error('a_maladies') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    @if($a_maladies == 'oui')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Sélectionnez vos maladies ou conditions médicales <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-2 mb-3">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" wire:model="maladies_selectionnees" value="Diabète" class="rounded">
                                <span class="text-sm">Diabète</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" wire:model="maladies_selectionnees" value="Asthme" class="rounded">
                                <span class="text-sm">Asthme</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" wire:model="maladies_selectionnees" value="Allergies" class="rounded">
                                <span class="text-sm">Allergies</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" wire:model="maladies_selectionnees" value="Hypertension" class="rounded">
                                <span class="text-sm">Hypertension</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" wire:model="maladies_selectionnees" value="Problèmes cardiaques" class="rounded">
                                <span class="text-sm">Problèmes cardiaques</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" wire:model="maladies_selectionnees" value="Épilepsie" class="rounded">
                                <span class="text-sm">Épilepsie</span>
                            </label>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Autres conditions (précisez)
                            </label>
                            <textarea wire:model="autres_maladies" rows="2"
                                placeholder="Décrivez vos autres conditions médicales..."
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"></textarea>
                            @error('autres_maladies') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Langues maîtrisées <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-gray-600 mb-2">Sélectionnez plusieurs langues</p>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach($langues_list as $langue)
                                <label class="flex items-center p-2 border-2 rounded-lg cursor-pointer transition text-sm
                                    {{ in_array($langue, $langues ?? []) ? 'border-pink-600 bg-pink-50' : 'border-gray-300 hover:border-pink-300' }}">
                                    <input type="checkbox" wire:model.live="langues" value="{{ $langue }}" class="hidden">
                                    <span class="{{ in_array($langue, $langues ?? []) ? 'text-pink-600 font-medium' : 'text-gray-700' }}">
                                        {{ $langue }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('langues') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Préférences de domicile -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Préférence de domicile <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-gray-600 mb-2">Où souhaitez-vous travailler ?</p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            @foreach([
                                ['value' => 'domicile_babysitter', 'label' => 'À mon domicile', 'icon' => '🏠'],
                                ['value' => 'domicile_client', 'label' => 'Au domicile du client', 'icon' => '🚗'],
                                ['value' => 'les_deux', 'label' => 'Les deux', 'icon' => '✨']
                            ] as $pref)
                                <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer transition
                                    {{ ($preferences_domicile ?? '') == $pref['value'] ? 'border-teal-600 bg-teal-50' : 'border-gray-300 hover:border-teal-300' }}">
                                    <input type="radio" wire:model.live="preferences_domicile" value="{{ $pref['value'] }}" class="hidden">
                                    <span class="text-2xl mr-2">{{ $pref['icon'] }}</span>
                                    <span class="text-sm {{ ($preferences_domicile ?? '') == $pref['value'] ? 'text-teal-600 font-medium' : 'text-gray-700' }}">
                                        {{ $pref['label'] }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('preferences_domicile') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Catégories d'enfants
                        </label>
                        <p class="text-xs text-gray-600 mb-2">Tranches d'âge avec lesquelles vous êtes à l'aise</p>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($categories_enfants_list as $cat)
                                <label class="flex items-center p-2 border-2 rounded-lg cursor-pointer transition text-sm
                                    {{ in_array($cat, $categories_enfants ?? []) ? 'border-pink-600 bg-pink-50' : 'border-gray-300 hover:border-pink-300' }}">
                                    <input type="checkbox" wire:model.live="categories_enfants" value="{{ $cat }}" class="hidden">
                                    <span class="{{ in_array($cat, $categories_enfants ?? []) ? 'text-pink-600 font-medium' : 'text-gray-700' }}">
                                        {{ $cat }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Besoins spéciaux -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Expérience avec des besoins spéciaux
                        </label>
                        <p class="text-xs text-gray-600 mb-2">Avez-vous de l'expérience avec des enfants ayant des besoins spéciaux ?</p>
                        <div class="max-h-48 overflow-y-auto border border-gray-300 rounded-lg p-2">
                            @foreach($besoins_list as $besoin)
                                <label class="flex items-center p-2 hover:bg-gray-50 rounded text-sm cursor-pointer">
                                    <input type="checkbox" wire:model.live="besoins_speciaux" value="{{ $besoin }}"
                                        class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                                    <span class="ml-2 text-gray-700">{{ $besoin }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- ÉTAPE 4 - COMPÉTENCES -->
            @if ($currentStep == 4)
                <div class="space-y-4">
                    <div class="bg-purple-50 rounded-lg p-3 flex items-center">
                        <div class="bg-purple-600 rounded-full p-2 mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Compétences et disponibilités</h3>
                            <p class="text-xs text-gray-600">Mettez en valeur vos atouts</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Certifications</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach($certifications_list as $cert)
                                <label class="flex items-center p-2 border-2 rounded-lg cursor-pointer transition text-sm
                                    {{ in_array($cert, $certifications ?? []) ? 'border-purple-600 bg-purple-50' : 'border-gray-300 hover:border-purple-300' }}">
                                    <input type="checkbox" wire:model.live="certifications" value="{{ $cert }}" class="hidden">
                                    <span class="{{ in_array($cert, $certifications ?? []) ? 'text-purple-600 font-medium' : 'text-gray-700' }}">
                                        {{ $cert }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Mes talents 🎨</h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($superpouvoirs_list as $sp)
                                <label class="flex flex-col items-center p-3 border-2 rounded-lg cursor-pointer transition
                                    {{ in_array($sp['name'], $superpowers ?? []) ? 'border-purple-600 bg-purple-50' : 'border-gray-300 hover:border-purple-300' }}">
                                    <input type="checkbox" wire:model.live="superpowers" value="{{ $sp['name'] }}" class="hidden">
                                    <span class="text-2xl mb-1">{{ $sp['icon'] }}</span>
                                    <span class="text-xs text-center {{ in_array($sp['name'], $superpowers ?? []) ? 'text-purple-600 font-medium' : 'text-gray-700' }}">
                                        {{ $sp['name'] }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Disponibilités</h4>
                        <p class="text-xs text-gray-600 mb-3">Ajoutez plusieurs créneaux par jour selon votre disponibilité</p>
                        
                        <div class="space-y-3">
                            @foreach(['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'] as $jour)
                            <div class="p-3 border border-gray-200 rounded-lg bg-gray-50">
                                <div class="flex justify-between items-center mb-2">
                                    <h5 class="text-sm font-medium text-gray-900 capitalize">{{ $jour }}</h5>
                                    <button type="button" wire:click="ajouterDisponibilite('{{ $jour }}')"
                                        class="px-2 py-1 text-xs bg-pink-600 text-white rounded hover:bg-pink-700">
                                        + Ajouter créneau
                                    </button>
                                </div>
                                
                                @if(empty($disponibilites[$jour]))
                                    <p class="text-xs text-gray-500 italic">Pas de créneau</p>
                                @else
                                    <div class="space-y-3">
                                        @foreach($disponibilites[$jour] as $index => $creneau)
                                        <div class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                            <div class="flex items-center gap-2 flex-1">
                                                <input type="time" wire:model="disponibilites.{{ $jour }}.{{ $index }}.debut"
                                                    class="px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                                                <span class="text-xs text-gray-400 font-medium">→</span>
                                                <input type="time" wire:model="disponibilites.{{ $jour }}.{{ $index }}.fin"
                                                    class="px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                                            </div>
                                            
                                            <div class="flex items-center gap-2">
                                                <label class="flex items-center gap-2 px-3 py-1.5 text-xs rounded-full border cursor-pointer transition-all
                                                    {{ ($disponibilites[$jour][$index]['est_reccurent'] ?? false) 
                                                        ? 'bg-green-100 border-green-500 text-green-700' 
                                                        : 'bg-gray-100 border-gray-300 text-gray-600 hover:bg-gray-200' }}">
                                                    <input type="checkbox" 
                                                        wire:model="disponibilites.{{ $jour }}.{{ $index }}.est_reccurent"
                                                        class="w-3 h-3 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                                    <span class="font-medium">Récurrent</span>
                                                </label>
                                                
                                                <button type="button" wire:click="supprimerDisponibilite('{{ $jour }}', {{ $index }})"
                                                    class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-md transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- ÉTAPE 5 - DOCUMENTS -->
            @if ($currentStep == 5)
                <div class="space-y-4">
                    <div class="bg-blue-50 rounded-lg p-3 flex items-center">
                        <div class="bg-blue-600 rounded-full p-2 mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Documents</h3>
                            <p class="text-xs text-gray-600">Dernière étape</p>
                        </div>
                    </div>

                    @foreach($documents as $doc)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                {{ $doc['label'] }}
                                @if($doc['required']) <span class="text-red-500">*</span> @endif
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-pink-400 transition">
                                <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <label class="cursor-pointer">
                                    <span class="text-sm text-pink-600 hover:text-pink-700 font-medium">Choisir un fichier</span>
                                    <input type="file" wire:model="{{ $doc['name'] }}" accept=".pdf,.jpg,.jpeg,.png" class="hidden">
                                </label>
                                <p class="text-xs text-gray-500 mt-1">
                                    @if($this->{$doc['name']})
                                        ✓ Fichier sélectionné
                                    @else
                                        PDF, JPG ou PNG
                                    @endif
                                </p>
                            </div>
                            <div wire:loading wire:target="{{ $doc['name'] }}" class="mt-1 text-xs text-gray-600">
                                Téléchargement...
                            </div>
                            @error($doc['name']) <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Navigation -->
            <div class="flex justify-between items-center mt-6">
                <button wire:click="precedent" type="button"
                    class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition {{ $currentStep == 1 ? 'invisible' : '' }}">
                    Précédent
                </button>

                @if ($currentStep < $totalSteps)
                    <button wire:click="suivant" type="button"
                        class="px-4 py-2 text-sm text-white bg-pink-600 rounded-lg hover:bg-pink-700 transition">
                        Suivant
                    </button>
                @else
                    <button wire:click="finaliser" type="button"
                        class="px-4 py-2 text-sm text-white bg-pink-600 rounded-lg hover:bg-pink-700 transition">
                        Finaliser l'inscription
                    </button>
                @endif
            </div>

            <!-- Messages -->
            @if (session()->has('success'))
                <div class="mt-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mt-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        // Écouter l'événement de géolocalisation
        Livewire.on('getLocation', () => {
            console.log('Événement getLocation reçu');
            
            if (navigator.geolocation) {
                console.log('Géolocalisation supportée, demande de position...');
                
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        console.log('Position obtenue:', position);
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        console.log('Coordonnées:', lat, lng);
                        
                        // Utiliser l'API de géocodage inversé (Nominatim OpenStreetMap)
                        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                            .then(response => response.json())
                            .then(data => {
                                console.log('Données de géocodage:', data);
                                const ville = data.address?.city || data.address?.town || data.address?.village || '';
                                console.log('Ville détectée:', ville);
                                
                                // Appeler la méthode PHP pour mettre à jour les coordonnées
                                @this.set('latitude', lat);
                                @this.set('longitude', lng);
                                @this.set('ville', ville);
                                
                                console.log('Coordonnées envoyées à Livewire');
                            })
                            .catch(error => {
                                console.error('Erreur de géocodage:', error);
                                @this.set('latitude', lat);
                                @this.set('longitude', lng);
                                @this.set('ville', '');
                            });
                    },
                    (error) => {
                        console.error('Erreur de géolocalisation:', error);
                        let message = 'Impossible d\'obtenir votre position. ';
                        
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                message += 'Veuillez autoriser l\'accès à votre localisation.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                message += 'Les informations de localisation ne sont pas disponibles.';
                                break;
                            case error.TIMEOUT:
                                message += 'La demande de localisation a expiré.';
                                break;
                            default:
                                message += 'Veuillez vérifier vos paramètres de localisation.';
                                break;
                        }
                        
                        alert(message);
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 60000
                    }
                );
            } else {
                alert('La géolocalisation n\'est pas supportée par votre navigateur.');
            }
        });
    });
</script>
@endpush