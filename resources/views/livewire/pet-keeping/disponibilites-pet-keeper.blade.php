<div class="ml-10">
    <div class="min-h-screen bg-gray-50 flex">
        

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


            <a href="/pet-keeper/dashboard/clients" 
            class="flex items-center gap-3 px-4 py-3 text-gray-700 font-medium hover:text-yellow-600 rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 0a11 11 0 01-2.5 7.5"/>
                </svg>
                <span>Mes Clients</span>
            </a>

            <a href="/pet-keeper/dashboard/disponibilites" 
            class="flex items-center gap-3 px-4 py-3 text-gray-600 font-medium hover:text-yellow-600 rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>Disponibilités</span>
            </a>
        </nav>

        <div class="p-6">
            <button class="flex items-center gap-3 text-gray-400 font-bold text-sm hover:text-red-500 transition-colors w-full px-4 py-2 hover:bg-red-50 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Déconnexion
            </button>
        </div>
    </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-64 p-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 leading-tight">Mes disponibilités</h1>
                        <p class="text-gray-500 mt-1">Gérez efficacement votre emploi du temps</p>
                    </div>
                    
                    <!-- Profile Summary -->
                    <div class="hidden md:flex items-center gap-3 bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100">
                        @if($petKeeperPhoto)
                            <img src="{{ asset('storage/' . $petKeeperPhoto) }}" alt="{{ $petKeeperName }}"
                                class="w-8 h-8 rounded-full object-cover ring-2 ring-yellow-100">
                        @else
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 font-bold text-xs ring-2 ring-yellow-50">
                                {{ substr($petKeeperName, 0, 1) }}
                            </div>
                        @endif
                        <span class="text-sm font-medium text-gray-700">{{ $petKeeperName }}</span>
                    </div>
                </div>
            </div>

            <!-- Stats/Summary Bar -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center justify-between group hover:border-yellow-200 transition-all">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Cette semaine</p>
                        <p class="text-xl font-bold text-gray-900 mt-1">{{ $disponibilitesCount ?? 0 }} <span class="text-sm font-normal text-gray-500">créneaux</span></p>
                    </div>
                    <div class="w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center text-yellow-500 group-hover:bg-yellow-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center justify-between group hover:border-green-200 transition-all">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Cumul heures</p>
                        <p class="text-xl font-bold text-gray-900 mt-1">{{ $totalHeures ?? 0 }}h</p>
                    </div>
                    <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center text-green-500 group-hover:bg-green-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center justify-between group hover:border-blue-200 transition-all">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Jours actifs</p>
                        <p class="text-xl font-bold text-gray-900 mt-1">{{ $joursDisponibles ?? 0 }}<span class="text-sm font-normal text-gray-500">/7 jours</span></p>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-500 group-hover:bg-blue-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Rest of the template remains exactly the same... -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 h-[calc(100vh-280px)] min-h-[600px]">
                <!-- Left Column: Add Form & Recent List -->
                <div class="lg:col-span-4 flex flex-col gap-6 h-full">
                    
                    <!-- Quick Add Form -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                            <span class="w-1 h-6 bg-yellow-500 rounded-full mr-2"></span>
                            {{ $editingId ? 'Modifier un créneau' : 'Ajout rapide' }}
                        </h3>
                        
                        <form wire:submit="saveDisponibilite" class="space-y-4">
                            <!-- Type selection -->
                            <div class="flex p-1 bg-gray-50 rounded-lg">
                                <button type="button" wire:click="$set('estRecurrent', true)" 
                                    class="flex-1 py-1.5 text-sm font-medium rounded-md transition-all {{ $estRecurrent ? 'bg-white text-yellow-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                                    Récurrent
                                </button>
                                <button type="button" wire:click="$set('estRecurrent', false)" 
                                    class="flex-1 py-1.5 text-sm font-medium rounded-md transition-all {{ !$estRecurrent ? 'bg-white text-yellow-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                                    Ponctuel
                                </button>
                            </div>

                            @if($estRecurrent)
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Jour</label>
                                    <select wire:model="jourSemaine" class="mt-1 w-full rounded-lg border-gray-200 text-sm focus:border-yellow-500 focus:ring-yellow-500 bg-gray-50 border-0">
                                        @foreach($this->joursSemaine as $jour)
                                            <option value="{{ $jour }}">{{ $jour }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Date</label>
                                    <input type="date" wire:model="dateSpecifique" class="mt-1 w-full rounded-lg border-gray-200 text-sm focus:border-yellow-500 focus:ring-yellow-500 bg-gray-50 border-0">
                                </div>
                            @endif

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Début</label>
                                    <input type="time" wire:model="heureDebut" class="mt-1 w-full rounded-lg border-gray-200 text-sm focus:border-yellow-500 focus:ring-yellow-500 bg-gray-50 border-0">
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Fin</label>
                                    <input type="time" wire:model="heureFin" class="mt-1 w-full rounded-lg border-gray-200 text-sm focus:border-yellow-500 focus:ring-yellow-500 bg-gray-50 border-0">
                                </div>
                            </div>
                            
                            @error('heureFin') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            @error('dateSpecifique') <span class="text-xs text-red-500">{{ $message }}</span> @enderror

                            <div class="flex gap-2 pt-2">
                                @if($editingId)
                                    <button type="button" wire:click="resetForm" class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">
                                        Annuler
                                    </button>
                                @endif
                                <button type="submit" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 shadow-sm shadow-yellow-200">
                                    {{ $editingId ? 'Mettre à jour' : 'Ajouter' }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Compact List -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col flex-1 overflow-hidden">
                        <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="font-semibold text-gray-700 text-sm">Vos créneaux configurés</h3>
                        </div>
                        <div class="overflow-y-auto p-2 space-y-2 flex-1 custom-scrollbar">
                            @forelse($disponibilites as $dispo)
                                <div class="group flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 border border-transparent hover:border-gray-100 transition-all cursor-pointer {{ $editingId == $dispo->id ? 'bg-yellow-50 border-yellow-100' : '' }}">
                                    <div class="flex items-center gap-3">
                                        <div class="w-1.5 h-1.5 rounded-full {{ $dispo->est_reccurent ? 'bg-blue-400' : 'bg-green-400' }}"></div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $dispo->est_reccurent ? $dispo->jourSemaine : \Carbon\Carbon::parse($dispo->date_specifique)->format('d M') }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $dispo->heureDebut }} - {{ $dispo->heureFin }}</p>
                                        </div>
                                    </div>
                                    <div class="flex opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button wire:click="editDisponibilite({{ $dispo->idDispo }})" class="p-1.5 text-gray-400 hover:text-yellow-600 rounded-md hover:bg-yellow-50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </button>
                                        <button wire:click="deleteDisponibilite({{ $dispo->idDispo }})" class="p-1.5 text-gray-400 hover:text-red-600 rounded-md hover:bg-red-50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 px-4">
                                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 mb-3">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-500">Aucune disponibilité.</p>
                                    <p class="text-xs text-gray-400 mt-1">Utilisez le formulaire pour ajouter vos horaires.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Column: Main Calendar View -->
                <div class="lg:col-span-8 h-full flex flex-col">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full">
                        <!-- Toolbar -->
                        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                            <div class="flex bg-gray-100 p-1 rounded-lg">
                                <button wire:click="setViewMode('weekly')" class="px-4 py-1.5 text-sm font-medium rounded-md transition-all {{ $viewMode === 'weekly' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Semaine</button>
                                <button wire:click="setViewMode('calendar')" class="px-4 py-1.5 text-sm font-medium rounded-md transition-all {{ $viewMode === 'calendar' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Journée</button>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                @if($viewMode === 'weekly')
                                    <span class="text-sm font-semibold text-gray-900 ml-2">
                                        {{ \Carbon\Carbon::parse($selectedWeek)->format('d M') }} - {{ \Carbon\Carbon::parse($selectedWeek)->endOfWeek()->format('d M') }}
                                    </span>
                                    <div class="flex gap-1">
                                        <button wire:click="previousWeek" class="p-1.5 hover:bg-gray-100 rounded-full text-gray-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M15 19l-7-7 7-7"/>
                                            </svg>
                                        </button>
                                        <button wire:click="nextWeek" class="p-1.5 hover:bg-gray-100 rounded-full text-gray-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </button>
                                    </div>
                                @else
                                    <span class="text-sm font-semibold text-gray-900 ml-2">
                                        {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}
                                    </span>
                                    <div class="flex gap-1">
                                        <button wire:click="previousDay" class="p-1.5 hover:bg-gray-100 rounded-full text-gray-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M15 19l-7-7 7-7"/>
                                            </svg>
                                        </button>
                                        <button wire:click="nextDay" class="p-1.5 hover:bg-gray-100 rounded-full text-gray-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Content Area -->
                        <div class="flex-1 overflow-auto p-4 custom-scrollbar">
                            @if($viewMode === 'weekly')
                                <div class="grid grid-cols-7 gap-2 h-full min-h-[500px]">
                                    @foreach($this->disponibilitesForWeek as $date => $dayData)
                                        <div class="flex flex-col h-full rounded-xl border {{ $date == now()->format('Y-m-d') ? 'border-yellow-200 bg-yellow-50/30' : 'border-gray-100 bg-gray-50/30' }}">
                                            <div class="p-3 text-center border-b {{ $date == now()->format('Y-m-d') ? 'border-yellow-100' : 'border-gray-100' }}">
                                                <p class="text-xs font-semibold text-gray-400 uppercase">{{ substr($dayData['dayName'], 0, 3) }}.</p>
                                                <p class="text-lg font-bold {{ $date == now()->format('Y-m-d') ? 'text-yellow-600' : 'text-gray-900' }}">{{ \Carbon\Carbon::parse($date)->format('d') }}</p>
                                            </div>
                                            <div class="flex-1 p-2 space-y-2">
                                                @forelse($dayData['disponibilites'] as $dispo)
                                                    <div class="bg-white p-2 rounded-lg border border-gray-100 shadow-sm text-center group hover:border-yellow-200 transition-colors cursor-default">
                                                        <p class="text-xs font-bold text-gray-800">{{ $dispo->heureDebut }}</p>
                                                        <div class="h-px w-4 bg-gray-100 mx-auto my-1"></div>
                                                        <p class="text-xs text-gray-500">{{ $dispo->heureFin }}</p>
                                                    </div>
                                                @empty
                                                    <div class="text-center py-4">
                                                        <svg class="w-6 h-6 text-gray-300 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        <p class="text-xs text-gray-400">Libre</p>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <!-- Daily View -->
                                <div class="max-w-3xl mx-auto space-y-4 pt-4">
                                    @forelse($this->disponibilitesForDate as $dispo)
                                        <div class="flex items-center p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                                            <div class="w-16 text-center border-r border-gray-100 pr-4">
                                                <span class="block text-lg font-bold text-gray-900">{{ substr($dispo->heureDebut, 0, 2) }}H</span>
                                                <span class="text-xs text-gray-400">{{ substr($dispo->heureFin, 0, 2) }}H</span>
                                            </div>
                                            <div class="flex-1 px-4">
                                                <div class="flex items-center gap-2 mb-1">
                                                    @if($dispo->est_reccurent)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                            Récurrent
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                            Spécifique
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-sm text-gray-500">Disponible pour interventions</p>
                                            </div>
                                            <div class="flex gap-2">
                                                <button wire:click="editDisponibilite({{ $dispo->idDispo }})" class="px-3 py-1 text-sm font-medium text-yellow-600 hover:text-yellow-700 hover:bg-yellow-50 rounded-lg transition-colors border border-yellow-200">
                                                    Modifier
                                                </button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-20">
                                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900">Aucun créneau</h3>
                                            <p class="text-gray-500">Vous n'avez pas ajouté de disponibilité pour ce jour.</p>
                                        </div>
                                    @endforelse
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #d1d5db;
        }
    </style>
</div>