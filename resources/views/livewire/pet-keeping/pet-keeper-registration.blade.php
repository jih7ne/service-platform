<div>
<!-- MODAL DE SUCCÈS -->
@if(session()->has('registration_success'))
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="relative mx-auto p-8 border w-11/12 md:w-3/4 lg:w-1/2 max-w-2xl shadow-xl rounded-xl bg-white">
            <div class="flex justify-between items-start mb-8">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-full mr-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Inscription réussie !</h3>
                        <p class="text-green-600 font-medium mt-1">Bienvenue dans notre communauté</p>
                    </div>
                </div>
                <button wire:click="$set('registrationComplete', false)" 
                        class="text-gray-400 hover:text-gray-600 text-3xl leading-none h-8 w-8 flex items-center justify-center">
                    &times;
                </button>
            </div>
            
            <div class="bg-green-50 border-l-4 border-green-500 p-5 mb-6 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-green-800">
                        {!! session('registration_success') !!}
                    </div>
                </div>
            </div>
            
            <div class="bg-yellow-50 p-5 rounded-lg mb-8 border border-yellow-100">
                <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Prochaines étapes
                </h4>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <span class="inline-block w-2 h-2 bg-yellow-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                        <span class="text-gray-700">Votre compte est maintenant actif et sécurisé</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-block w-2 h-2 bg-yellow-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                        <span class="text-gray-700">Connectez-vous avec votre email et mot de passe</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-block w-2 h-2 bg-yellow-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                        <span class="text-gray-700">Nos équipes vérifient vos documents sous 24-48h</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-block w-2 h-2 bg-yellow-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                        <span class="text-gray-700">Notification par email lors de l'approbation</span>
                    </li>
                </ul>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="/connexion" 
                   class="px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition font-medium text-center flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Se connecter maintenant
                </a>
                <button wire:click="$set('registrationComplete', false)" 
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium text-center">
                    Fermer
                </button>
            </div>
        </div>
    </div>
@endif

