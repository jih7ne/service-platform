<div>
  
    
    <livewire:shared.header />

    <div class="min-h-screen bg-[#F7F7F7] py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if (session()->has('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl p-8 shadow-md border border-gray-100">
                
                <div class="text-center mb-8">
                    <h1 class="text-3xl mb-2 text-black font-extrabold">
                        Inscription Professeur
                    </h1>
                    <p class="text-base text-[#6b7280] font-medium">
                        Créez votre profil d'enseignant sur Helpora
                    </p>
                </div>

                <!-- Stepper -->
                @if(!$registrationComplete)
                <div class="w-full mb-8">
                    <div class="flex items-center justify-between max-w-3xl mx-auto">
                        @php
                            $steps = [1 => 'Infos', 2 => 'Lieu', 3 => 'Matières', 4 => 'Finaliser'];
                            $currentStepDisplay = $currentStep == 1.5 ? 1 : $currentStep;
                        @endphp
                        @foreach($steps as $stepNumber => $stepLabel)
                            <div class="flex flex-col items-center flex-1 relative">
                                <div class="flex items-center justify-center w-12 h-12 rounded-full border-2 transition-all duration-300 z-10
                                    {{ $currentStepDisplay > $stepNumber ? 'bg-[#2B5AA8] border-[#2B5AA8]' : 
                                       ($currentStepDisplay == $stepNumber ? 'bg-[#2B5AA8] border-[#2B5AA8]' : 'bg-white border-gray-300') }}">
                                    @if($currentStepDisplay > $stepNumber)
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @else
                                        <span class="text-lg font-bold 
                                            {{ $currentStepDisplay == $stepNumber ? 'text-white' : 'text-gray-400' }}">
                                            {{ $stepNumber }}
                                        </span>
                                    @endif
                                </div>

                                <span class="mt-2 text-sm font-semibold
                                    {{ $currentStepDisplay >= $stepNumber ? 'text-[#2B5AA8]' : 'text-gray-400' }}">
                                    {{ $stepLabel }}
                                </span>

                                @if($stepNumber < 4)
                                    <div class="absolute top-6 left-1/2 w-full h-0.5 -z-1 transition-all duration-300
                                        {{ $currentStepDisplay > $stepNumber ? 'bg-[#2B5AA8]' : 'bg-gray-300' }}">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="mt-8">
                    
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

                    {{-- Toutes vos étapes ici (1, 1.5, 2, 3, 4 et page de succès) --}}
                    {{-- Je ne répète pas tout le code pour gagner de l'espace --}}
                    
                    {{-- ÉTAPE 1 --}}
@if($currentStep == 1)
    <div class="space-y-6">
        <h2 class="text-xl font-bold text-black mb-4">
            @if($isExistingUser)
                Vos informations personnelles
            @else
                Informations Personnelles
            @endif
        </h2>

        @if($isExistingUser)
            <div class="bg-gray-100 border border-gray-300 rounded-lg p-4">
                <p class="text-sm text-gray-700 flex items-start gap-2">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Vos informations sont déjà enregistrées. Passez à l'étape suivante pour ajouter votre nouveau service.
                </p>
            </div>
        @endif

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                    Prénom <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    wire:model="firstName"
                    @if($isExistingUser) disabled @endif
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all @if($isExistingUser) bg-gray-100 cursor-not-allowed text-gray-600 @else bg-white @endif"
                    placeholder="Jean"
                />
                @error('firstName') 
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                    Nom <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    wire:model="lastName"
                    @if($isExistingUser) disabled @endif
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all @if($isExistingUser) bg-gray-100 cursor-not-allowed text-gray-600 @else bg-white @endif"
                    placeholder="Dupont"
                />
                @error('lastName') 
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                Email <span class="text-red-500">*</span>
            </label>
            <input
                type="email"
                wire:model="email"
                @if($isExistingUser) disabled @endif
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all @if($isExistingUser) bg-gray-100 cursor-not-allowed text-gray-600 @else bg-white @endif"
                placeholder="jean.dupont@email.com"
            />
            @error('email') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                    Téléphone <span class="text-red-500">*</span>
                </label>
                <input
                    type="tel"
                    wire:model="telephone"
                    @if($isExistingUser) disabled @endif
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all @if($isExistingUser) bg-gray-100 cursor-not-allowed text-gray-600 @else bg-white @endif"
                    placeholder="06XXXXXXXX"
                />
                @error('telephone') 
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                    Date de Naissance <span class="text-red-500">*</span>
                </label>
                <input
                    type="date"
                    wire:model="dateNaissance"
                    @if($isExistingUser) disabled @endif
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all @if($isExistingUser) bg-gray-100 cursor-not-allowed text-gray-600 @else bg-white @endif"
                />
                @error('dateNaissance') 
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Masquer le champ mot de passe si utilisateur existant -->
        @if(!$isExistingUser)
            <div>
                <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                    Mot de passe <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input
                        type="{{ $showPassword ? 'text' : 'password' }}"
                        wire:model="password"
                        class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all pr-12"
                        placeholder="••••••••"
                    />
                    <button 
                        type="button"
                        wire:click="togglePassword"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($showPassword)
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            @endif
                        </svg>
                    </button>
                </div>
                @error('password') 
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
                <p class="text-xs text-gray-500 mt-1">
                    Le mot de passe doit contenir au moins 8 caractères
                </p>
            </div>
        @endif
    </div>
@endif

{{-- ÉTAPE 1.5 : VÉRIFICATION EMAIL - Masquer si utilisateur existant --}}
@if($currentStep == 1.5 && !$isExistingUser)
    <div class="space-y-6">
        <div class="text-center">
            <div class="w-20 h-20 bg-[#E1EAF7] rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-[#2B5AA8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-black mb-2">Vérifiez votre email</h2>
            <p class="text-gray-600">
                Nous avons envoyé un code de vérification à<br>
                <span class="font-semibold text-[#2B5AA8]">{{ $email }}</span>
            </p>
        </div>

        <div>
            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold text-center">
                Code de vérification (10 chiffres)
            </label>
            <input
                type="text"
                wire:model="verificationCode"
                maxlength="10"
                class="w-full px-4 py-4 bg-white border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-center text-2xl tracking-widest font-mono"
                placeholder="0000000000"
            />
            @error('verificationCode') 
                <span class="text-red-500 text-sm mt-1 block text-center">{{ $message }}</span>
            @enderror
        </div>

        <button
            type="button"
            wire:click="verifyCode"
            class="w-full py-3 bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91] transition-all font-bold"
        >
            Vérifier le code
        </button>

        <div class="text-center">
            <p class="text-sm text-gray-600">
                Vous n'avez pas reçu le code ?
                <button
                    type="button"
                    wire:click="resendCode"
                    class="text-[#2B5AA8] font-semibold hover:underline"
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


                {{-- ÉTAPE 2 : LOCALISATION --}}
@if($currentStep == 2)
    <div class="space-y-6">
        <h2 class="text-xl font-bold text-black mb-4">
            @if($isExistingUser)
                Votre localisation
            @else
                Où exercez-vous ?
            @endif
        </h2>

        @if($isExistingUser)
            <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 mb-4">
                <p class="text-sm text-gray-700 flex items-start gap-2">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Vos informations de localisation sont déjà enregistrées. Elles seront utilisées pour votre nouveau service.
                </p>
            </div>
        @endif

        <!-- Bouton localisation automatique -->
        <button
            type="button"
            id="locationBtn"
            onclick="getLocationForProfessor()"
            @if($isExistingUser) disabled @endif
            class="w-full py-3 rounded-lg transition-all font-semibold flex items-center justify-center gap-2 @if($isExistingUser) bg-gray-200 text-gray-500 cursor-not-allowed @else bg-[#E1EAF7] text-[#2B5AA8] hover:bg-[#d1dbf0] @endif"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Obtenir ma localisation automatique
        </button>

        @if(!$isExistingUser)
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500 font-medium">ou saisissez manuellement</span>
            </div>
        </div>
        @endif

        <div class="grid md:grid-cols-2 gap-4">
            <!-- Pays -->
            <div>
                <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                    Pays <span class="text-red-500">*</span>
                </label>
                <select
                    wire:model="pays"
                    @if($isExistingUser) disabled @endif
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all @if($isExistingUser) bg-gray-100 cursor-not-allowed text-gray-600 @else bg-white @endif"
                >
                    <option value="">Sélectionnez un pays</option>
                    <option value="Maroc">Maroc</option>
                    <option value="France">France</option>
                    <option value="Belgique">Belgique</option>
                </select>
                @error('pays') 
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Ville -->
            <div>
                <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                    Ville <span class="text-red-500">*</span>
                </label>
                <select
                    wire:model="ville"
                    @if($isExistingUser) disabled @endif
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all @if($isExistingUser) bg-gray-100 cursor-not-allowed text-gray-600 @else bg-white @endif"
                >
                    <option value="">Sélectionnez une ville</option>
                    <option value="Tétouan">Tétouan</option>
                    <option value="Casablanca">Casablanca</option>
                    <option value="Rabat">Rabat</option>
                    <option value="Tanger">Tanger</option>
                </select>
                @error('ville') 
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Région / Province -->
        <div>
            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                Région / Province <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                wire:model="region"
                @if($isExistingUser) disabled @endif
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all @if($isExistingUser) bg-gray-100 cursor-not-allowed text-gray-600 @else bg-white @endif"
                placeholder="Ex: Grand Casablanca"
            />
            @error('region') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Adresse complète -->
        <div>
            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                Adresse complète <span class="text-red-500">*</span>
            </label>
            <textarea
                wire:model="adresseComplete"
                rows="3"
                @if($isExistingUser) disabled @endif
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all resize-none @if($isExistingUser) bg-gray-100 cursor-not-allowed text-gray-600 @else bg-white @endif"
                placeholder="Ex: 123 Rue Mohammed V, Quartier Maarif"
            ></textarea>
            @error('adresseComplete') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>
    </div>
@endif

                    {{-- ÉTAPE 3 --}}
                     @if($currentStep == 3)
                        <div class="space-y-6">
                            <h2 class="text-xl font-bold text-black mb-4">Matières enseignées</h2>

                            <!-- Surnom et bio -->
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                                        Surnom (optionnel)
                                    </label>
                                    <input
                                        type="text"
                                        wire:model="surnom"
                                        class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all"
                                        placeholder="Prof. Jean"
                                    />
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                                    Biographie (optionnel)
                                </label>
                                <textarea
                                    wire:model="biographie"
                                    rows="3"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all resize-none"
                                    placeholder="Parlez de votre expérience et de votre méthode d'enseignement..."
                                ></textarea>
                            </div>

                            <!-- Liste des matières -->
                            <div class="border-t pt-4">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-bold text-black">Matières et tarifs</h3>
                                    <button
                                        type="button"
                                        wire:click="addMatiere"
                                        class="px-4 py-2 bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91] transition-all font-semibold text-sm flex items-center gap-2"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Ajouter une matière
                                    </button>
                                </div>

                                @if(empty($matieres))
                                    <div class="text-center py-8 border-2 border-dashed border-gray-300 rounded-lg">
                                        <p class="text-gray-500">Aucune matière ajoutée. Cliquez sur "Ajouter une matière" pour commencer.</p>
                                    </div>
                                @else
                                    <div class="space-y-4">
                                        @foreach($matieres as $index => $matiere)
                                            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                                <div class="flex justify-between items-start mb-3">
                                                    <h4 class="font-semibold text-black">Matière #{{ $index + 1 }}</h4>
                                                    <button
                                                        type="button"
                                                        wire:click="removeMatiere({{ $index }})"
                                                        class="text-red-500 hover:text-red-700"
                                                    >
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <div class="grid md:grid-cols-3 gap-3">
                                                    <!-- Matière -->
                                                    <div>
                                                        <label class="block text-xs mb-1 text-gray-600 font-medium">
                                                            Matière <span class="text-red-500">*</span>
                                                        </label>
                                                        <select
                                                            wire:model="matieres.{{ $index }}.matiere_id"
                                                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] text-sm"
                                                        >
                                                            <option value="">Choisir</option>
                                                            <option value="1">Mathématiques</option>
                                                            <option value="2">Physique-Chimie</option>
                                                            <option value="3">Français</option>
                                                            <option value="4">Anglais</option>
                                                        </select>
                                                    </div>

                                                    <!-- Niveau -->
                                                    <div>
                                                        <label class="block text-xs mb-1 text-gray-600 font-medium">
                                                            Niveau <span class="text-red-500">*</span>
                                                        </label>
                                                        <select
                                                            wire:model="matieres.{{ $index }}.niveau_id"
                                                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] text-sm"
                                                        >
                                                            <option value="">Choisir</option>
                                                            <option value="1">Primaire</option>
                                                            <option value="2">Collège</option>
                                                            <option value="3">Lycée</option>
                                                            <option value="4">Université</option>
                                                        </select>
                                                    </div>

                                                    <!-- Prix -->
                                                    <div>
                                                        <label class="block text-xs mb-1 text-gray-600 font-medium">
                                                            Tarif (DH/h) <span class="text-red-500">*</span>
                                                        </label>
                                                        <input
                                                            type="number"
                                                            wire:model="matieres.{{ $index }}.prix_par_heure"
                                                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] text-sm"
                                                            placeholder="150"
                                                            min="0"
                                                        />
                                                    </div>
                                                </div>

                                                <!-- Type de service -->
                                                <div class="mt-3">
                                                    <label class="block text-xs mb-1 text-gray-600 font-medium">
                                                        Type de cours
                                                    </label>
                                                    <div class="flex gap-4">
                                                        <label class="flex items-center">
                                                            <input
                                                                type="radio"
                                                                wire:model="matieres.{{ $index }}.type_service"
                                                                value="enligne"
                                                                class="mr-2"
                                                            />
                                                            <span class="text-sm">En ligne</span>
                                                        </label>
                                                        <label class="flex items-center">
                                                            <input
                                                                type="radio"
                                                                wire:model="matieres.{{ $index }}.type_service"
                                                                value="domicile"
                                                                class="mr-2"
                                                            />
                                                            <span class="text-sm">À domicile</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            @error('matieres') 
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif


                    {{-- ÉTAPE 4 --}}
