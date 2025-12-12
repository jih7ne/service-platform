<div class="min-h-screen bg-[#F8F9FA] font-sans text-gray-800 flex">

    <!-- SIDEBAR GAUCHE -->
    <aside class="w-72 bg-white h-screen fixed left-0 top-0 border-r border-gray-100 flex flex-col z-50 shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
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
                    <!-- CORRECTION : Utilisation de nom/prenom de la DB -->
                    <img class="w-full h-full rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ $user->prenom }}+{{ $user->nom }}&background=d97706&color=fff" alt="Avatar">
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
                <span>{{ $stats['missions'] }} missions</span>
                <span class="text-green-600 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> En ligne</span>
            </div>
        </div>

        <!-- Navigation (Design conservé) -->
        <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
            <a href="#" class="flex items-center gap-3 px-4 py-3.5 bg-amber-50 text-amber-800 font-bold rounded-xl transition-all shadow-sm border-l-4 border-amber-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Tableau de bord
            </a>
            <a href="#" class="flex items-center justify-between px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Demandes
                </div>
                <span class="bg-red-500 text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full shadow-md shadow-red-200">7</span>
            </a>
            <!-- Autres liens (simplifiés pour la longueur, mais tu peux remettre les tiens) -->
        </nav>

        <div class="p-6">
            <button class="flex items-center gap-3 text-gray-400 font-bold text-sm hover:text-red-500 transition-colors w-full px-4 py-2 hover:bg-red-50 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Déconnexion
            </button>
        </div>
    </aside>

    <!-- CONTENU PRINCIPAL -->
    <main class="flex-1 ml-72 p-10 bg-[#F8F9FA]">
        
        <!-- Alerts (Ajouté pour que tu vois les confirmations) -->
        @if(session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Header -->
        <div class="flex justify-between items-end mb-10">
            <div>
                <!-- CORRECTION NOM -->
                <h1 class="text-3xl font-extrabold text-gray-900 flex items-center gap-2">
                    Bonjour, {{ $user->prenom }} ! <span class="animate-wave text-4xl">👋</span>
                </h1>
                <p class="text-gray-500 mt-2 font-medium">Vous avez <span class="font-bold text-amber-700 underline decoration-amber-300 decoration-2 underline-offset-2">{{ $stats['attente'] ?? 0 }} nouvelles demandes</span> aujourd'hui</p>
            </div>
            
            <div class="flex items-center gap-4 bg-white p-2 pr-4 rounded-full shadow-sm border border-gray-100">
                <button wire:click="toggleAvailability" 
                    class="flex items-center gap-2 text-sm font-bold transition-all
                    {{ $isAvailable ? 'text-green-600' : 'text-red-500' }}">
                    <span class="w-2.5 h-2.5 rounded-full {{ $isAvailable ? 'bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.6)]' : 'bg-red-500' }}"></span>
                    {{ $isAvailable ? 'Disponible' : 'Indisponible' }}
                </button>
            </div>
        </div>

        <!-- KPI Stats -->
        <div class="grid grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-gray-200/50 hover:-translate-y-1 transition-all duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="text-[10px] font-bold text-green-700 bg-green-100 px-2.5 py-1 rounded-full">↗ +12%</span>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Missions</p>
                <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['missions'] ?? 0 }}</h3>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-amber-100/50 hover:-translate-y-1 transition-all duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </div>
                    <span class="text-[10px] font-bold text-green-700 bg-green-100 px-2.5 py-1 rounded-full">↗ +0.2</span>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Note Moyenne</p>
                <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['note'] ?? 4.8 }}</h3>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-blue-100/50 hover:-translate-y-1 transition-all duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <span class="text-[10px] font-bold text-green-700 bg-green-100 px-2.5 py-1 rounded-full">↗ +3</span>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">En Attente</p>
                <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['attente'] ?? 0 }}</h3>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-red-100/50 hover:-translate-y-1 transition-all duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-500">
                        <span class="text-xl font-black">$</span>
                    </div>
                    <span class="text-[10px] font-bold text-green-700 bg-green-100 px-2.5 py-1 rounded-full">↗ +8%</span>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Revenu (Mois)</p>
                <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['revenu'] ?? 0 }} <span class="text-base text-gray-500 font-bold">DH</span></h3>
            </div>
        </div>

        <!-- SECTION CENTRALE -->
        <div class="grid grid-cols-3 gap-8 mb-8">
            
            <!-- COLONNE GAUCHE (Demandes) -->
            <div class="col-span-2 space-y-6">
                
                <div class="flex justify-between items-center bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center text-red-500 shadow-inner">🔥</div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Demandes urgentes</h2>
                            <p class="text-xs text-gray-500 font-medium mt-0.5">Répondez rapidement pour maximiser vos revenus</p>
                        </div>
                    </div>
                </div>

                <!-- CORRECTION : PLUS DE PHP COMPLEXE ICI, ON UTILISE LES VARIABLES DU CONTROLLER -->
                @forelse($demandesUrgentes as $demande)
                <div class="bg-white rounded-3xl p-7 border border-amber-100 relative shadow-lg shadow-amber-50/50 hover:shadow-xl transition-all duration-300">
                    
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4">
                            <!-- INITIALES -->
                            <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-700 font-bold text-xl flex items-center justify-center border-2 border-white shadow-md">
                                {{ substr($demande->nom_client, 0, 1) }}{{ substr($demande->prenom_client, 0, 1) }}
                            </div>
                            <div>
                                <!-- NOM VIA JOINTURE -->
                                <h3 class="text-lg font-bold text-gray-900">{{ $demande->nom_client }} {{ $demande->prenom_client }}</h3>
                                <div class="flex items-center gap-3 text-sm text-gray-500 font-medium mt-1">
                                    <span class="flex items-center gap-1 text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md text-xs font-bold">
                                        ★ {{ $demande->note_client ?? 4.9 }}
                                    </span>
                                    <span class="text-gray-300">•</span>
                                    <span class="flex items-center gap-1">
                                        {{ $demande->lieu ?? 'Localisation inconnue' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-end gap-2">
                            <div class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold border border-red-100">
                                3h restantes
                            </div>
                            <div class="text-[10px] font-bold text-green-700 bg-green-50 px-3 py-1 rounded-lg border border-green-100">98% compatible</div>
                        </div>
                    </div>

                    <div class="flex gap-4 mb-6">
                        <div class="flex-1 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-bold text-gray-900 uppercase tracking-wide">Animal</span>
                            </div>
                            <p class="text-sm text-gray-700 font-semibold">Rex (Animal)</p>
                        </div>
                        <div class="flex-1 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-bold text-gray-900 uppercase tracking-wide">Horaires</span>
                            </div>
                            <p class="text-sm text-gray-700 font-semibold">
                                {{ \Carbon\Carbon::parse($demande->dateSouhaitee)->format('d M') }} 
                                <span class="text-gray-400 font-normal ml-1">
                                    {{ \Carbon\Carbon::parse($demande->heureDebut)->format('H:i') }} - {{ \Carbon\Carbon::parse($demande->heureFin)->format('H:i') }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-between items-center border-t border-gray-100 pt-5">
                        <div>
                            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider mb-1">Total estimé</p>
                            <span class="text-3xl font-black text-gray-900">{{ $demande->prixTotal ?? 0 }} <span class="text-sm text-amber-600 font-bold">DH</span></span>
                        </div>
                        <div class="flex gap-3">
                            <button class="px-5 py-3 rounded-xl border-2 border-gray-100 text-gray-600 font-bold text-sm bg-white">
                                Détails
                            </button>
                            <!-- BOUTON ACCEPTER FONCTIONNEL AVEC DB::TABLE -->
                            <button wire:click="accepterDemande({{ $demande->id_demande_reelle ?? $demande->id }})" 
                                class="px-8 py-3 rounded-xl bg-gradient-to-r from-amber-600 to-amber-700 text-white font-bold text-sm shadow-lg shadow-amber-200 hover:shadow-amber-300 hover:scale-105 active:scale-95 transition-all flex items-center gap-2">
                                <span>Accepter</span>
                                <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span wire:loading>...</span>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white p-12 rounded-3xl text-center border border-gray-100 flex flex-col items-center">
                    <p class="text-gray-900 font-bold">Aucune demande urgente</p>
                </div>
                @endforelse
            </div>

            <!-- COLONNE DROITE -->
            <div class="space-y-8">
                
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                            <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                            Missions à venir
                        </h3>
                    </div>

                    <div class="space-y-2">
                        @forelse($missionsAVenir as $mission)
                        <div class="flex items-center p-3 hover:bg-amber-50 rounded-2xl transition-colors cursor-pointer group">
                            <div class="w-12 h-12 bg-gray-100 text-gray-500 rounded-xl flex items-center justify-center text-xl mr-4">
                                🐶
                            </div>
                            <div class="flex-1">
                                <!-- NOM VIA JOINTURE -->
                                <h4 class="text-sm font-bold text-gray-900">{{ $mission->nom_client }} {{ $mission->prenom_client }}</h4>
                                <p class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($mission->dateSouhaitee)->format('d M') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="block text-sm font-extrabold text-amber-700 bg-amber-50 px-2 py-1 rounded-lg">{{ $mission->prixTotal ?? 0 }} DH</span>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-400 text-center py-6 italic">Aucune mission prévue.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-lg text-gray-900 flex items-center gap-2 mb-6">
                         <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                        Avis récents
                    </h3>
                    <div class="space-y-6 relative">
                        <div class="absolute left-[19px] top-4 bottom-4 w-0.5 bg-gray-100"></div>

                        @forelse($avisRecents as $avis)
                        <div class="relative pl-12">
                            <div class="absolute left-[15px] top-1.5 w-2.5 h-2.5 bg-amber-400 rounded-full border-2 border-white shadow-sm z-10"></div>
                            
                            <div class="flex justify-between items-start mb-1">
                                <h5 class="text-sm font-bold text-gray-900">Utilisateur</h5>
                                <div class="flex text-amber-400 text-[10px] gap-0.5">★★★★★</div>
                            </div>
                            <p class="text-xs text-gray-500 leading-relaxed italic bg-gray-50 p-3 rounded-tr-xl rounded-br-xl rounded-bl-xl mt-1">
                                "{{ Str::limit($avis->commentaire, 70) }}"
                            </p>
                        </div>
                        @empty
                        <p class="text-sm text-gray-400 text-center py-4 pl-0">Pas encore d'avis.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-100 rounded-3xl p-6 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-amber-100 rounded-full opacity-50 blur-xl"></div>
                    <div class="flex items-start gap-4 relative z-10">
                        <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-amber-600 text-2xl shadow-sm flex-shrink-0">
                            💡
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Le saviez-vous ?</h4>
                            <p class="text-xs text-gray-600 mt-2 leading-relaxed">
                                Répondre en moins de <span class="font-bold text-amber-700">2 heures</span> double vos chances d'obtenir la mission.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>