<!-- MESSAGES D'ALERTE -->
<div class="space-y-4 mb-6">
    @error('submit')
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="font-bold text-base">Erreur lors de l'inscription</h3>
                    <p class="mt-1">{{ $message }}</p>
                </div>
            </div>
        </div>
    @enderror

    @if($uploadErrors)
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-5 py-4 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.698-.833-2.464 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <div>
                    <h3 class="font-bold text-base">Problèmes détectés avec les fichiers</h3>
                    <ul class="mt-2 space-y-1">
                        @foreach($uploadErrors as $error)
                            <li class="flex items-start">
                                <span class="inline-block w-1.5 h-1.5 bg-yellow-400 rounded-full mt-2 mr-2"></span>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- FORMULAIRE PRINCIPAL -->
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-3">Inscription PetKeeper</h1>
            <p class="text-gray-600 text-lg">Devenez gardien d'animaux professionnel en {{ $totalSteps }} étapes</p> <!-- Updated -->
        </div>
        
        <!-- Progress Steps -->
        <div class="mb-10">
            <div class="flex items-center justify-between mb-2">
                @foreach(['Profil', 'Vérification Email', 'Contact', 'Service', 'Professionnel', 'Disponibilités', 'Documents'] as $index => $step)
                    @php $stepNumber = $index + 1; @endphp
                    <div class="flex flex-col items-center flex-1 relative">
                        <button 
                            wire:click="goToStep({{ $stepNumber }})"
                            class="flex flex-col items-center focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 rounded-full"
                        >
                            <div class="w-12 h-12 rounded-full border-2 flex items-center justify-center mb-3 transition-all duration-200
                                {{ $currentStep == $stepNumber ? 'border-yellow-600 bg-yellow-600 text-white shadow-md' : 
                                ($currentStep > $stepNumber ? 'border-yellow-600 bg-yellow-600 text-white' : 'border-gray-300 bg-white text-gray-400') }}">
                                <span class="font-semibold">{{ $stepNumber }}</span>
                            </div>
                            <span class="text-sm font-medium {{ $currentStep >= $stepNumber ? 'text-gray-900' : 'text-gray-500' }}">
                                {{ $step }}
                            </span>
                        </button>
                        
                        @if($stepNumber < 7)  <!-- Fixed: changed from < 5 to < 7 -->
                            <div class="absolute top-6 left-1/2 w-full h-0.5 -translate-x-1/2 -z-10
                                {{ $currentStep > $stepNumber ? 'bg-yellow-600' : 'bg-gray-300' }}">
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-2">
                <p class="text-sm text-gray-600">Étape {{ $currentStep }} sur {{ $totalSteps }}</p>
            </div>
        </div>
        
        <!-- Step Content -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- Étape 1: Profil -->
            @if($currentStep == 1)
                <div>
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Informations personnelles</h2>
                        <p class="text-gray-600">Créez votre profil de base pour commencer</p>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Prénom -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                                <input type="text" wire:model="prenom" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                                       placeholder="Votre prénom">
                                @error('prenom') 
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Nom -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                                <input type="text" wire:model="nom" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                                       placeholder="Votre nom">
                                @error('nom') 
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" wire:model="email" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                                       placeholder="exemple@email.com">
                                @error('email') 
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Téléphone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone *</label>
                                <input type="tel" wire:model="telephone" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                                       placeholder="+33 1 23 45 67 89">
                                @error('telephone') 
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Date de naissance -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date de naissance *</label>
                                <input type="date" wire:model="dateNaissance" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition">
                                @error('dateNaissance') 
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Mot de passe -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe *</label>
                                <input type="password" wire:model="password" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                                       placeholder="••••••••">
                                @error('password') 
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Confirmation mot de passe -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe *</label>
                                <input type="password" wire:model="password_confirmation" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                                       placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            <!-- Étape 2: Vérification d'email -->
            @if ($currentStep === 2)
                <div>
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-2">
                            Vérification de votre email
                        </h2>
                        <p class="text-gray-600">
                            Entrez le code à 10 chiffres envoyé à votre adresse email
                        </p>
                    </div>

                    <div class="space-y-8">

                        <!-- Information sur l'envoi -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-blue-500 mt-0.5 mr-3 flex-shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>

                                <div>
                                    <h4 class="font-semibold text-blue-900 mb-2">
                                        Code envoyé par email
                                    </h4>
                                    <p class="text-blue-800">
                                        Un code de vérification à 10 chiffres a été envoyé à
                                        <strong class="font-semibold">
                                            {{ e($email) }}
                                        </strong>.
                                        Veuillez le saisir ci-dessous pour vérifier votre adresse email.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Code de vérification -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4">
                                Code de vérification *
                            </label>

                            <div class="max-w-2xl mx-auto">
                                <div class="grid grid-cols-10 gap-2 md:gap-3"
                                    id="verification-code-container"
                                    role="group"
                                    aria-label="Code de vérification à 10 chiffres">

                                    @for ($i = 0; $i < 10; $i++)
                                        <input
                                            type="text"
                                            inputmode="numeric"
                                            pattern="[0-9]"
                                            maxlength="1"
                                            autocomplete="one-time-code"
                                            wire:model.live.debounce.300ms="verification_code.{{ $i }}"
                                            wire:key="verification-digit-{{ $i }}"
                                            class="w-full aspect-square text-center text-2xl font-bold border-2 border-gray-300 rounded-lg
                                                focus:border-yellow-500 focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50
                                                transition-all duration-200 hover:border-gray-400"
                                            placeholder="•"
                                            aria-label="Chiffre {{ $i + 1 }}"
                                            oninput="moveFocus({{ $i }}, event)"
                                            onkeydown="handleKeyDown({{ $i }}, event)"
                                            onpaste="handlePaste(event)"
                                        />
                                    @endfor
                                </div>

                                <!-- Erreurs -->
                                @error('verification_code')
                                    <p class="mt-3 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                                @if ($verification_code_incomplete)
                                    <p class="mt-3 text-sm text-yellow-600">
                                        Veuillez entrer les 10 chiffres du code de vérification
                                    </p>
                                @endif
                            </div>

                            <p class="mt-4 text-sm text-gray-500 text-center">
                                Entrez les 10 chiffres dans l'ordre. Cliquez sur chaque case ou utilisez les touches fléchées.
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="border-t border-gray-200 pt-6">
                            <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">

                                <p class="text-sm text-gray-600">
                                    Vous n'avez pas reçu le code ?
                                </p>

                                <div class="flex space-x-3">

                                    <button
                                        type="button"
                                        wire:click="resendVerificationCode"
                                        wire:loading.attr="disabled"
                                        wire:target="resendVerificationCode"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg
                                            hover:bg-gray-50 transition text-sm font-medium disabled:opacity-50">

                                        <span wire:loading.remove wire:target="resendVerificationCode">
                                            <svg class="w-4 h-4 mr-2"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                                aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Renvoyer le code
                                        </span>

                                        <span wire:loading wire:target="resendVerificationCode">
                                            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-gray-700"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                aria-hidden="true">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4" />
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                                            </svg>
                                            Envoi en cours...
                                        </span>
                                    </button>

                                    <button
                                        type="button"
                                        wire:click="changeEmail"
                                        class="inline-flex items-center px-4 py-2 border border-yellow-300 text-yellow-700 rounded-lg
                                            hover:bg-yellow-50 transition text-sm font-medium">
                                        <svg class="w-4 h-4 mr-2"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Changer d'email
                                    </button>

                                </div>
                            </div>

                            @if (session()->has('verification_code_resent'))
                                <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                                    <p class="text-sm text-green-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ e(session('verification_code_resent')) }}
                                    </p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            @endif

            
            

            <!-- Étape 3: Contact -->
            @if($currentStep == 3)
                <div>
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Contact et localisation</h2>
                        <p class="text-gray-600">Informations pour vous contacter et vous localiser</p>
                    </div>
                    
                    <div class="space-y-8">
                        <!-- Téléphone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Téléphone *</label>
                            <input type="tel" wire:model="telephone" 
                                class="w-full md:w-2/3 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                                placeholder="Numéro de contact principal">
                            @error('telephone') 
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Geolocalisation Button -->
                        <div>
                             <!-- Bouton localisation automatique -->
                            <button
                                type="button"
                                id="locationBtnClient"
                                onclick="getLocationForClient()"
                                class="w-full py-3 bg-[#E1EAF7] text-[#2B5AA8] rounded-lg hover:bg-[#d1dbf0] transition-all font-semibold flex items-center justify-center gap-2 mb-4"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Obtenir ma localisation automatique
                            </button>
                        </div>

                        <!-- Adresse -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Adresse complète *</label>
                            <div class="space-y-4">
                                <input type="text" wire:model="adresse" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                                    placeholder="Numéro et nom de rue">
                                @error('adresse') 
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <input type="text" wire:model="ville" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                                            placeholder="Ville">
                                        @error('ville') 
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <input type="text" wire:model="code_postal" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                                            placeholder="Code postal">
                                        @error('code_postal') 
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <input type="text" wire:model="pays" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition bg-gray-50"
                                            placeholder="Pays">
                                        @error('pays') 
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Photo de profil -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Photo de profil</label>
                            <div class="flex flex-col sm:flex-row sm:items-start gap-6">
                                @if($profile_photo)
                                    <div class="relative flex-shrink-0">
                                        <img src="{{ $profile_photo->temporaryUrl() }}" 
                                            class="h-32 w-32 rounded-lg object-cover border-2 border-yellow-200 shadow-sm">
                                        <button type="button" 
                                                wire:click="removeFile('profile_photo')"
                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition">
                                            ×
                                        </button>
                                    </div>
                                @else
                                    <div class="h-32 w-32 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center bg-gray-50 flex-shrink-0">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <div class="relative">
                                        <label for="profile-photo-upload" 
                                            class="block border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-yellow-500 transition cursor-pointer bg-gray-50 hover:bg-yellow-50">
                                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="text-gray-600 mb-2">
                                                <span class="font-medium text-yellow-600">Cliquez pour télécharger</span> ou glissez-déposez
                                            </p>
                                            <p class="text-sm text-gray-500">PNG, JPG, GIF jusqu'à 10MB</p>
                                        </label>
                                        <input type="file" wire:model="profile_photo" 
                                            id="profile-photo-upload"
                                            accept="image/*"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    </div>
                                    @error('profile_photo') 
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif



            <!-- Étape 4: Création du service -->
            @if($currentStep == 4)
                <div>
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Création de vos services</h2>
                        <p class="text-gray-600">Configurez les services que vous proposez (maximum {{ $max_services }})</p>
                    </div>
                    
                    <!-- Services Container -->
                    <div class="space-y-8" id="services-container">
                        @foreach($services as $index => $service)
                        <div class="border border-gray-200 rounded-xl p-6 hover:border-yellow-300 transition" wire:key="service-{{ $index }}">
                            <!-- Service Header -->
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h3 class="font-medium text-gray-900 text-xl mb-2 flex items-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-yellow-100 text-yellow-800 rounded-full mr-3">
                                            {{ $index + 1 }}
                                        </span>
                                        Service {{ $index + 1 }}
                                        @if($service['service_name'])
                                            : <span class="text-gray-700 ml-2">{{ $service['service_name'] }}</span>
                                        @endif
                                    </h3>
                                    @if($index == 0)
                                        <p class="text-sm text-gray-600">Votre service principal</p>
                                    @else
                                        <p class="text-sm text-gray-600">Service supplémentaire</p>
                                    @endif
                                </div>
                                
                                @if($index > 0)
                                    <button type="button" 
                                            wire:click="removeService({{ $index }})"
                                            class="p-2 text-gray-400 hover:text-red-500 transition"
                                            title="Supprimer ce service">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                            
                            <!-- Service Form Fields -->
                            <div class="space-y-6">
                                <!-- Nom du service -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nom du service *
                                    </label>
                                    <input type="text" wire:model="services.{{ $index }}.service_name" 
                                        class="w-full md:w-2/3 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                                        placeholder="Ex: Gardiennage de chiens à domicile">
                                    @error('services.'.$index.'.service_name') 
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Description du service -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Description du service *
                                    </label>
                                    <textarea wire:model="services.{{ $index }}.service_description" 
                                            rows="3"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                                            placeholder="Décrivez votre service, vos compétences, votre approche..."></textarea>
                                    @error('services.'.$index.'.service_description') 
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Catégorie et Type d'animal -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Catégorie du service -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Catégorie du service *
                                        </label>
                                        <select wire:model="services.{{ $index }}.service_category" 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition bg-white">
                                            <option value="">Sélectionnez une catégorie</option>
                                            @foreach(App\Constants\PetKeeping\Constants::forSelect() as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @error('services.'.$index.'.service_category') 
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <!-- Type d'animal -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Type d'animal accepté *
                                        </label>
                                        <select wire:model="services.{{ $index }}.service_pet_type" 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition bg-white">
                                            <option value="">Sélectionnez un type</option>
                                            @foreach(App\Constants\PetKeeping\Constants::getSelectOptions() as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @error('services.'.$index.'.service_pet_type') 
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Critère de paiement et Prix de base -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Critère de paiement -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Critère de paiement *
                                        </label>
                                        <select wire:model="services.{{ $index }}.service_payment_criteria" 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition bg-white">
                                            @foreach(App\Constants\PetKeeping\Constants::forSelectCriteria() as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @error('services.'.$index.'.service_payment_criteria') 
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <!-- Prix de base -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Prix de base (DH) *
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500">DH</span>
                                            </div>
                                            <input type="number" wire:model="services.{{ $index }}.service_base_price" min="0" step="0.01"
                                                class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                                                placeholder="10.00">
                                        </div>
                                        @error('services.'.$index.'.service_base_price') 
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Statut du service -->
                                <div class="max-w-md">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Statut du service *
                                    </label>
                                    <select wire:model="services.{{ $index }}.service_status" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition bg-white">
                                        <option value="ACTIVE">Actif (visible pour les clients)</option>
                                        <option value="INACTIVE">Inactif (non visible)</option>
                                    </select>
                                    @error('services.'.$index.'.service_status') 
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Conditions spécifiques (Checkboxes) -->
                                <div class="border border-gray-200 rounded-xl p-6 bg-gray-50 mt-4">
                                    <h4 class="font-medium text-gray-900 mb-4">Conditions spécifiques</h4>
                                    
                                    <div class="space-y-4">
                                        <!-- Vaccination requise -->
                                        <label class="flex items-start p-3 border border-gray-200 rounded-lg hover:bg-white hover:border-yellow-300 transition cursor-pointer bg-white">
                                            <input type="checkbox" wire:model="services.{{ $index }}.service_vaccination_required" 
                                                class="mt-1 mr-3 h-5 w-5 text-yellow-600 rounded border-gray-300 focus:ring-yellow-500">
                                            <div>
                                                <span class="font-medium text-gray-900">Vaccination requise</span>
                                                <p class="text-sm text-gray-600 mt-1">Je n'accepte que les animaux à jour de leurs vaccins</p>
                                            </div>
                                        </label>
                                        
                                        <!-- Animaux non éduqués -->
                                        <label class="flex items-start p-3 border border-gray-200 rounded-lg hover:bg-white hover:border-yellow-300 transition cursor-pointer bg-white">
                                            <input type="checkbox" wire:model="services.{{ $index }}.service_accepts_untrained_pets" 
                                                class="mt-1 mr-3 h-5 w-5 text-yellow-600 rounded border-gray-300 focus:ring-yellow-500">
                                            <div>
                                                <span class="font-medium text-gray-900">J'accepte les animaux non éduqués</span>
                                                <p class="text-sm text-gray-600 mt-1">Je suis formé(e) pour gérer les animaux avec des problèmes comportementaux</p>
                                            </div>
                                        </label>
                                        
                                        <!-- Animaux agressifs -->
                                        <label class="flex items-start p-3 border border-gray-200 rounded-lg hover:bg-white hover:border-yellow-300 transition cursor-pointer bg-white">
                                            <input type="checkbox" wire:model="services.{{ $index }}.service_accepts_aggressive_pets" 
                                                class="mt-1 mr-3 h-5 w-5 text-yellow-600 rounded border-gray-300 focus:ring-yellow-500">
                                            <div>
                                                <span class="font-medium text-gray-900">J'accepte les animaux agressifs</span>
                                                <p class="text-sm text-gray-600 mt-1">Je suis qualifié(e) pour prendre en charge des animaux avec des antécédents d'agressivité</p>
                                                <p class="text-xs text-yellow-600 mt-2">
                                                    ⚠️ Nécessite certification et assurance adaptée
                                                </p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Service Summary -->
                                @if($service['service_name'] || $service['service_category'])
                                    <div class="border-t border-gray-200 pt-6 mt-6">
                                        <h4 class="font-medium text-gray-900 mb-3">Récapitulatif</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="space-y-2">
                                                @if($service['service_category'])
                                                    <div class="flex justify-between">
                                                        <span class="text-gray-600">Catégorie :</span>
                                                        <span class="font-medium text-gray-900">
                                                            @php
                                                                $serviceCategories = App\Constants\PetKeeping\Constants::forSelect();
                                                            @endphp
                                                            {{ $serviceCategories[$service['service_category']] ?? '' }}
                                                        </span>
                                                    </div>
                                                @endif
                                                @if($service['service_pet_type'])
                                                    <div class="flex justify-between">
                                                        <span class="text-gray-600">Type d'animal :</span>
                                                        <span class="font-medium text-gray-900">
                                                            @php
                                                                $petTypes = App\Constants\PetKeeping\Constants::getSelectOptions();
                                                            @endphp
                                                            {{ $petTypes[$service['service_pet_type']] ?? '' }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="space-y-2">
                                                @if($service['service_base_price'])
                                                    <div class="flex justify-between">
                                                        <span class="text-gray-600">Prix :</span>
                                                        <span class="font-medium text-gray-900">{{ number_format($service['service_base_price'], 2) }} €</span>
                                                    </div>
                                                @endif
                                                @if($service['service_payment_criteria'])
                                                    <div class="flex justify-between">
                                                        <span class="text-gray-600">Facturation :</span>
                                                        <span class="font-medium text-gray-900">
                                                            @php
                                                                $criteriaLabels = App\Constants\PetKeeping\Constants::forSelectCriteria();
                                                            @endphp
                                                            {{ $criteriaLabels[$service['service_payment_criteria']] ?? '' }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Add Service Button -->
                    @if(count($services) < $max_services)
                        <div class="mt-8 text-center">
                            <button type="button"
                                    wire:click="addService"
                                    class="inline-flex items-center px-6 py-3 border-2 border-dashed border-gray-300 text-gray-700 rounded-xl hover:border-yellow-500 hover:bg-yellow-50 transition font-medium">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Ajouter un autre service ({{ count($services) }}/{{ $max_services }})
                            </button>
                            <p class="text-sm text-gray-500 mt-2">Vous pouvez ajouter jusqu'à {{ $max_services }} services</p>
                        </div>
                    @else
                        <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-yellow-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-yellow-800">
                                        Vous avez atteint le nombre maximum de services ({{ $max_services }}). 
                                        Vous pourrez ajouter d'autres services plus tard depuis votre tableau de bord.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Services Overview -->
                    @if(count($services) > 0)
                        <div class="mt-8 border-t border-gray-200 pt-8">
                            <h3 class="font-medium text-gray-900 text-xl mb-4">Vue d'ensemble de vos services</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($services as $index => $service)
                                    <div class="border border-gray-200 rounded-xl p-5 hover:shadow-md transition">
                                        <div class="flex justify-between items-start mb-3">
                                            <h4 class="font-medium text-gray-900">
                                                <span class="inline-flex items-center justify-center w-6 h-6 bg-yellow-100 text-yellow-800 rounded-full text-sm mr-2">
                                                    {{ $index + 1 }}
                                                </span>
                                                {{ $service['service_name'] ?: 'Service ' . ($index + 1) }}
                                            </h4>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $service['service_status'] == 'ACTIVE' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $service['service_status'] == 'ACTIVE' ? 'Actif' : 'Inactif' }}
                                            </span>
                                        </div>
                                        
                                        @if($service['service_category'])
                                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                                @php
                                                    $serviceCategories = App\Constants\PetKeeping\Constants::forSelect();
                                                @endphp
                                                {{ $serviceCategories[$service['service_category']] ?? '' }}
                                            </div>
                                        @endif
                                        
                                        @if($service['service_base_price'])
                                            <div class="flex items-center text-sm text-gray-600 mb-3">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ number_format($service['service_base_price'], 2) }} €
                                                @if($service['service_payment_criteria'])
                                                    @php
                                                        $criteriaLabels = App\Constants\PetKeeping\Constants::forSelectCriteria();
                                                    @endphp
                                                    / {{ strtolower($criteriaLabels[$service['service_payment_criteria']] ?? '') }}
                                                @endif
                                            </div>
                                        @endif
                                        
                                        @if($service['service_description'])
                                            <p class="text-sm text-gray-600 line-clamp-2">
                                                {{ Str::limit($service['service_description'], 100) }}
                                            </p>
                                        @endif
                                        
                                        <!-- Conditions badges -->
                                        <div class="flex flex-wrap gap-2 mt-4">
                                            @if($service['service_vaccination_required'])
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Vaccination requise
                                                </span>
                                            @endif
                                            @if($service['service_accepts_untrained_pets'])
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Accepte non-éduqués
                                                </span>
                                            @endif
                                            @if($service['service_accepts_aggressive_pets'])
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Accepte agressifs
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif





            
            <!-- Étape 5: Professionnel -->
            @if($currentStep == 5)
                <div>
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Informations professionnelles</h2>
                        <p class="text-gray-600">Présentez votre expérience et qualifications</p>
                    </div>
                    
                    <div class="space-y-8">
                        <!-- Années d'expérience -->
                        <div class="max-w-md">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Niveau d'expérience avec les animaux *
                            </label>
                            <select wire:model="years_experience"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition bg-white">
                                <option value="">Sélectionnez votre niveau d'expérience</option>
                                @foreach($experienceIntervals as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('years_experience') 
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Spécialité -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Votre spécialité *
                            </label>
                            <input type="text" wire:model="specialite" 
                                   class="w-full md:w-2/3 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                                   placeholder="Ex: Chiens, Chats, NAC, Équidés...">
                            @error('specialite') 
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">Décrivez votre domaine d'expertise principal</p>
                        </div>
                        
                        <!-- Certifications -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4">
                                Certifications et formations
                            </label>
                            <p class="text-gray-600 mb-4">Sélectionnez vos qualifications</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($certificationList as $certification)
                                    <label class="flex items-start p-4 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-yellow-300 transition cursor-pointer">
                                        <input type="checkbox" wire:model="certifications" 
                                               value="{{ $certification }}" 
                                               class="mt-1 mr-3 h-5 w-5 text-yellow-600 rounded border-gray-300 focus:ring-yellow-500">
                                        <span class="text-gray-700">{{ $certification }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Étape 6: Disponibilités -->
            @if($currentStep == 6)
                <div>
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Disponibilités</h2>
                        <p class="text-gray-600">Définissez vos créneaux disponibles pour chaque jour</p>
                    </div>
                    
                    <div class="space-y-6">
                        @foreach($days as $day)
                            <div class="border border-gray-200 rounded-xl p-5 hover:border-yellow-300 transition">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4">
                                    <h3 class="font-medium text-gray-900 text-lg mb-2 sm:mb-0">{{ $day }}</h3>
                                    <button type="button" 
                                            wire:click="addAvailability('{{ $day }}')"
                                            class="inline-flex items-center px-4 py-2 bg-yellow-50 text-yellow-700 rounded-lg hover:bg-yellow-100 transition text-sm font-medium">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Ajouter un créneau
                                    </button>
                                </div>
                                
                                @if(isset($availabilities[$day]) && count($availabilities[$day]) > 0)
                                    <div class="space-y-3">
                                        @foreach($availabilities[$day] as $index => $slot)
                                            <div class="flex items-center space-x-4 p-3 bg-gray-50 rounded-lg">
                                                <div class="flex-1 flex items-center space-x-4">
                                                    <div class="flex items-center space-x-2 flex-1">
                                                        <label class="text-sm text-gray-600">De</label>
                                                        <input type="time" 
                                                               wire:model="availabilities.{{ $day }}.{{ $index }}.start"
                                                               class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition">
                                                    </div>
                                                    <div class="flex items-center space-x-2 flex-1">
                                                        <label class="text-sm text-gray-600">à</label>
                                                        <input type="time" 
                                                               wire:model="availabilities.{{ $day }}.{{ $index }}.end"
                                                               class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition">
                                                    </div>
                                                </div>
                                                <button type="button" 
                                                        wire:click="removeAvailability('{{ $day }}', {{ $index }})"
                                                        class="p-2 text-gray-400 hover:text-red-500 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-gray-500">Aucun créneau défini pour ce jour</p>
                                        <p class="text-sm text-gray-400 mt-1">Cliquez sur "Ajouter un créneau" pour commencer</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            
            <!-- Étape 7: Documents -->
            @if($currentStep == 7)
                <div>
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Documents requis</h2>
                        <p class="text-gray-600">Téléchargez les documents nécessaires pour finaliser votre inscription</p>
                    </div>
                    
                    <div class="space-y-8">
                        <!-- Extrait de casier judiciaire -->
                        <div class="border border-gray-200 rounded-xl p-6 hover:border-yellow-300 transition">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="font-medium text-gray-900 text-lg mb-1">Extrait de casier judiciaire *</h3>
                                    <p class="text-sm text-gray-600">Document obligatoire pour tous les gardiens</p>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Obligatoire
                                </span>
                            </div>
                            <div class="relative">
                                <label for="criminal-record-upload" 
                                    class="block border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-yellow-500 transition cursor-pointer bg-gray-50 hover:bg-yellow-50">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-gray-600 mb-2">
                                        <span class="font-medium text-yellow-600">Télécharger le document</span>
                                    </p>
                                    <p class="text-sm text-gray-500">PDF, JPG ou PNG - Max. 10MB</p>
                                </label>
                                <input type="file" wire:model="criminal_record" 
                                    id="criminal-record-upload"
                                    accept=".pdf,.jpg,.png"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            </div>
                            @error('criminal_record') 
                                <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Justificatif de domicile -->
                        <div class="border border-gray-200 rounded-xl p-6 hover:border-yellow-300 transition">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="font-medium text-gray-900 text-lg mb-1">Justificatif de domicile *</h3>
                                    <p class="text-sm text-gray-600">Facture d'électricité, eau, internet de moins de 3 mois</p>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Obligatoire
                                </span>
                            </div>
                            <div class="relative">
                                <label for="proof-of-address-upload" 
                                    class="block border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-yellow-500 transition cursor-pointer bg-gray-50 hover:bg-yellow-50">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    <p class="text-gray-600 mb-2">
                                        <span class="font-medium text-yellow-600">Télécharger le document</span>
                                    </p>
                                    <p class="text-sm text-gray-500">PDF, JPG ou PNG - Max. 10MB</p>
                                </label>
                                <input type="file" wire:model="proof_of_address" 
                                    id="proof-of-address-upload"
                                    accept=".pdf,.jpg,.png"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            </div>
                            @error('proof_of_address') 
                                <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Certificats animaux -->
                        <div class="border border-gray-200 rounded-xl p-6 hover:border-yellow-300 transition">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="font-medium text-gray-900 text-lg mb-1">Certificats et diplômes animaux</h3>
                                    <p class="text-sm text-gray-600">Vos certifications spécifiques (optionnel, multiple possible)</p>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Optionnel
                                </span>
                            </div>
                            <div class="relative">
                                <label for="animal-certificates-upload" 
                                    class="block border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-yellow-500 transition cursor-pointer bg-gray-50 hover:bg-yellow-50">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    <p class="text-gray-600 mb-2">
                                        <span class="font-medium text-yellow-600">Télécharger les documents</span>
                                    </p>
                                    <p class="text-sm text-gray-500">PDF, JPG ou PNG - Max. 10MB par fichier</p>
                                </label>
                                <input type="file" wire:model="animal_certificates" multiple
                                    id="animal-certificates-upload"
                                    accept=".pdf,.jpg,.png"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center pt-8 mt-8 border-t">
                <div>
                    @if($currentStep > 1)
                        <button wire:click="previousStep" 
                                class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Précédent
                        </button>
                    @endif
                </div>
                
                <div>
                    @if($currentStep < $totalSteps)
                        <button wire:click="nextStep" 
                                class="inline-flex items-center px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition font-medium shadow-sm">
                            Suivant
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    @else
                        <button wire:click="submit" 
                                wire:loading.attr="disabled"
                                class="inline-flex items-center px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium shadow-sm disabled:opacity-70">
                            <span wire:loading.remove class="flex items-center">
                                Finaliser l'inscription
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </span>
                            <span wire:loading class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Traitement en cours...
                            </span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Pied de page -->
        <div class="text-center mt-8 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-600">
                Vous avez déjà un compte ?
                <a href="/connexion" class="text-yellow-600 hover:text-yellow-700 font-medium">Se connecter</a>
            </p>
            <p class="text-xs text-gray-500 mt-2">
                En vous inscrivant, vous acceptez nos 
                <a href="#" class="text-gray-600 hover:text-gray-900">Conditions d'utilisation</a> et 
                <a href="#" class="text-gray-600 hover:text-gray-900">Politique de confidentialité</a>
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {

        Livewire.on('step-changed', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        Livewire.on('service-added', () => {
            setTimeout(() => {
                const servicesContainer = document.getElementById('services-container');
                const lastService = servicesContainer.lastElementChild;
                if (lastService) {
                    lastService.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 100);
        });

        const getInput = (index) =>
            document.querySelector(`input[wire\\:key="verification-digit-${index}"]`);

        // Déplacer le focus automatiquement
        window.moveFocus = function (index, event) {
            const input = event.target;
            const value = input.value;

            // Autoriser uniquement les chiffres
            if (!/^\d$/.test(value)) {
                input.value = '';
                return;
            }

            // Aller au champ suivant
            if (index < 9) {
                const nextInput = getInput(index + 1);
                nextInput?.focus();
            }

            updateFullCode();
        };

        // Gestion du clavier
        window.handleKeyDown = function (index, event) {
            const input = event.target;

            if (event.key === 'ArrowLeft' && index > 0) {
                event.preventDefault();
                getInput(index - 1)?.focus();
            }

            else if ((event.key === 'ArrowRight' || event.key === ' ') && index < 9) {
                event.preventDefault();
                getInput(index + 1)?.focus();
            }

            else if (event.key === 'Backspace') {
                if (input.value === '' && index > 0) {
                    event.preventDefault();
                    const prev = getInput(index - 1);
                    if (prev) {
                        prev.value = '';
                        prev.focus();
                    }
                }
                setTimeout(updateFullCode, 10);
            }

            else if (event.key === 'Delete') {
                setTimeout(updateFullCode, 10);
            }
        };

        // Gestion du collage
        window.handlePaste = function (event) {
            event.preventDefault();

            const digits = event.clipboardData
                .getData('text')
                .replace(/\D/g, '')
                .slice(0, 10)
                .split('');

            digits.forEach((digit, index) => {
                const input = getInput(index);
                if (input) input.value = digit;
            });

            getInput(9)?.focus();
            updateFullCode();
        };

        // Mise à jour du code complet
        function updateFullCode() {
            let fullCode = '';

            for (let i = 0; i < 10; i++) {
                const input = getInput(i);
                if (input?.value) {
                    fullCode += input.value;
                }
            }

            @this.set('verification_code_full', fullCode.length === 10 ? fullCode : '');
        }




        // Reset depuis Livewire
        Livewire.on('clear-verification-code', () => {
            for (let i = 0; i < 10; i++) {
                const input = getInput(i);
                if (input) input.value = '';
            }
            updateFullCode();
        });



        // GeoLocalisation

        // Fonction de géolocalisation pour client
        window.getLocationForClient = function() {
            const btn = document.getElementById('locationBtnClient');
            
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

                    @this.set('latitude', lat);
                    @this.set('longitude', lng);

                    try {
                        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                        const data = await response.json();

                        if (data.address) {
                            const address = data.address;
                            @this.set('adresse', data.display_name);
                            @this.set('ville', address.city || address.town || address.village || '');
                            @this.set('pays', address.country || '');
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

        setInterval(function() {
            fetch('/refresh-csrf').then(response => response.json()).then(data => {
                document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.token);
            }).catch(error => console.error('Erreur rafraîchissement CSRF:', error));
        }, 600000);

    });
</script>
@endpush

</div>