@if($currentStep == 4 && !$registrationComplete)
    <div class="space-y-6">
        <h2 class="text-xl font-bold text-black mb-4">Documents & Finalisation</h2>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <p class="text-sm text-blue-800">
                <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                Téléchargez vos documents pour obtenir le badge de certifié
            </p>
        </div>

   

        <!-- Upload Document CIN -->
        <div>
            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                Document CIN <span class="text-red-500">*</span>
            </label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-[#2B5AA8] transition-all cursor-pointer">
                <input 
                    type="file" 
                    wire:model="cinDocument" 
                    class="hidden" 
                    id="cin-upload"
                    accept=".pdf,.jpg,.jpeg,.png"
                />
                <label for="cin-upload" class="cursor-pointer">
                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <p class="text-sm text-gray-600">
                        Cliquez pour télécharger votre CIN
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        PDF, JPG, PNG (max 5MB)
                    </p>
                </label>
            </div>
            @if($cinDocument)
                <p class="text-sm text-green-600 mt-2">✓ Document CIN sélectionné</p>
            @endif
            @error('cinDocument') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Niveau d'études -->
        <div>
            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                Niveau d'études <span class="text-red-500">*</span>
            </label>
            <select
                wire:model="niveauEtudes"
                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all"
            >
                <option value="">Sélectionnez votre niveau</option>
                <option value="Bac">Bac</option>
                <option value="Bac+2">Bac+2</option>
                <option value="Licence">Licence (Bac+3)</option>
                <option value="Master">Master (Bac+5)</option>
                <option value="Doctorat">Doctorat (Bac+8)</option>
            </select>
            @error('niveauEtudes') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <!-- Upload Diplôme -->
            <div>
                <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                    Diplôme ou Certificat
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-[#2B5AA8] transition-all cursor-pointer">
                    <input 
                        type="file" 
                        wire:model="diplome" 
                        class="hidden" 
                        id="diplome-upload"
                        accept=".pdf,.jpg,.jpeg,.png"
                    />
                    <label for="diplome-upload" class="cursor-pointer">
                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-sm text-gray-600">
                            Cliquez pour télécharger
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            PDF, JPG, PNG (max 5MB)
                        </p>
                    </label>
                </div>
                @if($diplome)
                    <p class="text-sm text-green-600 mt-2">✓ Diplôme sélectionné</p>
                @endif
                @error('diplome') 
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Upload Photo -->
            <div>
                <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                    Photo de profil
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-[#2B5AA8] transition-all cursor-pointer">
                    <input 
                        type="file" 
                        wire:model="photo" 
                        class="hidden" 
                        id="photo-upload"
                        accept="image/*"
                    />
                    <label for="photo-upload" class="cursor-pointer">
                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <p class="text-sm text-gray-600">
                            Cliquez pour télécharger
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            JPG, PNG (max 2MB)
                        </p>
                    </label>
                </div>
                @if($photo)
                    <p class="text-sm text-green-600 mt-2">✓ Photo sélectionnée</p>
                @endif
                @error('photo') 
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <p class="text-sm text-yellow-800">
                Vos documents seront vérifiés par notre équipe sous 24-48h
            </p>
        </div>
    </div>
@endif

{{-- PAGE DE SUCCÈS --}}
@if($registrationComplete)
    <div class="text-center py-12 space-y-6">
        <!-- Icône de succès animée -->
        <div class="flex justify-center">
            <div class="relative">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center animate-pulse">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="absolute inset-0 w-24 h-24 bg-green-100 rounded-full animate-ping opacity-75"></div>
            </div>
        </div>

        <!-- Message principal -->
        <div class="space-y-3">
            <h2 class="text-3xl font-bold text-green-600">
                Inscription réussie !
            </h2>
            <p class="text-lg text-gray-700 font-medium">
                Votre demande est en cours de traitement
            </p>
        </div>

        <!-- Informations -->
        <div class="max-w-2xl mx-auto bg-blue-50 border-2 border-blue-200 rounded-xl p-6 space-y-4">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="text-left">
                    <h3 class="font-semibold text-blue-900 mb-2">Que se passe-t-il maintenant ?</h3>
                    <ul class="text-sm text-blue-800 space-y-2">
                        <li class="flex items-start">
                            <span class="inline-block w-2 h-2 bg-blue-600 rounded-full mt-1.5 mr-2 flex-shrink-0"></span>
                            <span>Notre équipe examine votre dossier et vos documents</span>
                        </li>
                        <li class="flex items-start">
                            <span class="inline-block w-2 h-2 bg-blue-600 rounded-full mt-1.5 mr-2 flex-shrink-0"></span>
                            <span>Vous recevrez un email de confirmation dans les 24-48h</span>
                        </li>
                        <li class="flex items-start">
                            <span class="inline-block w-2 h-2 bg-blue-600 rounded-full mt-1.5 mr-2 flex-shrink-0"></span>
                            <span>Une fois validé, vous pourrez commencer à enseigner sur Helpora</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Email de contact -->
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
            <p class="text-sm text-gray-600">
                Un email de confirmation vous a été envoyé à : 
                <span class="font-semibold text-gray-900">{{ $email }}</span>
            </p>
        </div>

        <!-- Boutons d'action -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
            <a 
                href="/" 
                class="px-8 py-3 bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91] transition-all font-bold shadow-md inline-flex items-center justify-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Retour à l'accueil
            </a>
            
            <a 
                href="/connexion" 
                class="px-8 py-3 bg-white border-2 border-[#2B5AA8] text-[#2B5AA8] rounded-lg hover:bg-gray-50 transition-all font-bold inline-flex items-center justify-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Se connecter
            </a>
        </div>
    </div>
@endif


                </div>

                <!-- Navigation Buttons -->
                @if(!$registrationComplete)
                <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
                    <button
                        type="button"
                        wire:click="previousStep"
                        @if($currentStep == 1) disabled @endif
                        class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all font-semibold disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Retour
                    </button>

                    @if($currentStep < 4)
                        <button
                            type="button"
                            wire:click="nextStep"
                            class="px-6 py-3 bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91] transition-all font-bold shadow-md flex items-center gap-2"
                        >
                            Continuer
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    @else
                        <button
                            type="button"
                            wire:click="submitRegistration"
                            class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all font-bold shadow-md"
                        >
                            Créer mon compte
                        </button>
                    @endif
                </div>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <a href="/connexion" class="text-sm text-[#2B5AA8] hover:underline font-semibold">
                        Vous avez déjà un compte ? Se connecter
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <livewire:shared.footer />

    @script
    <script>
        $wire.on('updateLocation', (data) => {
            // Code événement
        });

        window.getLocationForProfessor = function() {
            const btn = document.getElementById('locationBtn');
            
            if (!navigator.geolocation) {
                alert('La géolocalisation n\'est pas supportée par votre navigateur.');
                return;
            }

            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            btn.disabled = true;

            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    $wire.set('latitude', lat);
                    $wire.set('longitude', lng);

                    try {
                        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                        const data = await response.json();

                        if (data.address) {
                            const address = data.address;
                            $wire.set('adresseComplete', data.display_name);
                            $wire.set('ville', address.city || address.town || address.village || '');
                            $wire.set('region', address.state || address.province || address.region || '');
                            $wire.set('pays', address.country || '');
                        }

                        btn.innerHTML = originalHTML;
                        btn.disabled = false;
                    } catch (error) {
                        console.error('Erreur de géocodage:', error);
                        btn.innerHTML = originalHTML;
                        btn.disabled = false;
                        alert('Localisation détectée, mais impossible de récupérer l\'adresse. Veuillez remplir manuellement.');
                    }
                },
                (error) => {
                    btn.innerHTML = originalHTML;
                    btn.disabled = false;

                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            alert('❌ Accès à la localisation refusé. Veuillez autoriser l\'accès dans les paramètres de votre navigateur.');
                            break;
                        case error.POSITION_UNAVAILABLE:
                            alert('❌ Les informations de localisation ne sont pas disponibles.');
                            break;
                        case error.TIMEOUT:
                            alert('❌ La demande de localisation a expiré.');
                            break;
                        default:
                            alert('❌ Une erreur inconnue s\'est produite.');
                            break;
                    }
                },
                {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                }
            );
        };
    </script>
    @endscript
</div>