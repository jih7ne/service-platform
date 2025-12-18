<div class="flex h-screen bg-[#F3F4F6] font-sans overflow-hidden">

    <livewire:tutoring.components.professeur-sidebar :currentPage="'tutoring-disponibilites'" />

    {{-- CONTENU PRINCIPAL --}}
    <div class="flex-1 overflow-y-auto p-4 sm:p-6 md:p-8">
        
        <!-- Header Section -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900 leading-tight">Mes disponibilités</h1>
            <p class="text-sm sm:text-base text-gray-500 mt-1">Gérez efficacement votre emploi du temps</p>
        </div>

        <!-- Stats/Summary Bar -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 flex items-center justify-between group hover:border-blue-200 transition-all">
                <div>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider">Cette semaine</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-gray-900 mt-1">{{ $disponibilitesCount ?? 0 }} <span class="text-xs sm:text-sm font-normal text-gray-500">créneaux</span></p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 group-hover:bg-blue-100 transition-colors flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            
            <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 flex items-center justify-between group hover:border-blue-200 transition-all">
                <div>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider">Cumul heures</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-gray-900 mt-1">{{ $totalHeures ?? 0 }}h</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-50 rounded-xl flex items-center justify-center text-yellow-600 group-hover:bg-yellow-100 transition-colors flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 flex items-center justify-between group hover:border-blue-200 transition-all sm:col-span-2 md:col-span-1">
                <div>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider">Jours actifs</p>
                    <p class="text-xl sm:text-2xl font-extrabold text-gray-900 mt-1">{{ $joursDisponibles ?? 0 }}<span class="text-xs sm:text-sm font-normal text-gray-500">/7 jours</span></p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-50 rounded-xl flex items-center justify-center text-green-600 group-hover:bg-green-100 transition-colors flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:grid lg:grid-cols-12 gap-6 sm:gap-8">
            <!-- Colonne Gauche : Formulaire & Liste -->
            <div class="lg:col-span-4 flex flex-col gap-4 sm:gap-6">
                
                <!-- Formulaire Ajout Rapide -->
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center text-sm sm:text-base">
                        <span class="w-1 h-5 sm:h-6 bg-blue-600 rounded-full mr-2"></span>
                        {{ $editingId ? 'Modifier un créneau' : 'Ajout rapide' }}
                    </h3>
                    
                    <form wire:submit="saveDisponibilite" class="space-y-3 sm:space-y-4">
                        <!-- Type selection -->
                        <div class="flex p-1 bg-gray-50 rounded-lg">
                            <button type="button" wire:click="$set('estRecurrent', true)" 
                                class="flex-1 py-1.5 text-xs sm:text-sm font-medium rounded-md transition-all {{ $estRecurrent ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                                Récurrent
                            </button>
                            <button type="button" wire:click="$set('estRecurrent', false)" 
                                class="flex-1 py-1.5 text-xs sm:text-sm font-medium rounded-md transition-all {{ !$estRecurrent ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                                Ponctuel
                            </button>
                        </div>

                        @if($estRecurrent)
                            <div>
                                <label class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase">Jour</label>
                                <select wire:model="jourSemaine" class="mt-1 w-full rounded-lg sm:rounded-xl border-gray-200 text-xs sm:text-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 border-0 p-2.5 sm:p-3">
                                    @foreach($this->joursSemaine as $jour)
                                        <option value="{{ $jour }}">{{ $jour }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div>
                                <label class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase">Date</label>
                                <input type="date" wire:model="dateSpecifique" class="mt-1 w-full rounded-lg sm:rounded-xl border-gray-200 text-xs sm:text-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 border-0 p-2.5 sm:p-3">
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-2 sm:gap-3">
                            <div>
                                <label class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase">Début</label>
                                <input type="time" wire:model="heureDebut" class="mt-1 w-full rounded-lg sm:rounded-xl border-gray-200 text-xs sm:text-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 border-0 p-2.5 sm:p-3">
                            </div>
                            <div>
                                <label class="text-[10px] sm:text-xs font-bold text-gray-400 uppercase">Fin</label>
                                <input type="time" wire:model="heureFin" class="mt-1 w-full rounded-lg sm:rounded-xl border-gray-200 text-xs sm:text-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 border-0 p-2.5 sm:p-3">
                            </div>
                        </div>
                        
                        @error('heureFin') <span class="text-[10px] sm:text-xs text-red-500">{{ $message }}</span> @enderror
                        @error('dateSpecifique') <span class="text-[10px] sm:text-xs text-red-500">{{ $message }}</span> @enderror

                        <div class="flex gap-2 pt-2">
                            @if($editingId)
                                <button type="button" wire:click="resetForm" class="flex-1 px-3 sm:px-4 py-2 text-xs sm:text-sm font-bold text-gray-500 bg-gray-100 rounded-lg sm:rounded-xl hover:bg-gray-200">
                                    Annuler
                                </button>
                            @endif
                            <button type="submit" class="flex-1 px-3 sm:px-4 py-2 text-xs sm:text-sm font-bold text-white bg-[#1E40AF] rounded-lg sm:rounded-xl hover:bg-blue-800 shadow-md shadow-blue-100 transition-all">
                                {{ $editingId ? 'Mettre à jour' : 'Ajouter' }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Liste des créneaux -->
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 flex flex-col overflow-hidden max-h-[400px] lg:max-h-none lg:flex-1">
                    <div class="p-3 sm:p-4 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-bold text-gray-700 text-xs sm:text-sm">Vos créneaux configurés</h3>
                    </div>
                    <div class="overflow-y-auto p-2 space-y-2 flex-1">
                        @forelse($disponibilites as $dispo)
                            <div class="group flex items-center justify-between p-2.5 sm:p-3 rounded-lg sm:rounded-xl hover:bg-gray-50 border border-transparent hover:border-gray-100 transition-all cursor-pointer {{ $editingId == $dispo->idDispo ? 'bg-blue-50 border-blue-100' : '' }}">
                                <div class="flex items-center gap-2 sm:gap-3 min-w-0 flex-1">
                                    <div class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $dispo->est_reccurent ? 'bg-blue-400' : 'bg-green-400' }}"></div>
                                    <div class="min-w-0">
                                        <p class="text-xs sm:text-sm font-bold text-gray-900 truncate">
                                            {{ $dispo->est_reccurent ? $dispo->jourSemaine : \Carbon\Carbon::parse($dispo->date_specifique)->format('d M') }}
                                        </p>
                                        <p class="text-[10px] sm:text-xs text-gray-500">{{ substr($dispo->heureDebut, 0, 5) }} - {{ substr($dispo->heureFin, 0, 5) }}</p>
                                    </div>
                                </div>
                                <div class="flex opacity-0 group-hover:opacity-100 transition-opacity flex-shrink-0">
                                    <button wire:click="editDisponibilite({{ $dispo->idDispo }})" class="p-1 sm:p-1.5 text-gray-400 hover:text-blue-600 rounded-md hover:bg-blue-50">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button wire:click="deleteDisponibilite({{ $dispo->idDispo }})" class="p-1 sm:p-1.5 text-gray-400 hover:text-red-600 rounded-md hover:bg-red-50">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 sm:py-8 px-4">
                                <div class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gray-100 mb-3">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </div>
                                <p class="text-xs sm:text-sm text-gray-500">Aucune disponibilité.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Colonne Droite : Calendrier -->
            <div class="lg:col-span-8 flex flex-col">
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 flex flex-col">
                    
                    <!-- Toolbar -->
                    <div class="p-4 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                        <div class="flex bg-gray-100 p-1 rounded-lg sm:rounded-xl w-full sm:w-auto">
                            <button wire:click="setViewMode('weekly')" class="flex-1 sm:flex-initial px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-bold rounded-lg transition-all {{ $viewMode === 'weekly' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Semaine</button>
                            <button wire:click="setViewMode('calendar')" class="flex-1 sm:flex-initial px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-bold rounded-lg transition-all {{ $viewMode === 'calendar' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">Journée</button>
                        </div>
                        
                        <div class="flex items-center justify-between sm:justify-end gap-3 sm:gap-4 w-full sm:w-auto">
                            @if($viewMode === 'weekly')
                                <span class="text-xs sm:text-sm font-bold text-gray-900">
                                    {{ \Carbon\Carbon::parse($selectedWeek)->format('d M') }} - {{ \Carbon\Carbon::parse($selectedWeek)->endOfWeek()->format('d M') }}
                                </span>
                                <div class="flex gap-1">
                                    <button wire:click="previousWeek" class="p-1.5 sm:p-2 hover:bg-gray-100 rounded-lg text-gray-500"><svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                                    <button wire:click="nextWeek" class="p-1.5 sm:p-2 hover:bg-gray-100 rounded-lg text-gray-500"><svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                                </div>
                            @else
                                <span class="text-xs sm:text-sm font-bold text-gray-900">
                                    {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}
                                </span>
                                <div class="flex gap-1">
                                    <button wire:click="previousDay" class="p-1.5 sm:p-2 hover:bg-gray-100 rounded-lg text-gray-500"><svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                                    <button wire:click="nextDay" class="p-1.5 sm:p-2 hover:bg-gray-100 rounded-lg text-gray-500"><svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Grille Calendrier -->
                    <div class="overflow-auto p-3 sm:p-4 custom-scrollbar">
                        @if($viewMode === 'weekly')
                            <div class="grid grid-cols-7 gap-1.5 sm:gap-2 md:gap-3 min-w-[600px]">
                                @foreach($this->disponibilitesForWeek as $date => $dayData)
                                    <div class="flex flex-col rounded-xl sm:rounded-2xl border {{ $date == now()->format('Y-m-d') ? 'border-blue-200 bg-blue-50/50' : 'border-gray-100 bg-gray-50/30' }}">
                                        <div class="p-2 sm:p-3 text-center border-b {{ $date == now()->format('Y-m-d') ? 'border-blue-100' : 'border-gray-100' }}">
                                            <p class="text-[9px] sm:text-[10px] font-bold text-gray-400 uppercase mb-0.5 sm:mb-1">{{ substr($dayData['dayName'], 0, 3) }}.</p>
                                            <p class="text-base sm:text-lg md:text-xl font-extrabold {{ $date == now()->format('Y-m-d') ? 'text-blue-600' : 'text-gray-900' }}">{{ \Carbon\Carbon::parse($date)->format('d') }}</p>
                                        </div>
                                        <div class="flex-1 p-1.5 sm:p-2 space-y-1.5 sm:space-y-2 min-h-[120px]">
                                            @forelse($dayData['disponibilites'] as $dispo)
                                                <div class="bg-white p-1.5 sm:p-2 rounded-lg sm:rounded-xl border border-gray-100 shadow-sm text-center group hover:border-blue-200 transition-colors cursor-pointer" wire:click="editDisponibilite({{ $dispo->idDispo }})">
                                                    <p class="text-[10px] sm:text-xs font-bold text-blue-800">{{ substr($dispo->heureDebut, 0, 5) }}</p>
                                                    <div class="h-0.5 w-2 sm:w-3 bg-gray-100 mx-auto my-0.5 sm:my-1"></div>
                                                    <p class="text-[9px] sm:text-xs text-gray-400">{{ substr($dispo->heureFin, 0, 5) }}</p>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Vue Journée -->
                            <div class="max-w-3xl mx-auto space-y-3 sm:space-y-4 pt-2 sm:pt-4">
                                @forelse($this->disponibilitesForDate as $dispo)
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center p-3 sm:p-4 bg-white rounded-xl sm:rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow gap-3 sm:gap-0">
                                        <div class="w-full sm:w-20 text-center sm:text-left border-b sm:border-b-0 sm:border-r border-gray-100 pb-3 sm:pb-0 sm:pr-4">
                                            <span class="block text-lg sm:text-xl font-extrabold text-blue-900">{{ substr($dispo->heureDebut, 0, 2) }}h</span>
                                            <span class="text-xs font-bold text-gray-400">{{ substr($dispo->heureFin, 0, 2) }}h</span>
                                        </div>
                                        <div class="flex-1 sm:px-6">
                                            <div class="flex items-center gap-2 mb-1">
                                                @if($dispo->est_reccurent)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-bold uppercase bg-blue-100 text-blue-800">Récurrent</span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-bold uppercase bg-green-100 text-green-800">Spécifique</span>
                                                @endif
                                            </div>
                                            <p class="text-xs sm:text-sm font-medium text-gray-500">Disponible pour cours</p>
                                        </div>
                                        <div class="flex gap-2 w-full sm:w-auto">
                                            <button wire:click="editDisponibilite({{ $dispo->idDispo }})" class="flex-1 sm:flex-initial p-2 text-xs sm:text-sm text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">Modifier</button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-12 sm:py-20 bg-gray-50 rounded-2xl sm:rounded-3xl border border-dashed border-gray-200">
                                        <h3 class="text-base sm:text-lg font-bold text-gray-900">Aucun créneau</h3>
                                        <p class="text-sm sm:text-base text-gray-500">Vous n'avez pas ajouté de disponibilité pour ce jour.</p>
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