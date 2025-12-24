<div class="flex h-screen bg-[#F3F4F6] font-sans overflow-hidden">

    <livewire:tutoring.components.professeur-sidebar :currentPage="'tutoring-clients'" />

    {{-- CONTENU PRINCIPAL --}}
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 md:p-8">
        
        <!-- 1. HEADER STATS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white p-4 sm:p-6 rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3 sm:gap-4">
                <div class="p-2.5 sm:p-3 bg-blue-50 rounded-lg sm:rounded-xl text-blue-600 flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase tracking-wider">Total Clients</p>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-gray-800">{{ $this->stats['clients'] }}</h3>
                </div>
            </div>
            
            <div class="bg-white p-4 sm:p-6 rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3 sm:gap-4">
                <div class="p-2.5 sm:p-3 bg-pink-50 rounded-lg sm:rounded-xl text-pink-600 flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase tracking-wider">Cours donnés</p>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-gray-800">{{ $this->stats['cours'] }}</h3>
                </div>
            </div>
            
            <div class="bg-white p-4 sm:p-6 rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3 sm:gap-4">
                <div class="p-2.5 sm:p-3 bg-yellow-50 rounded-lg sm:rounded-xl text-yellow-600 flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase tracking-wider">Heures enseignées</p>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-gray-800">{{ $this->stats['heures'] }}h</h3>
                </div>
            </div>
            
            <div class="bg-white p-4 sm:p-6 rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3 sm:gap-4">
                <div class="p-2.5 sm:p-3 bg-green-50 rounded-lg sm:rounded-xl text-green-600 flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase tracking-wider">Total Revenus</p>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-green-600 truncate">{{ number_format($this->stats['revenus'], 0, ',', ' ') }} DH</h3>
                </div>
            </div>
        </div>

        <!-- 2. BARRE DE FILTRES ET RECHERCHE -->
        <div class="bg-white p-4 sm:p-5 rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 mb-6 sm:mb-8">
            <div class="flex flex-col gap-4">
                <h2 class="text-lg sm:text-xl font-extrabold text-gray-900">Mes clients</h2>
                
                <div class="flex flex-col sm:flex-row gap-3 w-full">
                    <!-- Filtres -->
                    <div class="flex bg-gray-100 p-1 rounded-lg sm:rounded-xl overflow-x-auto">
                        <button wire:click="setFilter('all')" class="px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-bold transition-all whitespace-nowrap {{ $filterStatus === 'all' ? 'bg-[#1E40AF] text-white shadow-sm' : 'text-gray-500 hover:text-gray-800' }}">
                            Tous
                        </button>
                        <button wire:click="setFilter('en_cours')" class="px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-bold transition-all whitespace-nowrap {{ $filterStatus === 'en_cours' ? 'bg-[#1E40AF] text-white shadow-sm' : 'text-gray-500 hover:text-gray-800' }}">
                            En cours
                        </button>
                        <button wire:click="setFilter('terminé')" class="px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-bold transition-all whitespace-nowrap {{ $filterStatus === 'terminé' ? 'bg-[#1E40AF] text-white shadow-sm' : 'text-gray-500 hover:text-gray-800' }}">
                            Terminés
                        </button>
                    </div>

                    <!-- Recherche -->
                    <div class="relative flex-1 sm:max-w-xs">
                        <input type="text" wire:model.live="search" placeholder="Rechercher un client..." class="pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-lg sm:rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. GRILLE DES CARTES CLIENTS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
            @forelse($this->clients as $client)
                <div class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all flex flex-col items-center text-center group">
                    
                    <!-- Avatar -->
                    <div class="relative mb-4">
                        @if($client['photo'])
                            <img src="{{ asset('storage/'.$client['photo']) }}" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover border-4 border-white shadow-md">
                        @else
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-blue-600 flex items-center justify-center text-white text-xl sm:text-2xl font-bold border-4 border-white shadow-md">
                                {{ substr($client['prenom'], 0, 1) }}
                            </div>
                        @endif
                        <!-- Status Badge -->
                        @if($client['statut'] === 'validée')
                            <div class="absolute bottom-0 right-0 px-1.5 sm:px-2 py-0.5 sm:py-1 bg-green-100 text-green-700 text-[9px] sm:text-[10px] font-bold rounded-full border-2 border-white">En cours</div>
                        @else
                            <div class="absolute bottom-0 right-0 px-1.5 sm:px-2 py-0.5 sm:py-1 bg-gray-100 text-gray-600 text-[9px] sm:text-[10px] font-bold rounded-full border-2 border-white">Terminé</div>
                        @endif
                    </div>

                    <!-- Infos -->
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 truncate w-full px-2">{{ $client['prenom'] }} {{ $client['nom'] }}</h3>
                    <p class="text-[10px] sm:text-xs text-gray-400 mb-4">Client depuis le {{ \Carbon\Carbon::parse($client['firstCourseDate'])->format('d M Y') }}</p>

                    <div class="w-full space-y-2 mb-5 sm:mb-6">
                        @forelse($client['courses'] as $course)
                            <div class="bg-gray-50 rounded-lg p-2.5 sm:p-3">
                                <p class="text-xs text-gray-600 mb-1">
                                    <span class="font-semibold text-gray-700">{{ $course['nom_matiere'] }}</span>
                                    @if($course['nom_niveau'])
                                        <span class="text-gray-500"> - {{ $course['nom_niveau'] }}</span>
                                    @endif
                                </p>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic">Pas de cours assigné</p>
                        @endforelse
                    </div>

                    <!-- Bouton Détails -->
                    <a href="{{ route('tutoring.client.details', $client['client_id']) }}" class="w-full py-2 sm:py-2.5 bg-[#1E40AF] text-white rounded-lg sm:rounded-xl font-bold text-xs sm:text-sm hover:bg-blue-800 transition-colors shadow-blue-100 shadow-lg">
                        Voir détails
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <p class="text-sm sm:text-base text-gray-500 font-medium">Aucun client trouvé.</p>
                </div>
            @endforelse
        </div>

    </main>
</div>