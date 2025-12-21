<div class="flex h-screen bg-[#F3F4F6] font-sans overflow-hidden">

    <livewire:tutoring.components.professeur-sidebar :currentPage="'tutoring-profile'" />
    
    {{-- CONTENU PRINCIPAL --}}
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 md:p-8 relative">
        
        <div class="mb-4 sm:mb-6">
            <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900">Mon Profil</h1>
            <p class="text-sm sm:text-base text-gray-500">Gérez vos informations personnelles et professionnelles</p>
        </div>

        <!-- 1. Carte Principale (En-tête) -->
        <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-5 md:p-6 shadow-sm border border-gray-100 mb-4 sm:mb-6 flex flex-col md:flex-row items-center gap-4 sm:gap-6">
            <div class="relative">
                @if($user->photo)
                    <img src="{{ asset('storage/'.$user->photo) }}" class="w-20 h-20 sm:w-24 sm:h-24 rounded-full object-cover border-4 border-[#EFF6FF]">
                @else
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-2xl sm:text-3xl border-4 border-[#EFF6FF]">
                        {{ substr($user->prenom, 0, 1) }}
                    </div>
                @endif
            </div>

            <div class="flex-1 text-center md:text-left">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $user->prenom }} {{ $user->nom }}</h2>
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 sm:gap-4 mt-2 text-xs sm:text-sm text-gray-500">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-400 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <span class="font-bold text-gray-800">{{ number_format($note, 1) }}</span>
                    </div>
                    <span class="hidden sm:inline">•</span>
                    <span>{{ $nbMissions }} Missions réalisées</span>
                </div>
            </div>

            <div class="text-center md:text-right w-full md:w-auto mt-3 md:mt-0">
                <p class="text-2xl sm:text-3xl font-extrabold text-[#1E40AF]">150 <span class="text-xs sm:text-sm font-medium text-gray-400">DH/heure</span></p>
                <p class="text-[10px] sm:text-xs text-gray-400 uppercase font-bold mt-1">Tarif Moyen</p>
            </div>
        </div>

        <!-- 2. Informations Personnelles (GRILLE INCLUSE) -->
        <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-5 md:p-6 shadow-sm border border-gray-100 mb-4 sm:mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4 sm:mb-6 border-b border-gray-50 pb-3 sm:pb-4">
                <h3 class="text-base sm:text-lg font-bold text-gray-900">Informations personnelles</h3>
                <button wire:click="openEditModal" class="w-full sm:w-auto bg-[#1E40AF] text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors">Modifier</button>
            </div>
            
            {{-- LA GRILLE EST BIEN ICI, DANS LA BOITE --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 sm:gap-y-6 gap-x-6 sm:gap-x-12">
                <div>
                    <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase mb-1">Email</p>
                    <p class="text-xs sm:text-sm font-semibold text-gray-800 break-all">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase mb-1">Téléphone</p>
                    <p class="text-xs sm:text-sm font-semibold text-gray-800">{{ $user->telephone }}</p>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase mb-1">Date de naissance</p>
                    <p class="text-xs sm:text-sm font-semibold text-gray-800">{{ \Carbon\Carbon::parse($user->dateNaissance)->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase mb-1">Niveau d'étude</p>
                    <p class="text-xs sm:text-sm font-semibold text-gray-800">{{ $professeur?->niveau_etudes ?? 'Niveau non renseigné' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase mb-1">Localisation</p>
                    <p class="text-xs sm:text-sm font-semibold text-gray-800 break-words">
                        {{ $localisation?->adresse ?? '' }} {{ $localisation?->ville ?? 'Non renseignée' }}
                    </p>
                </div>
            </div>
        </div> 

        {{-- === MODAL DE MODIFICATION === --}}
        @if($showEditModal)
            <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
                <div class="bg-white rounded-xl sm:rounded-2xl w-full max-w-lg p-5 sm:p-6 md:p-8 shadow-2xl transform transition-all scale-100 max-h-[90vh] overflow-y-auto">
                    
                    <div class="flex justify-between items-center mb-4 sm:mb-6">
                        <h3 class="text-lg sm:text-xl md:text-2xl font-extrabold text-gray-900">Modifier mon profil</h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-red-500 flex-shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Formulaire -->
                    <div class="space-y-4 sm:space-y-5">
                        
                        <!-- Téléphone -->
                        <div>
                            <label class="block text-[10px] sm:text-xs font-bold text-gray-500 uppercase mb-1">Téléphone</label>
                            <input type="text" wire:model="edit_telephone" class="w-full border border-gray-300 rounded-lg sm:rounded-xl p-2.5 sm:p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            @error('edit_telephone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Niveau d'étude -->
                        <div>
                            <label class="block text-[10px] sm:text-xs font-bold text-gray-500 uppercase mb-1">Niveau d'étude</label>
                            <select wire:model="edit_niveau" class="w-full border border-gray-300 rounded-lg sm:rounded-xl p-2.5 sm:p-3 text-sm bg-white outline-none">
                                <option value="">Choisir...</option>
                                @foreach($niveauxDispo as $niv)
                                    <option value="{{ $niv->nom_niveau }}">{{ $niv->nom_niveau }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <!-- Ville -->
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold text-gray-500 uppercase mb-1">Ville</label>
                                <input type="text" wire:model="edit_ville" class="w-full border border-gray-300 rounded-lg sm:rounded-xl p-2.5 sm:p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                @error('edit_ville') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <!-- Adresse -->
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold text-gray-500 uppercase mb-1">Quartier / Adresse</label>
                                <input type="text" wire:model="edit_adresse" class="w-full border border-gray-300 rounded-lg sm:rounded-xl p-2.5 sm:p-3 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                        </div>

                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-3 mt-6 sm:mt-8">
                        <button wire:click="closeModal" class="w-full sm:w-auto py-2.5 sm:py-3 px-4 sm:px-6 text-sm text-gray-500 font-bold hover:bg-gray-100 rounded-lg sm:rounded-xl transition-colors order-2 sm:order-1">Annuler</button>
                        <button wire:click="updateProfile" class="w-full sm:w-auto py-2.5 sm:py-3 px-6 sm:px-8 text-sm bg-[#1E40AF] text-white font-bold rounded-lg sm:rounded-xl hover:bg-blue-800 transition-colors shadow-lg shadow-blue-100 order-1 sm:order-2">Enregistrer</button>
                    </div>

                </div>
            </div>
        @endif

        {{-- Message de succès --}}
        @if (session()->has('success'))
            <div class="fixed bottom-4 right-4 bg-green-500 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg sm:rounded-xl shadow-lg font-bold text-xs sm:text-sm animate-bounce z-50">
                {{ session('success') }}
            </div>
        @endif

    </main>
</div>