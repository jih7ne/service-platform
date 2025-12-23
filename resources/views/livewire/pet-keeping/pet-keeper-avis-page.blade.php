<div>
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
            
            <a href="/pet-keeper/missions" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Mes Missions
            </a>

            <a href="/pet-keeper/dashboard/feedbacks" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                Mes Avis
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

            <a href="/pet-keeper/dashboard/clients" class="flex items-center gap-3 px-4 py-3 text-gray-700 font-medium hover:text-yellow-600 rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 0a11 11 0 01-2.5 7.5"/>
                </svg>
                <span>Mes Clients</span>
            </a>

            <a href="/pet-keeper/dashboard/disponibilites" class="flex items-center gap-3 px-4 py-3 text-gray-600 font-medium hover:text-yellow-600 rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
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

    <!-- MAIN CONTENT - Shifted right for sidebar -->
    <main class="ml-72 p-8 min-h-screen bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Mes Avis</h1>
                <p class="text-gray-500 mt-2">Gérez les avis reçus et donnés</p>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-2xl p-6 mb-6 shadow-sm border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search"
                            placeholder="Nom ou commentaire..."
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-all"
                        >
                    </div>

                    <!-- Minimum Rating -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Note minimum</label>
                        <select 
                            wire:model.live="minRating"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-all"
                        >
                            <option value="">Toutes les notes</option>
                            <option value="5">★★★★★ (5+)</option>
                            <option value="4">★★★★☆ (4+)</option>
                            <option value="3">★★★☆☆ (3+)</option>
                            <option value="2">★★☆☆☆ (2+)</option>
                            <option value="1">★☆☆☆☆ (1+)</option>
                        </select>
                    </div>

                    <!-- Sort Direction -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Trier par date</label>
                        <select 
                            wire:model.live="sortDirection"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-all"
                        >
                            <option value="desc">Plus récent d'abord</option>
                            <option value="asc">Plus ancien d'abord</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Feedbacks Received -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                Avis reçus de mes clients
                            </h2>
                            <span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full">
                                {{ $feedBacksOnPetKeeper->total() }} avis
                            </span>
                        </div>
                        <p class="text-gray-500 text-sm mt-1">Ce que mes clients pensent de mes services</p>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @forelse($feedBacksOnPetKeeper as $feedback)
                            <div class="p-6 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start gap-4">
                                    <!-- Avatar -->
                                    <div class="flex-shrink-0">
                                        @if($feedback->photo)
                                            <img src="{{ Storage::url($feedback->photo) }}" 
                                                 class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-800 font-bold text-lg">
                                                {{ strtoupper(substr($feedback->prenom, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-bold text-gray-900">{{ $feedback->prenom }}</h4>
                                            <div class="flex items-center gap-2">
                                                <!-- Rating Stars -->
                                                <div class="flex text-amber-400">
                                                    @php
                                                        $averageRating = $feedback->note_moyenne;
                                                    @endphp
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= floor($averageRating))
                                                            <!-- Full star -->
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                        @elseif($i - 0.5 <= $averageRating && $averageRating < $i)
                                                            <!-- Half star -->
                                                            <div class="relative">
                                                                <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                </svg>
                                                                <div class="absolute top-0 left-0 overflow-hidden" style="width: 50%;">
                                                                    <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <!-- Empty star -->
                                                            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="text-sm font-bold text-amber-600">{{ number_format($averageRating, 1) }}/5</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Detailed Ratings -->
                                        @if($feedback->criteria_count > 0)
                                            <div class="mt-3 grid grid-cols-2 gap-2">
                                                @if($feedback->credibilite !== null)
                                                    <div class="flex items-center justify-between text-xs">
                                                        <span class="text-gray-500">Crédibilité</span>
                                                        <span class="font-bold text-gray-700">{{ $feedback->credibilite }}/5</span>
                                                    </div>
                                                @endif
                                                @if($feedback->sympathie !== null)
                                                    <div class="flex items-center justify-between text-xs">
                                                        <span class="text-gray-500">Sympathie</span>
                                                        <span class="font-bold text-gray-700">{{ $feedback->sympathie }}/5</span>
                                                    </div>
                                                @endif
                                                @if($feedback->ponctualite !== null)
                                                    <div class="flex items-center justify-between text-xs">
                                                        <span class="text-gray-500">Ponctualité</span>
                                                        <span class="font-bold text-gray-700">{{ $feedback->ponctualite }}/5</span>
                                                    </div>
                                                @endif
                                                @if($feedback->proprete !== null)
                                                    <div class="flex items-center justify-between text-xs">
                                                        <span class="text-gray-500">Propreté</span>
                                                        <span class="font-bold text-gray-700">{{ $feedback->proprete }}/5</span>
                                                    </div>
                                                @endif
                                                @if($feedback->qualiteTravail !== null)
                                                    <div class="flex items-center justify-between text-xs">
                                                        <span class="text-gray-500">Qualité travail</span>
                                                        <span class="font-bold text-gray-700">{{ $feedback->qualiteTravail }}/5</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        
                                        <p class="text-gray-600 mt-3 text-sm leading-relaxed">
                                            {{ $feedback->commentaire }}
                                        </p>
                                        
                                        <div class="flex items-center justify-between mt-4">
                                            <span class="text-xs text-gray-400">
                                                {{ \Carbon\Carbon::parse($feedback->dateCreation)->diffForHumans() }}
                                            </span>
                                        </div>

                                        <div class="mt-5">
                                            <button wire:click="openReclamationModal({{ $feedback->idFeedBack }})"
                                                    class="text-sm text-red-600 hover:underline">
                                                Signaler
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                    </svg>
                                </div>
                                <h3 class="text-gray-500 font-medium">Aucun avis reçu pour le moment</h3>
                                <p class="text-gray-400 text-sm mt-1">Les avis de vos clients apparaîtront ici</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination for Received Feedbacks -->
                    @if($feedBacksOnPetKeeper->hasPages())
                        <div class="p-4 border-t border-gray-100">
                            {{ $feedBacksOnPetKeeper->links('vendor.livewire.tailwind') }}
                        </div>
                    @endif
                </div>

                <!-- Feedbacks Given -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"/>
                                </svg>
                                Avis donnés à mes clients
                            </h2>
                            <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">
                                {{ $feedBacksOnClient->total() }} avis
                            </span>
                        </div>
                        <p class="text-gray-500 text-sm mt-1">Ce que je pense de mes clients</p>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @forelse($feedBacksOnClient as $feedback)
                            <div class="p-6 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start gap-4">
                                    <!-- Avatar -->
                                    <div class="flex-shrink-0">
                                        @if($feedback->photo)
                                            <img src="{{ Storage::url($feedback->photo) }}" 
                                                 class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-800 font-bold text-lg">
                                                {{ strtoupper(substr($feedback->prenom, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-bold text-gray-900">{{ $feedback->prenom }}</h4>
                                            <div class="flex items-center gap-2">
                                                <!-- Rating Stars -->
                                                <div class="flex text-emerald-400">
                                                    @php
                                                        $averageRating = $feedback->note_moyenne;
                                                    @endphp
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= floor($averageRating))
                                                            <!-- Full star -->
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                        @elseif($i - 0.5 <= $averageRating && $averageRating < $i)
                                                            <!-- Half star -->
                                                            <div class="relative">
                                                                <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                </svg>
                                                                <div class="absolute top-0 left-0 overflow-hidden" style="width: 50%;">
                                                                    <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <!-- Empty star -->
                                                            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="text-sm font-bold text-emerald-600">{{ number_format($averageRating, 1) }}/5</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Detailed Ratings -->
                                        @if($feedback->criteria_count > 0)
                                            <div class="mt-3 grid grid-cols-2 gap-2">
                                                @if($feedback->credibilite !== null)
                                                    <div class="flex items-center justify-between text-xs">
                                                        <span class="text-gray-500">Crédibilité</span>
                                                        <span class="font-bold text-gray-700">{{ $feedback->credibilite }}/5</span>
                                                    </div>
                                                @endif
                                                @if($feedback->sympathie !== null)
                                                    <div class="flex items-center justify-between text-xs">
                                                        <span class="text-gray-500">Sympathie</span>
                                                        <span class="font-bold text-gray-700">{{ $feedback->sympathie }}/5</span>
                                                    </div>
                                                @endif
                                                @if($feedback->ponctualite !== null)
                                                    <div class="flex items-center justify-between text-xs">
                                                        <span class="text-gray-500">Ponctualité</span>
                                                        <span class="font-bold text-gray-700">{{ $feedback->ponctualite }}/5</span>
                                                    </div>
                                                @endif
                                                @if($feedback->proprete !== null)
                                                    <div class="flex items-center justify-between text-xs">
                                                        <span class="text-gray-500">Propreté</span>
                                                        <span class="font-bold text-gray-700">{{ $feedback->proprete }}/5</span>
                                                    </div>
                                                @endif
                                                @if($feedback->qualiteTravail !== null)
                                                    <div class="flex items-center justify-between text-xs">
                                                        <span class="text-gray-500">Qualité travail</span>
                                                        <span class="font-bold text-gray-700">{{ $feedback->qualiteTravail }}/5</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        
                                        <p class="text-gray-600 mt-3 text-sm leading-relaxed">
                                            {{ $feedback->commentaire }}
                                        </p>
                                        
                                        <div class="flex items-center justify-between mt-4">
                                            <span class="text-xs text-gray-400">
                                                {{ \Carbon\Carbon::parse($feedback->dateCreation)->diffForHumans() }}
                                            </span>
                                            
                                        </div>

                                        
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </div>
                                <h3 class="text-gray-500 font-medium">Aucun avis donné pour le moment</h3>
                                <p class="text-gray-400 text-sm mt-1">Vos avis sur vos clients apparaîtront ici</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination for Given Feedbacks -->
                    @if($feedBacksOnClient->hasPages())
                        <div class="p-4 border-t border-gray-100">
                            {{ $feedBacksOnClient->links('vendor.livewire.tailwind') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>


    <div>
        <!-- Reclamation Modal -->
        @if($showReclamationModal)
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
                <div class="bg-white rounded-xl shadow-xl max-w-lg w-full">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Signaler un avis</h3>

                        <form wire:submit.prevent="submitReclamation" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sujet *</label>
                                <input type="text" wire:model.defer="sujet"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                       placeholder="Ex: Avis offensant, faux avis…">
                                @error('sujet')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea wire:model.defer="description" rows="4"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                          placeholder="Expliquez le problème (optionnel)"></textarea>
                                @error('description')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Priorité</label>
                                <select wire:model.defer="priorite"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                    <option value="faible">Faible</option>
                                    <option value="moyenne">Moyenne</option>
                                    <option value="urgente">Urgente</option>
                                </select>
                                @error('priorite')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Preuve (optionnelle)</label>
                                <input type="file" wire:model="preuves" class="w-full text-sm text-gray-600">
                                @error('preuves')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror

                                <div wire:loading wire:target="preuves" class="text-xs text-gray-500 mt-1">
                                    Téléversement…
                                </div>
                            </div>

                            <div class="flex gap-3 pt-4">
                                <button type="button" wire:click="closeReclamationModal"
                                        class="flex-1 px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                    Annuler
                                </button>
                                <button type="submit"
                                        class="flex-1 px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700">
                                    Envoyer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>