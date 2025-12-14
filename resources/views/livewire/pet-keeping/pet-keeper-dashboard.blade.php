<div class="min-h-screen bg-[#F8F9FA] font-sans text-gray-800 flex relative">

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
            <a href="#" class="flex items-center gap-3 px-4 py-3.5 bg-amber-50 text-amber-800 font-bold rounded-xl transition-all shadow-sm border-l-4 border-amber-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Tableau de bord
            </a>
            
            <a href="/petkeeper/missions" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Mes Missions
            </a>

            <a href="/petkeeper/profile" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
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
    <main class="flex-1 ml-72 p-10 bg-[#F8F9FA] z-10">
        
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

        <!-- Header -->
        <div class="flex justify-between items-end mb-10">
            <div>
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
            <!-- Missions -->
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

            <!-- Note Moyenne -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-amber-100/50 hover:-translate-y-1 transition-all duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </div>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Note Moyenne</p>
                <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['note'] ?? 4.8 }}</h3>
            </div>

            <!-- En Attente -->
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

            <!-- Revenu -->
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
            
            <!-- COLONNE GAUCHE (Demandes Urgentes) - 2/3 -->
            <div class="col-span-2 space-y-6">
                
                <div class="flex justify-between items-center bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 shadow-inner">🔥</div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Demandes urgentes</h2>
                            <p class="text-xs text-gray-500 font-medium mt-0.5">Répondez rapidement pour maximiser vos revenus</p>
                        </div>
                    </div>
                </div>

                @forelse($demandesUrgentes as $demande)
                <div class="bg-white rounded-3xl p-7 border border-amber-100 relative shadow-lg shadow-amber-50/50 hover:shadow-xl transition-all duration-300">
                    
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-4">
                            <!-- INITIALES -->
                            <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-700 font-bold text-xl flex items-center justify-center border-2 border-white shadow-md">
                                {{ substr($demande->prenom_client, 0, 1) }}{{ substr($demande->nom_client, 0, 1) }}
                            </div>
                            <div>
                                <!-- NOM VIA JOINTURE -->
                                <h3 class="text-lg font-bold text-gray-900">{{ $demande->prenom_client }} {{ $demande->nom_client }}</h3>
                                <div class="flex items-center gap-3 text-sm text-gray-500 font-medium mt-1">
                                    <span class="flex items-center gap-1 text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md text-xs font-bold">
                                        ★ {{ $demande->note_client ?? '4.9' }}
                                    </span>
                                    <span class="text-gray-300">•</span>
                                    <span class="flex items-center gap-1">
                                        {{ $demande->ville_client ?? 'Marrakech' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-end gap-2">
                             <span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full uppercase">
                                En attente
                            </span>
                        </div>
                    </div>

                    <div class="flex gap-4 mb-6">
                        <div class="flex-1 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-bold text-gray-900 uppercase tracking-wide">Animal</span>
                            </div>
                            <p class="text-sm text-gray-700 font-semibold">{{ $demande->nom_animal ?? 'Inconnu' }} <span class="text-gray-400 text-xs">({{ $demande->race_animal ?? 'Race inconnue' }})</span></p>
                        </div>
                        <div class="flex-1 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-bold text-gray-900 uppercase tracking-wide">Horaires</span>
                            </div>
                            <p class="text-sm text-gray-700 font-semibold">
                                {{ \Carbon\Carbon::parse($demande->dateSouhaitee)->format('d/m/Y') }} <br>
                                <span class="text-gray-500 font-normal">
                                    {{ \Carbon\Carbon::parse($demande->heureDebut)->format('H:i') }} - {{ \Carbon\Carbon::parse($demande->heureFin)->format('H:i') }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-between items-center border-t border-gray-100 pt-5">
                         <div>
                            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wider mb-1">Total estimé</p>
                            <!-- Prix factice pour l'affichage, ajuster selon ton controller -->
                            <span class="text-3xl font-black text-gray-900">300 <span class="text-sm text-amber-600 font-bold">DH</span></span>
                        </div>

                        <!-- BOUTONS ACTIONS (CORRECTEMENT PLACÉS ICI) -->
                        <div class="flex gap-3">
                            <!-- 1. BOUTON CONSULTER -->
                            <a href="/petkeeper/mission/{{ $demande->id_demande_reelle }}" 
                               class="px-5 py-2.5 rounded-xl border-2 border-gray-100 text-gray-500 font-bold text-sm bg-white hover:bg-gray-50 hover:text-gray-700 transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Consulter
                            </a>

                            <!-- 2. BOUTON REFUSER -->
                            <button wire:click="openRefusalModal({{ $demande->id_demande_reelle }})" 
                                class="px-5 py-2.5 rounded-xl border-2 border-red-50 text-red-600 font-bold text-sm bg-white hover:bg-red-50 hover:border-red-100 transition-all">
                                Refuser
                            </button>
                            
                            <!-- 3. BOUTON ACCEPTER -->
                            <button wire:click="accepterDemande({{ $demande->id_demande_reelle }})" 
                                class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-600 to-amber-700 text-white font-bold text-sm shadow-lg shadow-amber-200 hover:shadow-amber-300 hover:scale-105 active:scale-95 transition-all flex items-center gap-2">
                                <span>Accepter</span>
                                <svg wire:loading.remove wire:target="accepterDemande({{ $demande->id_demande_reelle }})" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span wire:loading wire:target="accepterDemande({{ $demande->id_demande_reelle }})">...</span>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white p-12 rounded-3xl text-center border border-gray-100 flex flex-col items-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-3xl">📭</div>
                    <p class="text-gray-900 font-bold">Aucune demande urgente</p>
                    <p class="text-sm text-gray-500">Revenez plus tard !</p>
                </div>
                @endforelse
            </div>

            <!-- COLONNE DROITE (1/3) -->
            <div class="space-y-8">
                
                <!-- Missions à venir (Si présentes dans le controller, sinon vide) -->
                @if(count($missionsAVenir) > 0)
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                            <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                            Missions à venir
                        </h3>
                    </div>

                    <div class="space-y-2">
                        @foreach($missionsAVenir as $mission)
                        <div class="flex items-center p-3 hover:bg-amber-50 rounded-2xl transition-colors cursor-pointer group">
                            <div class="w-12 h-12 bg-gray-100 text-gray-500 rounded-xl flex items-center justify-center text-xl mr-4">🐶</div>
                            <div class="flex-1">
                                <h4 class="text-sm font-bold text-gray-900">{{ $mission->nom_client }} {{ $mission->prenom_client }}</h4>
                                <p class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($mission->dateSouhaitee)->format('d M') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="block text-sm font-extrabold text-amber-700 bg-amber-50 px-2 py-1 rounded-lg">300 DH</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Pro Tip Card -->
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-100 rounded-3xl p-6 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-amber-100 rounded-full opacity-50 blur-xl"></div>
                    <div class="flex items-start gap-4 relative z-10">
                        <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-amber-600 text-2xl shadow-sm flex-shrink-0">
                            💡
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Conseil Pro</h4>
                            <p class="text-xs text-gray-600 mt-2 leading-relaxed">
                                Répondre rapidement (moins de 2h) et justifier vos refus augmente votre visibilité sur Helpora.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- ================= MODAL DE REFUS (Style Ambre/PetKeeper) ================= -->
    @if($showRefusalModal)
    <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <!-- Fond sombre avec flou -->
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity backdrop-blur-sm" 
                 wire:click="closeRefusalModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Contenu du Modal -->
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-100 animate-slide-in">
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-8 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <!-- Icone Attention -->
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-50 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-xl leading-6 font-extrabold text-gray-900" id="modal-title">
                                Refuser la mission
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 mb-4 font-medium">
                                    Veuillez indiquer le motif de votre refus. Ce message sera transmis au client par email.
                                </p>
                                
                                <!-- Zone de texte pour le motif -->
                                <textarea wire:model="refusalReason" 
                                          rows="4" 
                                          maxlength="255"
                                          class="w-full px-4 py-3 text-gray-700 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200 resize-none transition-all placeholder-gray-400 text-sm"
                                          placeholder="Ex: Bonjour, je ne suis malheureusement pas disponible sur ce créneau horaire..."></textarea>
                                
                                <div class="flex justify-between mt-1">
                                    @error('refusalReason') 
                                        <span class="text-red-500 text-xs mt-2 block font-bold flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            {{ $message }}
                                        </span> 
                                    @else
                                        <span></span>
                                    @enderror
                                    <span class="text-xs text-gray-400" x-data x-text="$wire.refusalReason.length + '/255'"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons du Modal -->
                <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                    <button type="button" 
                            wire:click="confirmRefusal"
                            wire:loading.attr="disabled"
                            class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-lg shadow-red-200 px-5 py-2.5 bg-red-500 text-base font-bold text-white hover:bg-red-600 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed items-center transition-all">
                        
                        <span wire:loading.remove wire:target="confirmRefusal">Confirmer le refus</span>
                        <span wire:loading wire:target="confirmRefusal" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Traitement...
                        </span>
                    </button>
                    
                    <button type="button" 
                            wire:click="closeRefusalModal"
                            class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-200 shadow-sm px-5 py-2.5 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

<<<<<<< HEAD:resources/views/livewire/pet-keeping/pet-keeper-dashboard.blade.php
=======
<style>
    @keyframes slide-in {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .animate-slide-in { animation: slide-in 0.3s ease-out; }
    .animate-wave { animation: wave 2.5s infinite; transform-origin: 70% 70%; display: inline-block; }
    @keyframes wave { 0% { transform: rotate(0deg); } 10% { transform: rotate(14deg); } 20% { transform: rotate(-8deg); } 30% { transform: rotate(14deg); } 40% { transform: rotate(-4deg); } 50% { transform: rotate(10deg); } 60% { transform: rotate(0deg); } 100% { transform: rotate(0deg); } }
</style>
>>>>>>> 3c89cfd (New dashboard):resources/views/livewire/pet-keeper-dashboard.blade.php
