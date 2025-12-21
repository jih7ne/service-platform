@php
    $babysitterName = $babysitter?->utilisateur?->prenom . ' ' . $babysitter?->utilisateur?->nom ?? 'Babysitter';
    $babysitterPhoto = $babysitter?->utilisateur?->photo ?? null;
@endphp

<div>
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Include Sidebar -->
        @include('livewire.babysitter.babysitter-sidebar', ['babysitter' => $babysitter])

        <!-- Main Content -->
        <div class="flex-1 ml-64 p-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 leading-tight">Mes disponibilités</h1>
                        <p class="text-gray-500 mt-1">Gérez efficacement votre emploi du temps</p>
                    </div>
                    
                    <!-- Profile Summary (Optional, simplified) -->
                    <div class="hidden md:flex items-center gap-3 bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100">
                         @if($babysitterPhoto)
                            <img src="{{ asset('storage/' . $babysitterPhoto) }}" alt="{{ $babysitterName }}"
                                class="w-8 h-8 rounded-full object-cover ring-2 ring-pink-100">
                        @else
                            <div class="w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center text-pink-600 font-bold text-xs ring-2 ring-pink-50">
                                {{ substr($babysitterName, 0, 1) }}
                            </div>
                        @endif
                        <span class="text-sm font-medium text-gray-700">{{ $babysitterName }}</span>
                    </div>
                </div>
            </div>

            <!-- Stats/Summary Bar - Compact -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center justify-between group hover:border-pink-200 transition-all">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Cette semaine</p>
                        <p class="text-xl font-bold text-gray-900 mt-1">{{ $disponibilitesCount }} <span class="text-sm font-normal text-gray-500">créneaux</span></p>
                    </div>
                    <div class="w-10 h-10 bg-pink-50 rounded-lg flex items-center justify-center text-pink-500 group-hover:bg-pink-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center justify-between group hover:border-pink-200 transition-all">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Cumul heures</p>
                        <p class="text-xl font-bold text-gray-900 mt-1">{{ $totalHeures }}h</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center text-purple-500 group-hover:bg-purple-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex items-center justify-between group hover:border-pink-200 transition-all">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Jours actifs</p>
                        <p class="text-xl font-bold text-gray-900 mt-1">{{ $joursDisponibles }}<span class="text-sm font-normal text-gray-500">/7 jours</span></p>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-500 group-hover:bg-blue-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 h-[calc(100vh-280px)] min-h-[600px]">
                <!-- Left Column: Add Form & Recent List -->
                <div class="lg:col-span-4 flex flex-col gap-6 h-full">
                    
                    <!-- Quick Add Form -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                            <span class="w-1 h-6 bg-pink-500 rounded-full mr-2"></span>
                            {{ $editingId ? 'Modifier un créneau' : 'Ajout rapide' }}
                        </h3>
                        
                        <form wire:submit="saveDisponibilite" class="space-y-4">
                            <!-- Type selection -->
                            <div class="flex p-1 bg-gray-50 rounded-lg">
                                <button type="button" wire:click="$set('estRecurrent', true)" 
                                    class="flex-1 py-1.5 text-sm font-medium rounded-md transition-all {{ $estRecurrent ? 'bg-white text-pink-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                                    Récurrent
                                </button>
                                <button type="button" wire:click="$set('estRecurrent', false)" 
                                    class="flex-1 py-1.5 text-sm font-medium rounded-md transition-all {{ !$estRecurrent ? 'bg-white text-pink-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                                    Ponctuel
                                </button>
                            </div>

                            @if($estRecurrent)
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Jour</label>
                                    <select wire:model="jourSemaine" class="mt-1 w-full rounded-lg border-gray-200 text-sm focus:border-pink-500 focus:ring-pink-500 bg-gray-50 border-0">
                                        @foreach($this->joursSemaine as $jour)
                                            <option value="{{ $jour }}">{{ $jour }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Date</label>
                                    <input type="date" wire:model="dateSpecifique" class="mt-1 w-full rounded-lg border-gray-200 text-sm focus:border-pink-500 focus:ring-pink-500 bg-gray-50 border-0">
                                </div>
                            @endif

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Début</label>
                                    <select wire:model="heureDebut" class="mt-1 w-full rounded-lg border-gray-200 text-sm focus:border-pink-500 focus:ring-pink-500 bg-gray-50 border-0">
                                        <option value="">Sélectionner</option>
                                        @foreach($this->heures as $heure)
                                            <option value="{{ $heure }}">{{ $heure }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-gray-500 uppercase">Fin</label>
                                    <select wire:model="heureFin" class="mt-1 w-full rounded-lg border-gray-200 text-sm focus:border-pink-500 focus:ring-pink-500 bg-gray-50 border-0">
                                        <option value="">Sélectionner</option>
                                        @foreach($this->heures as $heure)
                                            <option value="{{ $heure }}">{{ $heure }}</option>
                                        @endforeach
                                    </select>
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
                                <button type="submit" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-pink-600 rounded-lg hover:bg-pink-700 shadow-sm shadow-pink-200">
                                    {{ $editingId ? 'Mettre à jour' : 'Ajouter' }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Compact List (Fill remaining height, scrollable) -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col flex-1 overflow-hidden">
                        <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="font-semibold text-gray-700 text-sm">Vos créneaux configurés</h3>
                        </div>
                        <div class="overflow-y-auto p-2 space-y-2 flex-1 custom-scrollbar">
                            @forelse($disponibilites as $dispo)
                                <div class="group flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 border border-transparent hover:border-gray-100 transition-all cursor-pointer {{ $editingId == $dispo->id ? 'bg-pink-50 border-pink-100' : '' }}">
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
                                        <button wire:click="editDisponibilite({{ $dispo->idDispo }})" class="p-1.5 text-gray-400 hover:text-pink-600 rounded-md hover:bg-pink-50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button wire:click="deleteDisponibilite({{ $dispo->idDispo }})" class="p-1.5 text-gray-400 hover:text-red-600 rounded-md hover:bg-red-50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 px-4">
                                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 mb-3">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
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
                                        <button wire:click="previousWeek" class="p-1.5 hover:bg-gray-100 rounded-full text-gray-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                                        <button wire:click="nextWeek" class="p-1.5 hover:bg-gray-100 rounded-full text-gray-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                                    </div>
                                @else
                                    <span class="text-sm font-semibold text-gray-900 ml-2">
                                        {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}
                                    </span>
                                    <div class="flex gap-1">
                                        <button wire:click="previousDay" class="p-1.5 hover:bg-gray-100 rounded-full text-gray-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                                        <button wire:click="nextDay" class="p-1.5 hover:bg-gray-100 rounded-full text-gray-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Content Area -->
                        <div class="flex-1 overflow-auto p-4 custom-scrollbar">
                            @if($viewMode === 'weekly')
                                <div class="grid grid-cols-7 gap-2 h-full min-h-[500px]">
                                    @foreach($this->disponibilitesForWeek as $date => $dayData)
                                        <div class="flex flex-col h-full rounded-xl border {{ $date == now()->format('Y-m-d') ? 'border-pink-200 bg-pink-50/30' : 'border-gray-100 bg-gray-50/30' }}">
                                            <div class="p-3 text-center border-b {{ $date == now()->format('Y-m-d') ? 'border-pink-100' : 'border-gray-100' }}">
                                                <p class="text-xs font-semibold text-gray-400 uppercase">{{ substr($dayData['dayName'], 0, 3) }}.</p>
                                                <p class="text-lg font-bold {{ $date == now()->format('Y-m-d') ? 'text-pink-600' : 'text-gray-900' }}">{{ \Carbon\Carbon::parse($date)->format('d') }}</p>
                                            </div>
                                            <div class="flex-1 p-2 space-y-2">
                                                @forelse($dayData['disponibilites'] as $dispo)
                                                    <div class="bg-white p-2 rounded-lg border border-gray-100 shadow-sm text-center group hover:border-pink-200 transition-colors cursor-default">
                                                        <p class="text-xs font-bold text-gray-800">{{ $dispo->heureDebut }}</p>
                                                        <div class="h-px w-4 bg-gray-100 mx-auto my-1"></div>
                                                        <p class="text-xs text-gray-500">{{ $dispo->heureFin }}</p>
                                                    </div>
                                                @empty
                                                    
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
                                                            Specifique
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-sm text-gray-500">Disponible pour gardes</p>
                                            </div>
                                            <div class="flex gap-2">
                                                <button wire:click="editDisponibilite({{ $dispo->idDispo }})" class="p-2 text-gray-400 hover:text-pink-600 hover:bg-pink-50 rounded-lg transition-colors">
                                                    Modifier
                                                </button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-20">
                                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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

