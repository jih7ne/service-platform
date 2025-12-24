<div class="flex h-screen bg-[#F3F4F6] font-sans overflow-hidden">

    {{-- ========================================== --}}
    {{--              SIDEBAR (GAUCHE)              --}}
    {{-- ========================================== --}}
    <livewire:tutoring.components.professeur-sidebar :currentPage="'tutoring-mes-reclamations'" />

    {{-- ========================================== --}}
    {{--            CONTENU PRINCIPAL (DROITE)      --}}
    {{-- ========================================== --}}
    <main class="flex-1 overflow-y-auto p-8">
        
        <!-- Header -->
        <header class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-800 flex items-center gap-2">
                         Mes réclamations
                    </h1>
                    <p class="text-gray-500 mt-1">Consultez l'historique et le statut de vos réclamations</p>
                </div>
            </div>
        </header>

        <!-- KPIs (Stats) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            
            <!-- Total -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Total</p>
                <h3 class="text-3xl font-extrabold text-gray-800">{{ $totalReclamations }}</h3>
            </div>

            <!-- En attente -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-yellow-50 rounded-xl text-yellow-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">En attente</p>
                <h3 class="text-3xl font-extrabold text-gray-800">{{ $enAttente }}</h3>
            </div>

            <!-- Résolues -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-green-50 rounded-xl text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Résolues</p>
                <h3 class="text-3xl font-extrabold text-gray-800">{{ $resolues }}</h3>
            </div>
        </div>

        <!-- Filtres et recherche -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Recherche -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Rechercher</label>
                    <input 
                        type="text" 
                        wire:model.live="recherche"
                        placeholder="Sujet, description..."
                        class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                </div>

                <!-- Filtre Statut -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Statut</label>
                    <select 
                        wire:model.live="filtreStatut"
                        class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="tous">Tous les statuts</option>
                        <option value="en_attente">En attente</option>
                        <option value="resolu">Résolu</option>
                    </select>
                </div>

                <!-- Filtre Priorité -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Priorité</label>
                    <select 
                        wire:model.live="filtrePriorite"
                        class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="tous">Toutes les priorités</option>
                        <option value="faible">Faible</option>
                        <option value="normal">Moyenne</option>
                        <option value="urgent">Urgente</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Liste des réclamations -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @if($reclamations->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($reclamations as $reclamation)
                        <div class="p-6 hover:bg-gray-50 transition-colors">
                            <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                                <!-- Gauche : Infos réclamation -->
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <h3 class="font-bold text-gray-900 text-lg">{{ $reclamation->sujet }}</h3>
                                        
                                        <!-- Badge Statut -->
                                        @if($reclamation->statut === 'en_attente')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">En attente</span>
                                        @else
                                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Résolu</span>
                                        @endif

                                        <!-- Badge Priorité -->
@if($reclamation->priorite === 'urgente')
    <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">Urgente</span>
@elseif($reclamation->priorite === 'moyenne')
    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Moyenne</span>
@else
    <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-full">Faible</span>
@endif
                                    </div>

                                    <p class="text-gray-600 text-sm mb-3">{{ $reclamation->description }}</p>

                                    <div class="flex items-center gap-4 text-xs text-gray-400">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ \Carbon\Carbon::parse($reclamation->dateCreation)->format('d/m/Y H:i') }}
                                        </span>
                                       
                                    </div>
                                </div>
                            </div>

                            @if($reclamation->preuves)
                                <div class="mt-4 p-3 bg-gray-50 rounded-xl">
                                    <p class="text-xs font-bold text-gray-600 mb-1">Preuves attachées:</p>
                                    <p class="text-sm text-gray-700">{{ $reclamation->preuves }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="p-6 border-t border-gray-100">
                    {{ $reclamations->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium">Aucune réclamation trouvée</p>
                    <p class="text-sm text-gray-400 mt-1">
                        @if($recherche || $filtreStatut !== 'tous' || $filtrePriorite !== 'tous')
                            Essayez de modifier vos filtres de recherche
                        @else
                            Vous n'avez pas encore de réclamations
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </main>
</div>