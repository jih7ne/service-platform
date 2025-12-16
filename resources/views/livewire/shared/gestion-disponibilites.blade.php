<div class="max-w-7xl mx-auto p-6">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Gestion des disponibilités</h2>
        <p class="text-gray-600">Configurez vos heures de disponibilité pour les interventions</p>
    </div>

    <!-- View Mode Toggle -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex space-x-2">
                <button 
                    wire:click="setViewMode('weekly')"
                    class="px-4 py-2 rounded-lg font-medium transition-colors {{ $viewMode == 'weekly' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Vue hebdomadaire
                </button>
                <button 
                    wire:click="setViewMode('calendar')"
                    class="px-4 py-2 rounded-lg font-medium transition-colors {{ $viewMode == 'calendar' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Vue calendrier
                </button>
            </div>
            
            <button 
                wire:click="resetForm"
                class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors font-medium">
                <span class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Ajouter une disponibilité</span>
                </span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Section -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    {{ $editingId ? 'Modifier' : 'Ajouter' }} une disponibilité
                </h3>

                <form wire:submit="saveDisponibilite" class="space-y-4">
                    <!-- Type de disponibilité -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" wire:model="estRecurrent" value="1" class="mr-2">
                                <span class="text-sm">Récurrent</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" wire:model="estRecurrent" value="0" class="mr-2">
                                <span class="text-sm">Date spécifique</span>
                            </label>
                        </div>
                    </div>

                    <!-- Jour de la semaine (si récurrent) -->
                    @if($estRecurrent)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jour de la semaine</label>
                            <select wire:model="jourSemaine" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @foreach($this->joursSemaine as $jour)
                                    <option value="{{ $jour }}">{{ $jour }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <!-- Date spécifique -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                            <input type="date" wire:model="dateSpecifique" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('dateSpecifique')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    <!-- Heures -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Heure de début</label>
                            <select wire:model="heureDebut" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Sélectionner</option>
                                @foreach($this->heures as $heure)
                                    <option value="{{ $heure }}">{{ $heure }}</option>
                                @endforeach
                            </select>
                            @error('heureDebut')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Heure de fin</label>
                            <select wire:model="heureFin" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Sélectionner</option>
                                @foreach($this->heures as $heure)
                                    <option value="{{ $heure }}">{{ $heure }}</option>
                                @endforeach
                            </select>
                            @error('heureFin')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex space-x-3 pt-4">
                        <button type="submit" class="flex-1 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors font-medium">
                            {{ $editingId ? 'Mettre à jour' : 'Ajouter' }}
                        </button>
                        @if($editingId)
                            <button type="button" wire:click="resetForm" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                                Annuler
                            </button>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Disponibilités existantes -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Mes disponibilités</h3>
                
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse($disponibilites as $dispo)
                        <div class="border border-gray-200 rounded-lg p-3 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    @if($dispo->est_reccurent)
                                        <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full font-medium mb-1">Récurrent</span>
                                        <p class="text-sm font-medium text-gray-900">{{ $dispo->jourSemaine }}</p>
                                    @else
                                        <span class="inline-block px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium mb-1">Spécifique</span>
                                        <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($dispo->date_specifique)->format('d/m/Y') }}</p>
                                    @endif
                                    <p class="text-sm text-gray-600">{{ $dispo->heureDebut }} - {{ $dispo->heureFin }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <button wire:click="editDisponibilite({{ $dispo->idDispo }})" class="text-blue-500 hover:text-blue-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button wire:click="deleteDisponibilite({{ $dispo->idDispo }})" class="text-red-500 hover:text-red-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Aucune disponibilité configurée</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- View Section -->
        <div class="lg:col-span-2">
            @if($viewMode == 'weekly')
                <!-- Weekly View -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Vue hebdomadaire</h3>
                        <div class="flex items-center space-x-2">
                            <button wire:click="previousWeek" class="p-2 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <span class="text-sm font-medium text-gray-700">
                                {{ \Carbon\Carbon::parse($selectedWeek)->format('d M') }} - {{ \Carbon\Carbon::parse($selectedWeek)->endOfWeek()->format('d M Y') }}
                            </span>
                            <button wire:click="nextWeek" class="p-2 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-7 gap-4">
                        @foreach($this->disponibilitesForWeek as $date => $dayData)
                            <div class="text-center">
                                <div class="text-xs font-medium text-gray-500 mb-2">{{ substr($dayData['dayName'], 0, 3) }}</div>
                                <div class="text-sm font-medium text-gray-900 mb-2">{{ \Carbon\Carbon::parse($date)->format('d') }}</div>
                                <div class="space-y-1">
                                    @forelse($dayData['disponibilites'] as $dispo)
                                        <div class="bg-blue-50 text-blue-800 text-xs px-2 py-1 rounded">
                                            {{ $dispo->heureDebut }}
                                        </div>
                                    @empty
                                        <div class="text-gray-400 text-xs">-</div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- Calendar View -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Vue calendrier</h3>
                        <div class="flex items-center space-x-2">
                            <button wire:click="previousDay" class="p-2 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <span class="text-sm font-medium text-gray-700">
                                {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}
                            </span>
                            <button wire:click="nextDay" class="p-2 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @forelse($this->disponibilitesForDate as $dispo)
                            <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-blue-900">{{ $dispo->heureDebut }} - {{ $dispo->heureFin }}</p>
                                    @if($dispo->est_reccurent)
                                        <p class="text-sm text-blue-700">Récurrent - {{ $dispo->jourSemaine }}</p>
                                    @else
                                        <p class="text-sm text-blue-700">Date spécifique</p>
                                    @endif
                                </div>
                                <div class="flex space-x-2">
                                    <button wire:click="editDisponibilite({{ $dispo->idDispo }})" class="text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button wire:click="deleteDisponibilite({{ $dispo->idDispo }})" class="text-red-600 hover:text-red-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p>Aucune disponibilité pour cette date</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
