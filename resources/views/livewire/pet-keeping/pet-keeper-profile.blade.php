<div>
<livewire:shared.header />

<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-amber-50">
    <!-- Messages flash -->
    @if(session()->has('success'))
        <div class="fixed top-4 right-4 z-50 max-w-md">
            <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg animate-slide-in flex items-center">
                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    
    @if(session()->has('error'))
        <div class="fixed top-4 right-4 z-50 max-w-md">
            <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg animate-slide-in flex items-center">
                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-gradient-to-r from-amber-500 to-yellow-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center justify-center space-x-4">
                    
                    <h1 class="text-2xl font-bold text-white">Profil PetKeeper</h1>
                </div>
                
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-amber-400 to-yellow-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                <div class="flex items-center">
                    <div class="bg-white bg-opacity-20 p-3 rounded-full mr-4">
                        <span class="text-2xl">📊</span>
                    </div>
                    <div>
                        <p class="text-sm opacity-90">Missions terminées</p>
                        <p class="text-2xl font-bold">{{ $stats['completed_missions'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-yellow-400 to-amber-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                <div class="flex items-center">
                    <div class="bg-white bg-opacity-20 p-3 rounded-full mr-4">
                        <span class="text-2xl">⭐</span>
                    </div>
                    <div>
                        <p class="text-sm opacity-90">Note moyenne</p>
                        <p class="text-2xl font-bold">{{ isset($stats['avg_rating']) ? round($stats['avg_rating'], 1) . '/5' : '0/5' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-amber-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                <div class="flex items-center">
                    <div class="bg-white bg-opacity-20 p-3 rounded-full mr-4">
                        <span class="text-2xl">💰</span>
                    </div>
                    <div>
                        <p class="text-sm opacity-90">Revenu total</p>
                        <p class="text-2xl font-bold">{{ isset($stats['total_earnings']) ? number_format($stats['total_earnings'], 0, ',', ' ') . ' DH' : '0 DH' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-yellow-500 to-amber-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition duration-300">
                <div class="flex items-center">
                    <div class="bg-white bg-opacity-20 p-3 rounded-full mr-4">
                        <span class="text-2xl">🔄</span>
                    </div>
                    <div>
                        <p class="text-sm opacity-90">Clients fidèles</p>
                        <p class="text-2xl font-bold">{{ $stats['repeat_clients'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne gauche : Profil -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Carte profil -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-amber-200">
                    <div class="bg-gradient-to-r from-amber-100 to-yellow-100 p-6">
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    @if(isset($user->photo) && $user->photo)
                                        <img src="{{ Storage::url($user->photo) }}" 
                                             class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg">
                                    @else
                                        <div class="w-28 h-28 rounded-full bg-gradient-to-br from-amber-400 to-yellow-500 flex items-center justify-center text-4xl text-white shadow-lg">
                                            🐕
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h2 class="text-3xl font-bold text-gray-900">
                                        {{ $user->prenom ?? '' }} {{ $user->nom ?? '' }}
                                    </h2>
                                    <div class="flex items-center mt-1">
                                        <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-sm font-semibold">
                                            {{ $petKeeper->specialite ?? 'PetKeeper' }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 mt-2">
                                        <span class="inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                            </svg>
                                            @if($localisation)
                                                {{ $localisation->ville ?? '' }}, {{ $localisation->adresse ?? '' }}
                                            @else
                                                Localisation non définie
                                            @endif
                                        </span>
                                    </p>
                                    <div class="flex items-center mt-3">
                                        <div class="flex text-amber-500">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= round($stats['avg_rating'] ?? 0))
                                                    ★
                                                @else
                                                    ☆
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="ml-2 font-semibold text-gray-700">{{ round($stats['avg_rating'] ?? 0, 1) }}</span>
                                        <span class="mx-2 text-gray-400">•</span>
                                        <span class="text-gray-600">{{ $stats['completed_missions'] ?? 0 }} missions</span>
                                    </div>
                                </div>
                            </div>
                            <button wire:click="startEditing('profile')"
                                    class="px-5 py-2 bg-gradient-to-r from-amber-500 to-yellow-500 text-white rounded-lg hover:from-amber-600 hover:to-yellow-600 shadow font-semibold">
                                ✏️ Modifier
                            </button>
                        </div>
                    </div>

                    <!-- Bio et informations -->
                    <div class="p-6">
                        @if($isEditing && $editingSection === 'profile')
                            <div class="mb-6 p-4 bg-gradient-to-r from-amber-50 to-yellow-50 rounded-xl border border-amber-200">
                                <h3 class="font-semibold text-gray-800 mb-4 text-lg">Modifier votre profil</h3>
                                <div class="space-y-4">
                                    <!-- Photo de profil -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Photo de profil</label>
                                        <input type="file" wire:model="tempPhoto" accept="image/*"
                                               class="w-full px-4 py-3 border border-amber-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                        @error('tempPhoto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        @if($tempPhoto)
                                            <p class="mt-2 text-sm text-green-600">Nouvelle photo sélectionnée</p>
                                        @endif
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Spécialité *</label>
                                        <input type="text" wire:model="specialite"
                                               class="w-full px-4 py-3 border border-amber-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                        @error('specialite') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Années d'expérience *</label>
                                        <input type="number" wire:model="years_of_experience" min="0" max="50"
                                               class="w-40 px-4 py-3 border border-amber-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                        @error('years_of_experience') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    
                                </div>
                                <div class="flex justify-end space-x-3 mt-6">
                                    <button wire:click="cancelEditing"
                                            class="px-5 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium">
                                        Annuler
                                    </button>
                                    <button wire:click="saveProfile"
                                            class="px-5 py-2 bg-gradient-to-r from-amber-500 to-yellow-500 text-white rounded-lg hover:from-amber-600 hover:to-yellow-600 font-medium shadow">
                                        Enregistrer
                                    </button>
                                </div>
                            </div>
                        @else
                            <!-- À propos / Bio -->
                            @if(isset($bio) && $bio)
                                <div class="mb-8">
                                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                        <span class="mr-2">📋</span> À propos de moi
                                    </h3>
                                    <p class="text-gray-700 leading-relaxed">{{ $bio }}</p>
                                </div>
                            @endif

                            <!-- Informations de contact -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-gradient-to-r from-amber-50 to-yellow-50 p-4 rounded-xl">
                                    <h4 class="text-sm font-medium text-amber-800 mb-2">📱 Contact</h4>
                                    <p class="text-gray-900 font-semibold">{{ $user->telephone ?? 'Non renseigné' }}</p>
                                    <p class="text-gray-600 text-sm mt-1">{{ $user->email ?? '' }}</p>
                                </div>
                                
                                <div class="bg-gradient-to-r from-amber-50 to-yellow-50 p-4 rounded-xl">
                                    <h4 class="text-sm font-medium text-amber-800 mb-2">📍 Localisation</h4>
                                    <p class="text-gray-900 font-semibold">
                                        @if($localisation)
                                            {{ $localisation->adresse ?? 'Adresse non définie' }}
                                        @else
                                            Adresse non définie
                                        @endif
                                    </p>
                                    <p class="text-gray-600 text-sm mt-1">
                                        @if($localisation)
                                            {{ $localisation->ville ?? '' }}
                                        @else
                                            Ville non définie
                                        @endif
                                    </p>
                                </div>
                                
                                <div class="bg-gradient-to-r from-amber-50 to-yellow-50 p-4 rounded-xl">
                                    <h4 class="text-sm font-medium text-amber-800 mb-2">Nombres des services Pet keeping</h4>
                                    <p class="text-2xl font-bold text-amber-700">{{ $stats['nombres_services_pet_keeping'] ?? 0 }}</p>
                                </div>
                                
                                <div class="bg-gradient-to-r from-amber-50 to-yellow-50 p-4 rounded-xl">
                                    <h4 class="text-sm font-medium text-amber-800 mb-2">📅 Expérience</h4>
                                    <p class="text-gray-900 font-semibold">{{ $years_of_experience ?? 0 }} ans</p>
                                    <p class="text-gray-600 text-sm mt-1">avec les animaux</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Certifications -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-amber-200">
                    <div class="bg-gradient-to-r from-amber-100 to-yellow-100 p-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                                <span class="mr-2">🏅</span> Certifications & Documents
                            </h3>
                            <button wire:click="startEditing('certifications')"
                                    class="px-4 py-2 bg-gradient-to-r from-amber-500 to-yellow-500 text-white rounded-lg hover:from-amber-600 hover:to-yellow-600 shadow font-semibold">
                                + Ajouter
                            </button>
                        </div>
                    </div>

                    <div class="p-6">
                        @if($isEditing && $editingSection === 'certifications')
                            <div class="mb-6 p-4 bg-gradient-to-r from-amber-50 to-yellow-50 rounded-xl border border-amber-200">
                                <h4 class="font-semibold text-gray-800 mb-4">➕ Ajouter une certification</h4>
                                
                                <div class="space-y-4">
                                    @foreach($certificationList as $index => $cert)
                                        <div class="p-4 bg-white rounded-xl border border-amber-200 shadow-sm">
                                            <div class="flex justify-between items-start mb-3">
                                                <h5 class="font-medium text-gray-700">
                                                    Certification #{{ $index + 1 }}
                                                </h5>
                                                @if(count($certificationList) > 1)
                                                    <button wire:click="removeCertificationField({{ $index }})"
                                                            type="button"
                                                            class="text-red-500 hover:text-red-700 text-sm font-medium">
                                                        ✕ Supprimer cette ligne
                                                    </button>
                                                @endif
                                            </div>
                                            
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                                        Nom de la certification *
                                                    </label>
                                                    <input type="text" 
                                                           wire:model="certificationList.{{ $index }}.type"
                                                           placeholder="Ex: Diplôme vétérinaire, Certificat d'éducation canine..."
                                                           class="w-full px-4 py-3 border border-amber-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                                        Fichier (PDF, JPG, PNG) *
                                                    </label>
                                                    <div class="flex items-center space-x-3">
                                                        <input type="file" 
                                                               wire:model="certificationList.{{ $index }}.file"
                                                               accept=".pdf,.jpg,.jpeg,.png"
                                                               class="flex-1 px-4 py-3 border border-amber-300 rounded-lg">
                                                        
                                                        @if(isset($certificationList[$index]['file']) && $certificationList[$index]['file'])
                                                            <div class="flex items-center text-green-600">
                                                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                                <span class="text-sm font-medium">Fichier sélectionné</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    @if(isset($certificationList[$index]['file']) && $certificationList[$index]['file'])
                                                        <div class="mt-2 flex items-center text-xs text-gray-500">
                                                            <span>📄 {{ $certificationList[$index]['file']->getClientOriginalName() }}</span>
                                                            <span class="mx-2">•</span>
                                                            <span>📏 {{ round($certificationList[$index]['file']->getSize() / 1024, 2) }} KB</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="mt-6 pt-6 border-t border-amber-200">
                                    <div class="flex justify-between items-center">
                                        <button wire:click="addCertificationField"
                                                type="button"
                                                class="px-4 py-2 text-amber-600 hover:text-amber-800 font-medium flex items-center hover:bg-amber-50 rounded-lg">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            Ajouter une autre certification
                                        </button>
                                        
                                        <div class="space-x-3">
                                            <button wire:click="cancelEditing"
                                                    type="button"
                                                    class="px-5 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium">
                                                Annuler
                                            </button>
                                            <button wire:click="uploadCertification"
                                                    type="button"
                                                    wire:loading.attr="disabled"
                                                    class="px-5 py-2 bg-gradient-to-r from-amber-500 to-yellow-500 text-white rounded-lg hover:from-amber-600 hover:to-yellow-600 shadow font-medium
                                                           disabled:opacity-50 disabled:cursor-not-allowed flex items-center">
                                                <span wire:loading.remove>💾 Enregistrer</span>
                                                <span wire:loading class="flex items-center">
                                                    <svg class="animate-spin h-5 w-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                    Enregistrement...
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Liste des certifications existantes -->
                        @if(isset($certifications) && $certifications->count() > 0)
                            <div class="space-y-4">
                                @foreach($certifications as $cert)
                                    <div class="flex justify-between items-center p-4 border border-amber-200 rounded-xl hover:bg-amber-50 transition">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-10 h-10 bg-gradient-to-r from-amber-400 to-yellow-500 rounded-lg flex items-center justify-center text-white">
                                                📄
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900">{{ $cert->certification }}</h4>
                                                <p class="text-sm text-gray-500">
                                                    Ajoutée le {{ $cert->created_at->format('d/m/Y') }}
                                                </p>
                                                @if($cert->document)
                                                    <p class="text-xs text-blue-500 mt-1">
                                                        📎 Document joint
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            @if($cert->document)
                                                <button wire:click="downloadCertification({{ $cert->idCertification ?? $cert->id }})"
                                                        class="px-3 py-1 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 text-sm font-medium flex items-center transition">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    Télécharger
                                                </button>
                                            @endif
                                            <button wire:click="deleteCertification({{ $cert->idCertification ?? $cert->id }})"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette certification ?')"
                                                    class="px-3 py-1 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 text-sm font-medium flex items-center transition">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Supprimer
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="text-5xl mb-4">📄</div>
                                <p class="text-gray-500">Aucune certification ajoutée</p>
                                <p class="text-sm text-gray-400 mt-2">
                                    Ajoutez vos certifications pour renforcer votre profil et gagner la confiance des clients
                                </p>
                                <button wire:click="startEditing('certifications')"
                                        class="mt-4 px-4 py-2 bg-gradient-to-r from-amber-500 to-yellow-500 text-white rounded-lg hover:from-amber-600 hover:to-yellow-600 shadow font-semibold">
                                    + Ajouter ma première certification
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Avis clients -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-amber-200">
                    <div class="bg-gradient-to-r from-amber-100 to-yellow-100 p-6">
                        <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                            <span class="mr-2">⭐</span> Avis clients
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        @if(isset($reviews) && $reviews->count() > 0)
                            <div class="space-y-6">
                                @foreach($reviews as $review)
                                    <div class="border border-amber-200 rounded-xl p-5 hover:shadow-md transition">
                                        <div class="flex justify-between mb-3">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 bg-gradient-to-r from-amber-400 to-yellow-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-3">
                                                    {{ substr($review->auteur->prenom ?? 'A', 0, 1) }}
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">{{ $review->auteur->prenom ?? 'Client' }}</h4>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $review->created_at->format('d M Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex text-amber-500 text-xl">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= ($review->note ?? 0))
                                                        ★
                                                    @else
                                                        ☆
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-gray-700 leading-relaxed">{{ $review->commentaire ?? '' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="text-5xl mb-4">💬</div>
                                <p class="text-gray-500">Aucun avis pour le moment</p>
                                <p class="text-sm text-gray-400 mt-2">Les avis de vos clients apparaîtront ici</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Colonne droite : Disponibilités & Stats -->
            <div class="space-y-8">
                <!-- Disponibilités -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-amber-200">
                    <div class="bg-gradient-to-r from-amber-100 to-yellow-100 p-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                                <span class="mr-2">📅</span> Mes disponibilités
                            </h3>
                            <button wire:click="startEditing('availability')"
                                    class="px-4 py-2 bg-gradient-to-r from-amber-500 to-yellow-500 text-white rounded-lg hover:from-amber-600 hover:to-yellow-600 shadow font-semibold">
                                ✏️ Modifier
                            </button>
                        </div>
                    </div>

                    <div class="p-6">
                        @if($isEditing && $editingSection === 'availability')
                            <div class="mb-6 p-4 bg-gradient-to-r from-amber-50 to-yellow-50 rounded-xl border border-amber-200">
                                <h4 class="font-semibold text-gray-800 mb-4">🗓️ Gérer mes disponibilités</h4>
                                <div class="space-y-4">
                                    @foreach($days as $day)
                                        <div class="border border-amber-200 rounded-xl p-4">
                                            <div class="flex justify-between items-center mb-3">
                                                <span class="font-semibold text-gray-800">{{ $day }}</span>
                                                <button wire:click="addAvailabilitySlot('{{ $day }}')"
                                                        class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg hover:bg-amber-200 text-sm font-medium">
                                                    + Ajouter
                                                </button>
                                            </div>
                                            
                                            @if(isset($availabilities[$day]) && count($availabilities[$day]) > 0)
                                                <div class="space-y-3">
                                                    @foreach($availabilities[$day] as $index => $slot)
                                                        <div class="flex items-center space-x-3">
                                                            <input type="time" 
                                                                   wire:model="availabilities.{{ $day }}.{{ $index }}.heureDebut"
                                                                   class="px-3 py-2 border border-amber-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500">
                                                            <span class="text-gray-500">à</span>
                                                            <input type="time" 
                                                                   wire:model="availabilities.{{ $day }}.{{ $index }}.heureFin"
                                                                   class="px-3 py-2 border border-amber-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500">
                                                            <button wire:click="removeAvailabilitySlot('{{ $day }}', {{ $index }})"
                                                                    class="px-3 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200">
                                                                ✕
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-sm text-gray-500 italic text-center py-2">Non disponible</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <div class="flex justify-end space-x-3 mt-6">
                                    <button wire:click="cancelEditing"
                                            class="px-5 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                                        Annuler
                                    </button>
                                    <button wire:click="saveAvailability"
                                            class="px-5 py-2 bg-gradient-to-r from-amber-500 to-yellow-500 text-white rounded-lg hover:from-amber-600 hover:to-yellow-600 shadow">
                                        Enregistrer
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($days as $day)
                                    <div class="flex justify-between items-center p-4 border border-amber-200 rounded-xl hover:bg-amber-50 transition">
                                        <span class="font-semibold text-gray-800">{{ $day }}</span>
                                        <div class="flex flex-wrap gap-2">
                                            @if(isset($availabilities[$day]) && count($availabilities[$day]) > 0)
                                                @foreach($availabilities[$day] as $slot)
                                                    <span class="px-3 py-1 bg-gradient-to-r from-amber-400 to-yellow-500 text-white rounded-full text-sm font-medium shadow">
                                                        {{ $slot['heureDebut'] ?? '' }} - {{ $slot['heureFin'] ?? '' }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">
                                                    Indisponible
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Statistiques détaillées -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-amber-200">
                    <div class="bg-gradient-to-r from-amber-100 to-yellow-100 p-6">
                        <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                            <span class="mr-2">📈</span> Statistiques détaillées
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-700">Taux de réponse</span>
                                    <span class="font-bold text-amber-700">{{ $stats['response_rate'] ?? 100 }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-amber-400 to-yellow-500 h-3 rounded-full" 
                                         style="width: {{ min($stats['response_rate'] ?? 100, 100) }}%"></div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center p-4 bg-gradient-to-br from-amber-50 to-yellow-50 rounded-xl">
                                    <div class="text-3xl font-bold text-amber-700">{{ $stats['ongoing_missions'] ?? 0 }}</div>
                                    <div class="text-sm text-gray-600 mt-1">En cours</div>
                                </div>
                                <div class="text-center p-4 bg-gradient-to-br from-amber-50 to-yellow-50 rounded-xl">
                                    <div class="text-3xl font-bold text-amber-700">{{ $stats['pending_requests'] ?? 0 }}</div>
                                    <div class="text-sm text-gray-600 mt-1">En attente</div>
                                </div>
                            </div>
                            
                            <div class="p-4 bg-gradient-to-br from-amber-100 to-yellow-100 rounded-xl">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <div class="text-2xl font-bold text-gray-900">{{ $stats['repeat_clients'] ?? 0 }}</div>
                                        <div class="text-sm text-gray-600">Clients fidèles</div>
                                    </div>
                                    <div class="text-3xl">👥</div>
                                </div>
                            </div>
                            
                            <div class="p-4 bg-gradient-to-br from-amber-50 to-yellow-50 rounded-xl">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-amber-700">
                                        @php
                                            $missions = max($stats['completed_missions'] ?? 1, 1);
                                            $earnings = $stats['total_earnings'] ?? 0;
                                            $monthly = $earnings / $missions * 4;
                                        @endphp
                                        {{ number_format($monthly, 0, ',', ' ') }} DH
                                    </div>
                                    <div class="text-sm text-gray-600 mt-1">Revenu mensuel moyen</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-amber-200">
                    <div class="bg-gradient-to-r from-amber-100 to-yellow-100 p-6">
                        <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                            <span class="mr-2">🚀</span> Actions rapides
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-3">
                            <a href="/pet-keeper/dashboard"
                               class="flex items-center p-4 border border-amber-200 rounded-xl hover:bg-gradient-to-r hover:from-amber-50 hover:to-yellow-50 transition group">
                                <span class="mr-3 text-2xl">📊</span>
                                <div>
                                    <div class="font-semibold text-gray-900">Tableau de bord</div>
                                    <div class="text-sm text-gray-500">Vue d'ensemble de vos activités</div>
                                </div>
                                <span class="ml-auto text-amber-500 opacity-0 group-hover:opacity-100">→</span>
                            </a>
                            
                            <a href="/pet-keeper/missions"
                               class="flex items-center p-4 border border-amber-200 rounded-xl hover:bg-gradient-to-r hover:from-amber-50 hover:to-yellow-50 transition group">
                                <span class="mr-3 text-2xl">📅</span>
                                <div>
                                    <div class="font-semibold text-gray-900">Mes missions</div>
                                    <div class="text-sm text-gray-500">Gérer vos missions en cours</div>
                                </div>
                                <span class="ml-auto text-amber-500 opacity-0 group-hover:opacity-100">→</span>
                            </a>
                            
                            <a href="/pet-keeper/calendar"
                               class="flex items-center p-4 border border-amber-200 rounded-xl hover:bg-gradient-to-r hover:from-amber-50 hover:to-yellow-50 transition group">
                                <span class="mr-3 text-2xl">🗓️</span>
                                <div>
                                    <div class="font-semibold text-gray-900">Calendrier</div>
                                    <div class="text-sm text-gray-500">Voir votre planning</div>
                                </div>
                                <span class="ml-auto text-amber-500 opacity-0 group-hover:opacity-100">→</span>
                            </a>
                            
                            <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="flex items-center w-full p-4 border border-red-200 rounded-xl hover:bg-red-50 transition group">
                                <span class="mr-3 text-2xl">🚪</span>
                                <div class="font-semibold text-red-600">Déconnexion</div>
                                <span class="ml-auto text-red-500 opacity-0 group-hover:opacity-100">→</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire de logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
</div>



@push('styles')
<style>
    @keyframes slide-in {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .animate-slide-in {
        animation: slide-in 0.3s ease-out;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-suppression des messages flash après 5 secondes
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            const messages = document.querySelectorAll('.fixed.top-4.right-4');
            messages.forEach(msg => {
                msg.style.opacity = '0';
                msg.style.transition = 'opacity 0.5s';
                setTimeout(() => msg.remove(), 500);
            });
        }, 5000);
    });
</script>
@endpush