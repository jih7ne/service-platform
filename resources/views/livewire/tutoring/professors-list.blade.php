<div class="min-h-screen bg-white">
    <livewire:shared.header />

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-[#E1EAF7] to-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-black mb-3">Soutien Scolaire</h1>
            <p class="text-lg text-gray-700 font-medium">Trouvez le professeur idéal pour vos besoins</p>
        </div>
    </section>

    <!-- Barre de recherche -->
    <section class="bg-white border-b shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="relative max-w-2xl">
                <input 
                    type="text" 
                    wire:model.live.debounce.500ms="searchTerm"
                    placeholder="Rechercher par nom, matière, niveau, prix ou note..."
                    class="w-full pl-12 pr-4 py-4 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2B5AA8] focus:border-[#2B5AA8] text-sm shadow-sm"
                >
                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </section>

    <!-- Filtres Section -->
    <section class="bg-gray-50 border-b sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-700">Filtrer par :</h3>
                
                <!-- Tri rapide -->
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-600">Trier par :</span>
                    <button 
                        wire:click="sortByField('note')"
                        class="px-3 py-1.5 text-xs rounded-lg font-semibold transition-all {{ $sortBy === 'note' ? 'bg-[#2B5AA8] text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                        Note {{ $sortBy === 'note' ? ($sortDirection === 'desc' ? '↓' : '↑') : '' }}
                    </button>
                    <button 
                        wire:click="sortByField('prix')"
                        class="px-3 py-1.5 text-xs rounded-lg font-semibold transition-all {{ $sortBy === 'prix' ? 'bg-[#2B5AA8] text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                        Prix {{ $sortBy === 'prix' ? ($sortDirection === 'desc' ? '↓' : '↑') : '' }}
                    </button>
                    <button 
                        wire:click="sortByField('nom')"
                        class="px-3 py-1.5 text-xs rounded-lg font-semibold transition-all {{ $sortBy === 'nom' ? 'bg-[#2B5AA8] text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                        Nom {{ $sortBy === 'nom' ? ($sortDirection === 'desc' ? '↓' : '↑') : '' }}
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <!-- Filtre Ville -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Ville</label>
                    <select wire:model.live="selectedVille" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2B5AA8] focus:border-[#2B5AA8] text-sm bg-white">
                        <option value="">Toutes les villes</option>
                        @foreach($villes as $ville)
                            <option value="{{ $ville }}">{{ $ville }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Filtre Note minimale -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Note minimale</label>
                    <select wire:model.live="selectedNote" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2B5AA8] focus:border-[#2B5AA8] text-sm bg-white">
                        <option value="">Toutes les notes</option>
                        <option value="4.5">⭐ 4.5+ Excellent</option>
                        <option value="4.0">⭐ 4.0+ Très bien</option>
                        <option value="3.5">⭐ 3.5+ Bien</option>
                        <option value="3.0">⭐ 3.0+ Correct</option>
                    </select>
                </div>
                
                <!-- Filtre Matière -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Matière</label>
                    <select wire:model.live="selectedMatiere" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2B5AA8] focus:border-[#2B5AA8] text-sm bg-white">
                        <option value="">Toutes les matières</option>
                        @foreach($matieres as $matiere)
                            <option value="{{ $matiere->id_matiere }}">{{ $matiere->nom_matiere }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Filtre Niveau -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Niveau</label>
                    <select wire:model.live="selectedNiveau" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2B5AA8] focus:border-[#2B5AA8] text-sm bg-white">
                        <option value="">Tous les niveaux</option>
                        @foreach($niveaux as $niveau)
                            <option value="{{ $niveau->id_niveau }}">{{ $niveau->nom_niveau }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Bouton reset si filtres actifs -->
            @if($searchTerm || $selectedVille || $selectedNote || $selectedMatiere || $selectedNiveau)
                <div class="mt-4 flex items-center justify-between">
                    <div class="flex flex-wrap gap-2">
                        @if($searchTerm)
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-[#2B5AA8] text-white text-xs rounded-full">
                                Recherche: "{{ Str::limit($searchTerm, 20) }}"
                            </span>
                        @endif
                        @if($selectedVille)
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-[#2B5AA8] text-white text-xs rounded-full">
                                Ville: {{ $selectedVille }}
                            </span>
                        @endif
                        @if($selectedNote)
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-[#2B5AA8] text-white text-xs rounded-full">
                                Note ≥ {{ $selectedNote }}
                            </span>
                        @endif
                        @if($selectedMatiere)
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-[#2B5AA8] text-white text-xs rounded-full">
                                {{ $matieres->firstWhere('id_matiere', $selectedMatiere)->nom_matiere }}
                            </span>
                        @endif
                        @if($selectedNiveau)
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-[#2B5AA8] text-white text-xs rounded-full">
                                {{ $niveaux->firstWhere('id_niveau', $selectedNiveau)->nom_niveau }}
                            </span>
                        @endif
                    </div>
                    <button 
                        wire:click="resetFilters"
                        class="text-sm text-[#2B5AA8] hover:text-[#224A91] font-bold flex items-center gap-1"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Tout effacer
                    </button>
                </div>
            @endif
        </div>
    </section>

    <!-- Compteur + Toggle Carte/Liste -->
    <section class="bg-gray-50 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <p class="text-gray-700 font-semibold">
                <span class="text-[#2B5AA8]">{{ $professeurs->total() }}</span> professeurs disponibles
            </p>
            
            <!-- Bouton Toggle Carte/Liste -->
            <button 
                wire:click="toggleMap"
                class="flex items-center gap-2 px-4 py-2 rounded-lg font-semibold transition-all {{ $showMap ? 'bg-[#2B5AA8] text-white' : 'bg-white text-[#2B5AA8] border border-[#2B5AA8]' }}"
            >
                @if($showMap)
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Voir la liste
                @else
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    Voir la carte
                @endif
            </button>
        </div>
    </section>

    <!-- Loading -->
    <div wire:loading class="text-center py-16">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-[#2B5AA8] border-t-transparent"></div>
        <p class="text-gray-600 mt-4 font-medium">Chargement...</p>
    </div>

    <!-- VUE CARTE -->
    @if($showMap)
        <section class="bg-gray-50 py-8" wire:loading.remove>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                    <!-- En-tête de la carte -->
                    <div class="bg-gradient-to-r from-[#2B5AA8] to-[#1e3a8a] px-6 py-4">
                        <div class="flex items-center justify-between text-white">
                            <div class="flex items-center gap-3">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                <h3 class="text-xl font-bold">Carte des Professeurs</h3>
                            </div>
                            <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg">
                                <div class="h-2 w-2 bg-green-400 rounded-full animate-pulse"></div>
                                <span class="text-sm font-semibold">{{ count($professeursMap) }} professeurs localisés</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Carte -->
                    <div wire:ignore id="map" style="height: 600px; width: 100%;"></div>
                    
                    <!-- Légende -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        <div class="flex items-center justify-center gap-6 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-gradient-to-br from-[#2B5AA8] to-[#1e3a8a] rounded-full border-2 border-white"></div>
                                <span>Professeur disponible</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-yellow-500">⭐</span>
                                <span>Note élevée (4.5+)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <!-- VUE LISTE -->
        <section class="bg-gray-50 py-8" wire:loading.remove>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($professeurs as $professeur)
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                            <div class="p-6">
                                <div class="text-center mb-5">
                                    <div class="relative inline-block mb-3">
                                        <img 
                                            src="{{ $professeur->photo ? asset('storage/' . $professeur->photo) : asset('images/default-avatar.png') }}" 
                                            alt="Photo de {{ $professeur->surnom ?? $professeur->prenom }}"
                                            class="w-24 h-24 rounded-full object-cover mx-auto border-4 border-gray-100"
                                        >
                                        @if($professeur->note >= 4.5)
                                            <div class="absolute -bottom-1 -right-1 bg-yellow-400 text-white text-xs font-bold px-2 py-1 rounded-full">
                                                ⭐ TOP
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <h3 class="font-bold text-xl text-black mb-1">
                                        {{ $professeur->surnom ?? ($professeur->prenom . ' ' . $professeur->nom) }}
                                    </h3>
                                    
                                    <div class="flex items-center justify-center gap-1 mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($professeur->note))
                                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    
                                    <p class="text-sm font-bold text-black">
                                        {{ number_format($professeur->note, 1) }}/5
                                        <span class="text-gray-500 font-normal">({{ $professeur->nbrAvis }} avis)</span>
                                    </p>

                                    @if($professeur->ville)
                                        <div class="flex items-center justify-center gap-1 mt-2 text-gray-600 text-sm">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $professeur->ville }}
                                        </div>
                                    @endif
                                </div>

                                @if($professeur->services->isNotEmpty())
                                    <div class="mb-4 flex flex-wrap gap-2 justify-center">
                                        @foreach($professeur->services->unique('matiere_id')->take(3) as $service)
                                            <span class="inline-block bg-[#E1EAF7] text-[#2B5AA8] px-3 py-1 rounded-full text-xs font-semibold">
                                                {{ $service->nom_matiere }}
                                            </span>
                                        @endforeach
                                        @if($professeur->services->unique('matiere_id')->count() > 3)
                                            <span class="inline-block bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">
                                                +{{ $professeur->services->unique('matiere_id')->count() - 3 }} autres
                                            </span>
                                        @endif
                                    </div>

                                    <div class="text-center mb-4">
                                        <p class="text-xs text-gray-500 mb-1">À partir de</p>
                                        <p class="text-3xl font-bold text-[#2B5AA8]">
                                            {{ number_format($professeur->min_prix, 0) }} DH
                                            <span class="text-base text-gray-500 font-normal">/h</span>
                                        </p>
                                    </div>
                                @endif
                                
                                <a href="{{ route('professeurs.details', $professeur->id_professeur) }}" class="block text-center bg-[#2B5AA8] text-white px-6 py-3 rounded-lg hover:bg-[#224A91] transition-all font-bold shadow-md">
                                    Réserver
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="bg-white rounded-2xl shadow-sm p-16 text-center">
                                <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Aucun professeur trouvé</h3>
                                <p class="text-gray-600 mb-4">Essayez de modifier vos critères de recherche</p>
                                @if($searchTerm || $selectedMatiere || $selectedNiveau || $selectedVille || $selectedNote)
                                    <button 
                                        wire:click="resetFilters"
                                        class="text-[#2B5AA8] hover:text-[#224A91] font-semibold"
                                    >
                                        Réinitialiser les filtres
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforelse
                </div>

                @if($professeurs->hasPages())
                    <div class="mt-12">
                        {{ $professeurs->links() }}
                    </div>
                @endif
            </div>
        </section>
    @endif

    <livewire:shared.footer />
</div>

<!-- Styles Leaflet (chargés toujours) -->
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
      crossorigin=""/>

<style>
    /* Styles pour les popups et marqueurs */
    .custom-popup .leaflet-popup-content-wrapper {
        border-radius: 16px;
        padding: 0;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    
    .custom-popup .leaflet-popup-content {
        margin: 0;
        width: auto !important;
    }
    
    .custom-popup .leaflet-popup-tip {
        background: white;
    }
    
    .custom-professor-marker {
        background: transparent !important;
        border: none !important;
    }
    
    /* Animation pour le chargement */
    #map {
        position: relative;
    }
    
    #map:empty::before {
        content: 'Chargement de la carte...';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #6b7280;
        font-size: 16px;
        font-weight: 500;
    }
</style>
@endpush

<!-- Scripts Leaflet (chargés toujours, mais n'exécutent que si nécessaire) -->
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

<script>
let mapInstance = null;
let markersLayer = null;

function destroyMap() {
    if (mapInstance) {
        console.log('🗑 Destruction de la carte');
        mapInstance.remove();
        mapInstance = null;
        markersLayer = null;
    }
}

function initializeMap(professors) {
    console.log('🗺 Initialisation carte avec', professors.length, 'professeurs');
    
    const mapElement = document.getElementById('map');
    if (!mapElement) {
        console.error('❌ Element #map introuvable');
        return;
    }

    if (typeof L === 'undefined') {
        console.error('❌ Leaflet non disponible');
        return;
    }

    if (professors.length === 0) {
        mapElement.innerHTML = '<div style="display: flex; align-items: center; justify-content: center; height: 600px; color: #666; font-size: 16px;">Aucun professeur avec coordonnées GPS disponibles</div>';
        return;
    }

    // Détruire l'ancienne carte si elle existe
    destroyMap();

    try {
        // Créer la carte
        mapInstance = L.map('map').setView(
            [professors[0].latitude, professors[0].longitude], 
            12
        );

        // Ajouter les tuiles OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(mapInstance);

        // Créer un groupe de marqueurs
        markersLayer = L.layerGroup().addTo(mapInstance);

        // Icône personnalisée pour les professeurs
        const professorIcon = L.divIcon({
            className: 'custom-professor-marker',
            html: `<div style="background: linear-gradient(135deg, #2B5AA8 0%, #1e3a8a 100%); 
                           width: 45px; height: 45px; border-radius: 50%; 
                           border: 4px solid white; 
                           display: flex; align-items: center; justify-content: center;
                           box-shadow: 0 4px 8px rgba(0,0,0,0.3);
                           cursor: pointer;
                           transition: transform 0.2s;">
                    <svg style="width: 22px; height: 22px; color: white;" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                    </svg>
                  </div>`,
            iconSize: [45, 45],
            iconAnchor: [22.5, 22.5]
        });

        // Ajouter les marqueurs pour chaque professeur
        professors.forEach((prof) => {
            const photoUrl = prof.photo ? `/storage/${prof.photo}` : '/images/default-avatar.png';
            
            // Créer les badges de matières
            const services = prof.services.slice(0, 3).map(s => 
                `<span style="background: #E1EAF7; color: #2B5AA8; padding: 4px 10px; border-radius: 12px; font-size: 11px; display: inline-block; margin: 3px; font-weight: 600;">${s.nom_matiere}</span>`
            ).join(' ');

            const moreServices = prof.services.length > 3 
                ? `<span style="background: #f3f4f6; color: #6b7280; padding: 4px 10px; border-radius: 12px; font-size: 11px; display: inline-block; margin: 3px; font-weight: 600;">+${prof.services.length - 3} autres</span>` 
                : '';

            // Créer les étoiles
            const stars = '⭐'.repeat(Math.floor(prof.note));
            
            // Contenu du popup
            const popupContent = `
                <div class="professor-popup" style="min-width: 280px; max-width: 320px; font-family: system-ui; padding: 8px;">
                    <div style="text-align: center; margin-bottom: 12px;">
                        <div style="position: relative; display: inline-block; margin-bottom: 10px;">
                            <img src="${photoUrl}" 
                                 style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 4px solid #E1EAF7;"
                                 onerror="this.src='/images/default-avatar.png'">
                            ${prof.note >= 4.5 ? '<div style="position: absolute; bottom: -5px; right: -5px; background: #fbbf24; color: white; font-size: 10px; font-weight: bold; padding: 4px 8px; border-radius: 12px; border: 2px solid white;">⭐ TOP</div>' : ''}
                        </div>
                        
                        <h3 style="font-weight: bold; font-size: 18px; margin: 8px 0; color: #111;">
                            ${prof.surnom || prof.prenom + ' ' + prof.nom}
                        </h3>
                        
                        <div style="margin: 8px 0;">
                            <span style="color: #fbbf24; font-size: 16px;">${stars}</span> 
                            <strong style="font-size: 15px;">${prof.note}/5</strong> 
                            <span style="color: #6b7280; font-size: 13px;">(${prof.nbrAvis} avis)</span>
                        </div>
                        
                        <div style="display: flex; align-items: center; justify-content: center; gap: 4px; margin: 8px 0; color: #6b7280; font-size: 14px;">
                            <svg style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            ${prof.ville}
                        </div>
                    </div>
                    
                    <div style="margin: 12px 0; padding: 12px; background: #f9fafb; border-radius: 10px;">
                        <div style="text-align: center; margin-bottom: 8px;">
                            <span style="font-size: 12px; color: #6b7280; text-transform: uppercase; font-weight: 600;">À partir de</span>
                        </div>
                        <div style="text-align: center;">
                            <span style="font-size: 32px; font-weight: bold; color: #2B5AA8;">${prof.min_prix}</span>
                            <span style="font-size: 16px; color: #6b7280; font-weight: 500;"> DH/h</span>
                        </div>
                    </div>
                    
                    <div style="margin: 12px 0;">
                        <div style="font-size: 12px; color: #6b7280; margin-bottom: 6px; font-weight: 600;">MATIÈRES ENSEIGNÉES</div>
                        <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                            ${services}
                            ${moreServices}
                        </div>
                    </div>
                    
                    <div style="margin-top: 15px;">
                        <a href="/professeurs/${prof.id_professeur}" 
                           style="display: block; background: linear-gradient(135deg, #2B5AA8 0%, #1e3a8a 100%); color: white; padding: 12px; 
                                  border-radius: 10px; text-decoration: none; font-weight: bold; text-align: center;
                                  box-shadow: 0 4px 6px rgba(43, 90, 168, 0.3); transition: all 0.3s;"
                           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(43, 90, 168, 0.4)';"
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(43, 90, 168, 0.3)';">
                            📚 Voir le profil complet
                        </a>
                    </div>
                </div>`;

            // Créer le marqueur
            const marker = L.marker([prof.latitude, prof.longitude], {
                icon: professorIcon
            }).addTo(markersLayer);

            // Ajouter le popup
            marker.bindPopup(popupContent, {
                maxWidth: 340,
                className: 'custom-popup'
            });

            // Effet hover sur le marqueur
            marker.on('mouseover', function(e) {
                this.getElement().querySelector('div').style.transform = 'scale(1.15)';
            });
            
            marker.on('mouseout', function(e) {
                this.getElement().querySelector('div').style.transform = 'scale(1)';
            });
        });

        // Ajuster la vue pour afficher tous les marqueurs
        if (professors.length > 1) {
            const bounds = L.latLngBounds(professors.map(p => [p.latitude, p.longitude]));
            mapInstance.fitBounds(bounds, { 
                padding: [60, 60],
                maxZoom: 15
            });
        }

        // Invalider la taille après un court délai
        setTimeout(() => {
            if (mapInstance) {
                mapInstance.invalidateSize();
                console.log('✅ Carte initialisée avec succès');
            }
        }, 250);

    } catch (error) {
        console.error('❌ Erreur lors de la création de la carte:', error);
    }
}

// Données des professeurs passées depuis le backend
const professeursData = @json($professeursMap);

// Écouter les changements du composant Livewire
document.addEventListener('livewire:init', () => {
    console.log('🎯 Livewire init - Configuration des listeners');
    
    // Écouter les mises à jour du composant
    Livewire.hook('morph.updated', ({ el, component }) => {
        console.log('🔄 Livewire morph.updated détecté');
        
        // Attendre que le DOM soit mis à jour
        setTimeout(() => {
            const mapElement = document.getElementById('map');
            if (mapElement && window.getComputedStyle(mapElement).display !== 'none') {
                console.log('✅ Carte visible après update, initialisation...');
                initializeMap(professeursData);
            } else if (mapElement) {
                console.log('⏹ Carte cachée après update, destruction...');
                destroyMap();
            }
        }, 100);
    });
});

// Vérifier l'état initial au chargement
document.addEventListener('DOMContentLoaded', function() {
    console.log('📦 DOM chargé, vérification état initial');
    
    setTimeout(() => {
        const mapElement = document.getElementById('map');
        if (mapElement && window.getComputedStyle(mapElement).display !== 'none') {
            console.log('🎯 Carte visible au chargement, initialisation...');
            initializeMap(professeursData);
        }
    }, 300);
});
</script>
@endpush