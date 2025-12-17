<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">



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
                        <span class="bg-amber-50 px-1.5 py-0.5 rounded text-[10px] tracking-wide">★ {{ $stats['note'] ?? 4.8 }}</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 flex items-center justify-between text-[11px] font-semibold text-gray-500 bg-gray-50 rounded-lg p-2 px-4">
                <span>{{ $stats['missions'] ?? 0 }} missions</span>
                <span class="text-green-600 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> En ligne
                </span>
            </div>
            
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
            <a href="/pet-keeper/dashboard" class="flex items-center gap-3 px-4 py-3.5 bg-amber-50 text-amber-800 font-bold rounded-xl transition-all shadow-sm border-l-4 border-amber-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Tableau de bord
            </a>
            
            <a href="/pet-keeper/missions"
 class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Mes Missions
            </a>

            <a href="/pet-keeper/profile" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Mon Profil
            </a>

            <a href="/pet-keeper/dashboard/services" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                Mes Services
            </a>
        </nav>

        <div class="p-6">
            <button class="flex items-center gap-3 text-gray-400 font-bold text-sm hover:text-red-500 transition-colors w-full px-4 py-2 hover:bg-red-50 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Déconnexion
            </button>
        </div>
    </aside>



        
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
                                
                                <!-- Bouton Feedback pour missions terminées -->
                                @if($mission->statut === 'terminée' || $mission->statut === 'completed')
                                    <a href="{{ route('feedback.pet-keeping', ['idService' => 3, 'demandeId' => $mission->id_demande_reelle, 'auteurId' => auth()->id(), 'cibleId' => $mission->id_client ?? 1, 'typeAuteur' => 'intervenant']) }}" 
                                       class="px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition-colors flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                        Avis
                                    </a>
                                @endif
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