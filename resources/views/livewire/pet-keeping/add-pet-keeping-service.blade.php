<div class="flex min-h-screen bg-gray-50">
    <!-- SIDEBAR GAUCHE -->
    <aside class="w-72 bg-white h-screen fixed left-0 top-0 border-r border-gray-100 flex flex-col z-40 shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
        <!-- Logo -->
        <div class="p-8 flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-700 rounded-xl flex items-center justify-center text-white font-bold shadow-amber-200 shadow-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
            </div>
            <span class="text-2xl font-extrabold text-gray-800 tracking-tight">Helpora</span>
        </div>

        <div class="px-6 pb-6">
            <p class="text-xs font-bold text-gray-400 mb-4 uppercase tracking-wider pl-2">Espace PetKeeper</p>
            
            <!-- Carte Profil Miniature -->
            <div class="bg-white rounded-2xl p-3 flex items-center gap-3 border border-gray-100 shadow-sm group hover:border-amber-200 transition-colors cursor-pointer">
                <div class="w-12 h-12 rounded-full bg-gray-100 p-0.5 border-2 border-white shadow-sm overflow-hidden">
                    @if(isset($user->photo) && $user->photo)
                        <img src="{{ Storage::url($user->photo) }}" class="w-full h-full rounded-full object-cover">
                    @else
                        <img class="w-full h-full rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ $user->prenom }}+{{ $user->nom }}&background=d97706&color=fff" alt="Avatar">
                    @endif
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-900 leading-tight group-hover:text-amber-700 transition-colors">
                        {{ $user->prenom }} {{ $user->nom }}
                    </h4>
                    <div class="flex items-center text-xs text-amber-600 font-bold mt-0.5">
                        <span class="bg-amber-50 px-1.5 py-0.5 rounded text-[10px] tracking-wide">★ {{ $user->note ?? 4.8 }}</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 flex items-center justify-between text-[11px] font-semibold text-gray-500 bg-gray-50 rounded-lg p-2 px-4">
                <span>{{ $number_of_services ?? 0 }} services</span>
                <span class="text-green-600 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> En ligne
                </span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
            <a href="/pet-keeper/dashboard" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Tableau de bord
            </a>
            
            <a href="/pet-keeper/missions" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Mes Missions
            </a>

            <a href="/pet-keeper/profile" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Mon Profil
            </a>

            <a href="/pet-keeper/dashboard/services" class="flex items-center gap-3 px-4 py-3.5 bg-amber-50 text-amber-800 font-bold rounded-xl transition-all shadow-sm border-l-4 border-amber-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                Mes Services
            </a>

            <a href="/pet-keeper/dashboard/clients" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 0a11 11 0 01-2.5 7.5"/>
                </svg>
                Mes Clients
            </a>

            <a href="/pet-keeper/dashboard/disponibilites" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Disponibilités
            </a>
        </nav>

        <div class="p-6">
            <button class="flex items-center gap-3 text-gray-400 font-bold text-sm hover:text-red-500 transition-colors w-full px-4 py-2 hover:bg-red-50 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Déconnexion
            </button>
        </div>
    </aside>

    <!-- CONTENU PRINCIPAL -->
    <main class="flex-1 ml-72 p-8">
        <!-- Header avec breadcrumb -->
        <div class="mb-8">
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                <a href="/pet-keeper/dashboard" class="hover:text-amber-600 transition-colors">Tableau de bord</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <a href="/pet-keeper/dashboard/services" class="hover:text-amber-600 transition-colors">Mes Services</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-900 font-medium">Ajouter un service</span>
            </div>
            
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Créer un nouveau service</h1>
                    <p class="text-gray-600">Définissez les détails de votre service de garde d'animaux</p>
                </div>
                <a href="/pet-keeper/dashboard/services" class="px-4 py-2 text-gray-600 hover:text-gray-900 font-medium transition-colors">
                    ← Retour
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <p class="font-medium text-green-900">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <p class="font-medium text-red-900">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Service Limit Info -->
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="font-medium text-blue-900">Limite de services</p>
                <p class="text-sm text-blue-700 mt-1">Vous avez créé {{ $number_of_services }} service(s) sur {{ $max_services }} autorisé(s).</p>
            </div>
        </div>

        <!-- Formulaire -->
        <form wire:submit.prevent="submit">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <!-- Service Form Fields -->
                <div class="space-y-6">
                    <!-- Nom du service -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nom du service *
                        </label>
                        <input type="text" wire:model="service_name" 
                            class="w-full md:w-2/3 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition"
                            placeholder="Ex: Gardiennage de chiens à domicile">
                        @error('service_name') 
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Description du service -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Description du service *
                        </label>
                        <textarea wire:model="service_description" 
                                rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition"
                                placeholder="Décrivez votre service, vos compétences, votre approche..."></textarea>
                        @error('service_description') 
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
                            <select wire:model="service_category" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition bg-white">
                                <option value="">Sélectionnez une catégorie</option>
                                @foreach(App\Constants\PetKeeping\Constants::forSelect() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('service_category') 
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Type d'animal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Type d'animal accepté *
                            </label>
                            <select wire:model="service_pet_type" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition bg-white">
                                <option value="">Sélectionnez un type</option>
                                @foreach(App\Constants\PetKeeping\Constants::getSelectOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('service_pet_type') 
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
                            <select wire:model="service_payment_criteria" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition bg-white">
                                @foreach(App\Constants\PetKeeping\Constants::forSelectCriteria() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('service_payment_criteria') 
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Prix de base -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Prix de base (€) *
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">€</span>
                                </div>
                                <input type="number" wire:model="service_base_price" min="0" step="0.01"
                                    class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition"
                                    placeholder="10.00">
                            </div>
                            @error('service_base_price') 
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Statut du service -->
                    <div class="max-w-md">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Statut du service *
                        </label>
                        <select wire:model="service_status" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition bg-white">
                            <option value="ACTIVE">Actif (visible pour les clients)</option>
                            <option value="INACTIVE">Inactif (non visible)</option>
                        </select>
                        @error('service_status') 
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Conditions spécifiques (Checkboxes) -->
                    <div class="border border-gray-200 rounded-xl p-6 bg-gray-50 mt-4">
                        <h4 class="font-medium text-gray-900 mb-4">Conditions spécifiques</h4>
                        
                        <div class="space-y-4">
                            <!-- Vaccination requise -->
                            <label class="flex items-start p-3 border border-gray-200 rounded-lg hover:bg-white hover:border-amber-300 transition cursor-pointer bg-white">
                                <input type="checkbox" wire:model="service_vaccination_required" 
                                    class="mt-1 mr-3 h-5 w-5 text-amber-600 rounded border-gray-300 focus:ring-amber-500">
                                <div>
                                    <span class="font-medium text-gray-900">Vaccination requise</span>
                                    <p class="text-sm text-gray-600 mt-1">Je n'accepte que les animaux à jour de leurs vaccins</p>
                                </div>
                            </label>
                            
                            <!-- Animaux non éduqués -->
                            <label class="flex items-start p-3 border border-gray-200 rounded-lg hover:bg-white hover:border-amber-300 transition cursor-pointer bg-white">
                                <input type="checkbox" wire:model="service_accepts_untrained_pets" 
                                    class="mt-1 mr-3 h-5 w-5 text-amber-600 rounded border-gray-300 focus:ring-amber-500">
                                <div>
                                    <span class="font-medium text-gray-900">J'accepte les animaux non éduqués</span>
                                    <p class="text-sm text-gray-600 mt-1">Je suis formé(e) pour gérer les animaux avec des problèmes comportementaux</p>
                                </div>
                            </label>
                            
                            <!-- Animaux agressifs -->
                            <label class="flex items-start p-3 border border-gray-200 rounded-lg hover:bg-white hover:border-amber-300 transition cursor-pointer bg-white">
                                <input type="checkbox" wire:model="service_accepts_aggressive_pets" 
                                    class="mt-1 mr-3 h-5 w-5 text-amber-600 rounded border-gray-300 focus:ring-amber-500">
                                <div>
                                    <span class="font-medium text-gray-900">J'accepte les animaux agressifs</span>
                                    <p class="text-sm text-gray-600 mt-1">Je suis qualifié(e) pour prendre en charge des animaux avec des antécédents d'agressivité</p>
                                    <p class="text-xs text-amber-600 mt-2">
                                        ⚠️ Nécessite certification et assurance adaptée
                                    </p>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Service Summary -->
                    @if($service_name || $service_category)
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <h4 class="font-medium text-gray-900 mb-3">Récapitulatif</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    @if($service_category)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Catégorie :</span>
                                            <span class="font-medium text-gray-900">
                                                @php
                                                    $serviceCategories = App\Constants\PetKeeping\Constants::forSelect();
                                                @endphp
                                                {{ $serviceCategories[$service_category] ?? '' }}
                                            </span>
                                        </div>
                                    @endif
                                    @if($service_pet_type)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Type d'animal :</span>
                                            <span class="font-medium text-gray-900">
                                                @php
                                                    $petTypes = App\Constants\PetKeeping\Constants::getSelectOptions();
                                                @endphp
                                                {{ $petTypes[$service_pet_type] ?? '' }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="space-y-2">
                                    @if($service_base_price)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Prix :</span>
                                            <span class="font-medium text-gray-900">{{ number_format($service_base_price, 2) }} €</span>
                                        </div>
                                    @endif
                                    @if($service_payment_criteria)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Facturation :</span>
                                            <span class="font-medium text-gray-900">
                                                @php
                                                    $criteriaLabels = App\Constants\PetKeeping\Constants::forSelectCriteria();
                                                @endphp
                                                {{ $criteriaLabels[$service_payment_criteria] ?? '' }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="/pet-keeper/dashboard/services" 
                       class="px-6 py-3 text-gray-700 font-medium hover:text-gray-900 transition-colors">
                        Annuler
                    </a>
                    <button type="button" 
                            wire:click="submit"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-50 cursor-not-allowed"
                            class="px-8 py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-bold rounded-xl hover:from-amber-600 hover:to-amber-700 transition-all shadow-lg shadow-amber-200 hover:shadow-xl hover:shadow-amber-300 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="submit">Créer le service</span>
                        <span wire:loading wire:target="submit" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Création en cours...
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </main>
</div>