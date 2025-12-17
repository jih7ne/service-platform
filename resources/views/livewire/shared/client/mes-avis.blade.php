<div>

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-pink-50 to-yellow-50 font-sans text-gray-800 flex relative">

    <!-- SIDEBAR GAUCHE -->
    <aside class="w-72 bg-white h-screen fixed left-0 top-0 border-r border-gray-100 flex flex-col z-40 shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
        <!-- Changed logo to simple text "Helpora" in blue -->
        <div class="p-8">
            <span class="text-2xl font-extrabold text-blue-600 tracking-tight">Helpora</span>
        </div>

        <div class="px-6 pb-6">
            <p class="text-xs font-bold text-gray-400 mb-4 uppercase tracking-wider pl-2">Espace Client</p>
            <!-- Carte Profil Miniature -->
            <div class="bg-gradient-to-br from-blue-50 via-pink-50 to-yellow-50 rounded-2xl p-3 flex items-center gap-3 border border-gray-100 shadow-sm group hover:border-pink-200 transition-colors cursor-pointer">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-pink-400 p-0.5 border-2 border-white shadow-sm overflow-hidden">
                    @if(isset($user->photo) && $user->photo)
                        <img src="{{ Storage::url($user->photo) }}" class="w-full h-full rounded-full object-cover">
                    @else
                        <img class="w-full h-full rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ $user->prenom }}+{{ $user->nom }}&background=ec4899&color=fff" alt="Avatar">
                    @endif
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-900 leading-tight group-hover:text-pink-700 transition-colors">
                        {{ $user->prenom }} {{ $user->nom }}
                    </h4>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <!-- Removed Dashboard button -->
        <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
            <a href="/services" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gradient-to-r hover:from-blue-50 hover:to-pink-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Services
            </a>

            <a href="/mes-avis" class="flex items-center gap-3 px-4 py-3.5 bg-gradient-to-r from-pink-50 via-yellow-50 to-blue-50 text-pink-800 font-bold rounded-xl transition-all shadow-sm border-l-4 border-pink-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                Mes Avis
            </a>

            <a href="/profil" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gradient-to-r hover:from-yellow-50 hover:to-pink-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-yellow-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Mon Profil
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
    <main class="flex-1 ml-72 p-10 bg-gradient-to-br from-blue-50 via-pink-50 to-yellow-50 z-10">
        
        <!-- Messages Flash -->
        @if(session()->has('success'))
            <div class="fixed top-6 right-6 z-50 animate-slide-in">
                <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-2xl shadow-lg flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session()->has('error'))
            <div class="fixed top-6 right-6 z-50 animate-slide-in">
                <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-2xl shadow-lg flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- En-tête de la page -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-2">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-100 to-yellow-100 flex items-center justify-center text-pink-500 shadow-inner text-2xl">
                    ⭐
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900">Mes Avis</h1>
                    <p class="text-sm text-gray-500 font-medium mt-1">Consultez les avis reçus et signalez les avis inappropriés</p>
                </div>
            </div>
        </div>

        <!-- Removed note_moyenne from statistics -->
        <!-- Statistiques -->
        <div class="grid grid-cols-3 gap-6 mb-8">
            <!-- Total Avis -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-blue-100 hover:shadow-xl hover:shadow-blue-200/50 hover:-translate-y-1 transition-all duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    </div>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Avis</p>
                <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['total_avis'] }}</h3>
            </div>

            <!-- Avis Positifs -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-pink-100 hover:shadow-xl hover:shadow-pink-200/50 hover:-translate-y-1 transition-all duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-pink-100 to-pink-200 flex items-center justify-center text-pink-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                    </div>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Avis Positifs</p>
                <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['avis_positifs'] }}</h3>
            </div>

            <!-- Avis Négatifs -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-yellow-100 hover:shadow-xl hover:shadow-yellow-200/50 hover:-translate-y-1 transition-all duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-yellow-100 to-yellow-200 flex items-center justify-center text-yellow-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"></path></svg>
                    </div>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Avis Négatifs</p>
                <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['avis_negatifs'] }}</h3>
            </div>
        </div>

        <!-- Added Filters Bar -->
        <!-- Filtres -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mb-6">
            <div class="flex items-center gap-3 mb-4">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                <h2 class="text-lg font-bold text-gray-900">Filtres</h2>
            </div>
            
            <div class="grid grid-cols-3 gap-4">
                <!-- Barre de recherche -->
                <div class="relative">
                    <input 
                        type="text" 
                        wire:model.live="searchTerm"
                        placeholder="Rechercher..."
                        class="w-full px-4 py-3 pl-10 text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all placeholder-gray-400 text-sm"
                    >
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <!-- Filtre par service -->
                <div>
                    <select 
                        wire:model.live="filterService"
                        class="w-full px-4 py-3 text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all text-sm appearance-none cursor-pointer"
                    >
                        <option value="">Tous les services</option>
                        @foreach($services as $service)
                            <option value="{{ $service }}">{{ $service }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtre par note -->
                <div>
                    <select 
                        wire:model.live="filterNote"
                        class="w-full px-4 py-3 text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition-all text-sm appearance-none cursor-pointer"
                    >
                        <option value="">Toutes les notes</option>
                        <option value="positive">Positifs (≥4)</option>
                        <option value="negative">Négatifs (<3)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Liste des avis -->
        <div class="space-y-6">
            @forelse($avis as $avis_item)
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-300">
                <div class="flex items-start gap-6">
                    <!-- Photo de l'auteur -->
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-400 to-pink-400 p-0.5 border-2 border-white shadow-md overflow-hidden">
                            @if($avis_item->auteur_photo)
                                <img src="{{ Storage::url($avis_item->auteur_photo) }}" class="w-full h-full rounded-full object-cover">
                            @else
                                <img class="w-full h-full rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ $avis_item->auteur_prenom }}+{{ $avis_item->auteur_nom }}&background=3b82f6&color=fff" alt="Avatar">
                            @endif
                        </div>
                    </div>

                    <!-- Contenu de l'avis -->
                    <div class="flex-1">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $avis_item->auteur_prenom }} {{ $avis_item->auteur_nom }}</h3>
                                <div class="flex items-center gap-3 mt-1">
                                    @if($avis_item->nom_service)
                                        <span class="text-xs bg-gradient-to-r from-blue-100 to-pink-100 text-blue-700 px-3 py-1 rounded-full font-bold">{{ $avis_item->nom_service }}</span>
                                    @endif
                                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($avis_item->dateCreation)->format('d M Y') }}</span>
                                </div>
                            </div>
                            
                            <!-- Note moyenne -->
                            <div class="flex items-center gap-2 bg-gradient-to-r from-yellow-100 to-yellow-200 px-4 py-2 rounded-xl">
                                <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <span class="text-lg font-extrabold text-yellow-700">{{ $avis_item->note_moyenne }}</span>
                            </div>
                        </div>

                        <!-- Critères détaillés -->
                        <div class="grid grid-cols-5 gap-4 mb-4 pb-4 border-b border-gray-100">
                            <div class="text-center">
                                <p class="text-xs text-gray-500 font-medium mb-1">Crédibilité</p>
                                <p class="text-sm font-bold text-gray-900">{{ $avis_item->credibilite }}/5</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs text-gray-500 font-medium mb-1">Sympathie</p>
                                <p class="text-sm font-bold text-gray-900">{{ $avis_item->sympathie }}/5</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs text-gray-500 font-medium mb-1">Ponctualité</p>
                                <p class="text-sm font-bold text-gray-900">{{ $avis_item->ponctualite }}/5</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs text-gray-500 font-medium mb-1">Propreté</p>
                                <p class="text-sm font-bold text-gray-900">{{ $avis_item->proprete }}/5</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs text-gray-500 font-medium mb-1">Qualité</p>
                                <p class="text-sm font-bold text-gray-900">{{ $avis_item->qualiteTravail }}/5</p>
                            </div>
                        </div>

                        <!-- Commentaire -->
                        @if($avis_item->commentaire)
                        <div class="bg-gradient-to-r from-blue-50 via-pink-50 to-yellow-50 p-4 rounded-xl mb-4">
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $avis_item->commentaire }}</p>
                        </div>
                        @endif

                        <!-- Bouton de réclamation -->
                        <div class="flex justify-end">
                            @if($avis_item->has_reclamation)
                                <span class="px-4 py-2 rounded-xl bg-gray-100 text-gray-500 font-bold text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Réclamation envoyée
                                </span>
                            @else
                                <button wire:click="openReclamationModal({{ $avis_item->idFeedBack }})" 
                                    class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-red-500 to-pink-500 text-white font-bold text-sm shadow-lg shadow-pink-200 hover:shadow-pink-300 hover:scale-105 active:scale-95 transition-all flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    Faire une réclamation
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white p-12 rounded-3xl text-center border border-gray-100 flex flex-col items-center">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-50 via-pink-50 to-yellow-50 rounded-full flex items-center justify-center mb-4 text-3xl">📭</div>
                <p class="text-gray-900 font-bold text-lg">Aucun avis trouvé</p>
                <p class="text-sm text-gray-500 mt-2">Aucun avis ne correspond à vos critères de recherche</p>
            </div>
            @endforelse
        </div>
    </main>

    <!-- ================= MODAL DE RÉCLAMATION ================= -->
    @if($showReclamationModal)
    <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Fond sombre avec flou -->
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" 
                 wire:click="closeReclamationModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Contenu du Modal -->
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border border-gray-100 animate-slide-in"
                 wire:click.stop>
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-8 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <!-- Icone Attention -->
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-br from-red-100 to-pink-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-xl leading-6 font-extrabold text-gray-900" id="modal-title">
                                Créer une réclamation
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 mb-4 font-medium">
                                    Si cet avis vous semble inapproprié ou faux, vous pouvez faire une réclamation avec des preuves.
                                </p>
                                
                                <!-- Sujet -->
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Sujet de la réclamation</label>
                                    <input type="text" 
                                           wire:model="sujet" 
                                           maxlength="255"
                                           class="w-full px-4 py-3 text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all placeholder-gray-400 text-sm"
                                           placeholder="Ex: Avis mensonger sur ma ponctualité">
                                    @error('sujet') 
                                        <span class="text-red-500 text-xs mt-1 block font-bold flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            {{ $message }}
                                        </span> 
                                    @enderror
                                </div>

                                <!-- Priorité -->
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Priorité</label>
                                    <select wire:model="priorite" 
                                            class="w-full px-4 py-3 text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm">
                                        <option value="faible">Faible</option>
                                        <option value="moyenne">Moyenne</option>
                                        <option value="urgente">Urgente</option>
                                    </select>
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Description détaillée</label>
                                    <textarea wire:model="description" 
                                              rows="4"
                                              class="w-full px-4 py-3 text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 resize-none transition-all placeholder-gray-400 text-sm"
                                              placeholder="Expliquez en détail pourquoi cet avis est inapproprié..."></textarea>
                                    @error('description') 
                                        <span class="text-red-500 text-xs mt-1 block font-bold flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            {{ $message }}
                                        </span> 
                                    @enderror
                                </div>

                                <!-- Upload de preuves -->
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Preuves (Photos, PDF)</label>
                                    <input type="file" 
                                           wire:model="preuves" 
                                           multiple
                                           accept=".jpg,.jpeg,.png,.pdf"
                                           class="w-full px-4 py-3 text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all text-sm">
                                    <p class="text-xs text-gray-500 mt-1">Formats acceptés: JPG, PNG, PDF (max 5Mo par fichier)</p>
                                    @error('preuves.*') 
                                        <span class="text-red-500 text-xs mt-1 block font-bold flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            {{ $message }}
                                        </span> 
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons du Modal -->
                <div class="bg-gradient-to-r from-blue-50 via-pink-50 to-yellow-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                    <button type="button" 
                            wire:click="createReclamation"
                            wire:loading.attr="disabled"
                            class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-lg shadow-pink-200 px-5 py-2.5 bg-gradient-to-r from-red-500 to-pink-500 text-base font-bold text-white hover:from-red-600 hover:to-pink-600 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed items-center transition-all">
                        
                        <span wire:loading.remove wire:target="createReclamation">Envoyer la réclamation</span>
                        <span wire:loading wire:target="createReclamation" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Envoi...
                        </span>
                    </button>
                    
                    <button type="button" 
                            wire:click="closeReclamationModal"
                            class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-200 shadow-sm px-5 py-2.5 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

<style>
    @keyframes slide-in {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-slide-in { animation: slide-in 0.3s ease-out; }
</style>

</div>

