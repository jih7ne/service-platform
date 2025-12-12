<div class="min-h-screen bg-white">
    <livewire:shared.header />

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-[#E1EAF7] to-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Bouton Retour -->
            <div class="mb-6">
                <a href="{{ route('professors-list') }}" class="inline-flex items-center text-[#2B5AA8] hover:text-[#224A91] font-semibold transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour à la liste des professeurs
                </a>
            </div>

            <!-- Profil du professeur -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="flex items-start gap-6">
                    <!-- Photo -->
                    <div class="flex-shrink-0">
                        <img 
                            src="{{ $professeur->photo ? asset('storage/' . $professeur->photo) : asset('images/default-avatar.png') }}" 
                            alt="Photo de {{ $professeur->surnom ?? $professeur->prenom }}"
                            class="w-32 h-32 rounded-full object-cover border-4 border-gray-100 shadow-lg"
                        >
                    </div>

                    <!-- Informations principales -->
                    <div class="flex-grow">
                        <h1 class="text-3xl font-bold text-black mb-3">
                            {{ $professeur->surnom ?? ($professeur->prenom . ' ' . $professeur->nom) }}
                        </h1>

                        <!-- Note et avis -->
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex items-center gap-1">
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
                            <span class="text-xl font-bold text-black">{{ number_format($professeur->note, 1) }}/5</span>
                            <span class="text-gray-600">({{ $professeur->nbrAvis }} avis)</span>
                        </div>

                        <!-- Localisation -->
                        @if($professeur->ville)
                            <div class="flex items-center gap-2 text-gray-700 mb-4">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $professeur->ville }}, Maroc</span>
                            </div>
                        @endif

                        <!-- À propos -->
                        @if($professeur->biographie)
                            <div class="mt-4">
                                <h3 class="text-lg font-bold text-black mb-2">À propos</h3>
                                <p class="text-gray-700 leading-relaxed">{{ $professeur->biographie }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenu principal -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Colonne principale -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Matières enseignées -->
                    <div class="bg-white rounded-2xl shadow-sm p-8">
                        <h2 class="text-2xl font-bold text-black mb-6">Matières enseignées</h2>

                        @if($services->isNotEmpty())
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="border-b-2 border-gray-200">
                                            <th class="text-left py-3 px-4 font-bold text-gray-700">Matière</th>
                                            <th class="text-left py-3 px-4 font-bold text-gray-700">Niveau</th>
                                            <th class="text-left py-3 px-4 font-bold text-gray-700">Prix/heure</th>
                                            <th class="text-left py-3 px-4 font-bold text-gray-700">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($services as $matiere => $servicesMatiere)
                                            @foreach($servicesMatiere as $index => $service)
                                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                                    @if($index === 0)
                                                        <td class="py-4 px-4 font-semibold text-black" rowspan="{{ count($servicesMatiere) }}">
                                                            {{ $matiere }}
                                                        </td>
                                                    @endif
                                                    <td class="py-4 px-4">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                            {{ $service->nom_niveau }}
                                                        </span>
                                                    </td>
                                                    <td class="py-4 px-4">
                                                        <span class="text-lg font-bold text-[#2B5AA8]">{{ number_format($service->prix_par_heure, 0) }} DH</span>
                                                    </td>
                                                    <td class="py-4 px-4">
                                                        <button 
                                                            wire:click="reserverCours({{ $service->id_service }})"
                                                            class="bg-[#2B5AA8] text-white px-6 py-2 rounded-lg font-semibold hover:bg-[#224A91] transition-colors">
                                                            Réserver
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">Aucun service disponible</p>
                        @endif
                    </div>

                    <!-- Disponibilités hebdomadaires -->
                    <div class="bg-white rounded-2xl shadow-sm p-8">
                        <h2 class="text-2xl font-bold text-black mb-6">Disponibilités hebdomadaires</h2>

                        @if($disponibilites && count($disponibilites) > 0)
                            <div class="space-y-3">
                                @php
                                    $joursMapping = [
                                        'Lundi' => 'Lundi',
                                        'Mardi' => 'Mardi',
                                        'Mercredi' => 'Mercredi',
                                        'Jeudi' => 'Jeudi',
                                        'Vendredi' => 'Vendredi',
                                        'Samedi' => 'Samedi',
                                        'Dimanche' => 'Dimanche'
                                    ];
                                @endphp

                                @foreach($joursMapping as $jour)
                                    <div class="flex items-center border-b border-gray-100 py-3">
                                        <div class="w-32 font-semibold text-gray-700">{{ $jour }}</div>
                                        <div class="flex-grow">
                                            @if(isset($disponibilites[$jour]) && count($disponibilites[$jour]) > 0)
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($disponibilites[$jour] as $dispo)
                                                        <span class="inline-flex items-center gap-1 bg-[#E1EAF7] text-[#2B5AA8] px-3 py-1 rounded-lg text-sm font-medium">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            {{ substr($dispo->heureDebut, 0, 5) }} - {{ substr($dispo->heureFin, 0, 5) }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-sm">Non disponible</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-gray-500">Aucune disponibilité configurée pour le moment</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Colonne latérale -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Localisation -->
                    @if($localisation['latitude'] && $localisation['longitude'])
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                            <div class="p-4 bg-[#2B5AA8] text-white">
                                <h3 class="font-bold">Localisation</h3>
                            </div>
                            <div id="location-map" style="height: 300px; width: 100%;"></div>
                            <div class="p-4">
                                <p class="text-sm text-gray-700">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    <strong>{{ $localisation['ville'] }}, Maroc</strong>
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Avis et évaluations -->
                    <div class="bg-white rounded-2xl shadow-sm p-8">
                        <h2 class="text-2xl font-bold text-black mb-6">Avis</h2>

                        @if($stats['total_avis'] > 0)
                            <!-- Note globale -->
                            <div class="text-center mb-8 p-6 bg-gray-50 rounded-xl">
                                <div class="text-5xl font-bold text-[#2B5AA8] mb-2">{{ number_format($professeur->note, 1) }}</div>
                                <div class="flex items-center justify-center gap-1 mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($professeur->note))
                                            <svg class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <div class="text-gray-600">Basé sur {{ $stats['total_avis'] }} avis</div>
                            </div>

                            <!-- Liste des avis -->
                            <div class="space-y-6">
                                @foreach($feedbacks as $feedback)
                                    <div class="border-b border-gray-200 pb-6 last:border-0">
                                        <div class="flex items-start gap-4">
                                            <img 
                                                src="{{ $feedback->auteur_photo ? asset('storage/' . $feedback->auteur_photo) : asset('images/default-avatar.png') }}" 
                                                alt="{{ $feedback->auteur_prenom }}"
                                                class="w-12 h-12 rounded-full object-cover"
                                            >
                                            <div class="flex-grow">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h4 class="font-bold text-black">{{ $feedback->auteur_prenom }} {{ substr($feedback->auteur_nom, 0, 1) }}.</h4>
                                                    <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($feedback->dateCreation)->diffForHumans() }}</span>
                                                </div>
                                                
                                                <div class="flex items-center gap-1 mb-3">
                                                    @php
                                                        $noteMoyenne = ($feedback->credibilite + $feedback->sympathie + $feedback->ponctualite + $feedback->proprete + $feedback->qualiteTravail) / 5;
                                                    @endphp
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= floor($noteMoyenne))
                                                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                        @else
                                                            <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                        @endif
                                                    @endfor
                                                    <span class="text-sm font-bold text-gray-700 ml-1">{{ number_format($noteMoyenne, 1) }}/5</span>
                                                </div>
                                                
                                                <p class="text-gray-700 leading-relaxed">{{ $feedback->commentaire }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">Aucun avis pour le moment</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
              integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
              crossorigin=""/>
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
                crossorigin=""></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const lat = {{ $localisation['latitude'] }};
                const lng = {{ $localisation['longitude'] }};
                
                const map = L.map('location-map').setView([lat, lng], 13);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
                
                L.marker([lat, lng]).addTo(map)
                    .bindPopup('<strong>{{ $professeur->surnom ?? $professeur->prenom }}</strong>');
                
                setTimeout(() => map.invalidateSize(), 200);
            });
        </script>
    @endpush

    <livewire:shared.footer />
</div>