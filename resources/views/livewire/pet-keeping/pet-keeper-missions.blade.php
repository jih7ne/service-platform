<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        
        <h1 class="text-2xl font-bold text-gray-900 mb-6 px-4">Mes Missions</h1>

        <!-- LISTE DES CARTE -->
        <div class="space-y-6 px-4 sm:px-0">
            
            <!-- Boucle sur toutes les missions (A venir + Terminées) -->
            @php
                // On fusionne les deux listes pour un affichage simple, ou on garde séparé si vous préférez.
                // Ici je garde séparé mais avec le même design simple.
                $toutes_missions = collect($missions_a_venir)->merge($missions_terminees);
            @endphp

            @if($missions_a_venir->count() > 0)
                @foreach($missions_a_venir as $mission)
                    <!-- CARTE SIMPLE STYLE PROFIL -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                        
                        <!-- Header : Avatar + Nom + Statut -->
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex gap-4">
                                <!-- Avatar avec Initiales -->
                                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-700 font-bold text-lg">
                                    {{ substr($mission->prenom_client, 0, 1) }}{{ substr($mission->nom_client, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900">{{ $mission->prenom_client }} {{ $mission->nom_client }}</h3>
                                    <div class="flex items-center text-gray-500 text-sm mt-0.5">
                                        <span>{{ $mission->lieu ?? 'Ville non précisée' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Statut -->
                            @if($mission->statut === 'en_attente')
                                <span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full uppercase">En attente</span>
                            @elseif($mission->statut === 'validée')
                                <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full uppercase">Validée</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 text-xs font-bold px-3 py-1 rounded-full uppercase">{{ $mission->statut }}</span>
                            @endif
                        </div>

                        <!-- Corps : Info Animal & Horaires (Gris clair comme votre maquette) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <!-- Bloc Animal -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">ANIMAL</p>
                                <p class="font-semibold text-gray-900">{{ $mission->nomAnimal ?? 'Non spécifié' }}</p>
                                <p class="text-sm text-gray-500">{{ $mission->race ?? 'Race inconnue' }}</p>
                            </div>

                            <!-- Bloc Horaires -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">HORAIRES</p>
                                <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($mission->dateSouhaitee)->format('d/m/Y') }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ substr($mission->heureDebut, 0, 5) }} - {{ substr($mission->heureFin, 0, 5) }}
                                </p>
                            </div>
                        </div>

                        <!-- Footer : Prix & Actions -->
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase">TOTAL ESTIMÉ</p>
                                <p class="text-2xl font-bold text-gray-900">300 <span class="text-sm text-amber-500 font-bold">DH</span></p>
                            </div>
                            
                            <div class="flex gap-3">
                                <!-- Bouton Consulter (Gros bouton orange comme demandé) -->
                                <a href="{{ route('petkeeper.mission.show', $mission->id_demande_reelle) }}" 
                                   class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-lg transition-colors">
                                   {{ $mission->statut === 'en_attente' ? 'Répondre' : 'Consulter' }}
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach
            @else
                <div class="text-center py-12 bg-white rounded-xl border border-gray-200 border-dashed">
                    <p class="text-gray-500">Aucune mission pour le moment.</p>
                </div>
            @endif

        </div>
    </div>
</div>