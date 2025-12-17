<div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">

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


    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Mes Services</h1>
        <p class="mt-2 text-gray-600">Gérez et consultez tous vos services de garde d'animaux</p>
    </div>
    <a href="/pet-keeper/dashboard/add-service" 
       class="px-5 py-2.5 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors shadow-sm flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Ajouter un service
    </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" 
                           placeholder="Search services..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select wire:model.live="categoryFilter" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition bg-white">
                    <option value="">All Categories</option>
                    @foreach($categories as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Pet Type Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pet Type</label>
                <select wire:model.live="petTypeFilter" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition bg-white">
                    <option value="">All Pet Types</option>
                    @foreach($petTypes as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Results Per Page -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Results Per Page</label>
                <select wire:model.live="perPage" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition bg-white">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>

        <!-- Reset Filters Button -->
        <div class="mt-4 flex justify-end">
            <button wire:click="resetFilters" 
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-lg transition">
                Reset Filters
            </button>
        </div>
    </div>

    <!-- Services Grid -->
    @if($services->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
                    <!-- Service Header -->
                    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $service->service_name }}</h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $categories[$service->service_category] ?? $service->service_category }}
                                </p>
                            </div>
                            <span class="px-3 py-1 text-sm font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                ${{ number_format($service->service_base_price, 2) }}
                            </span>
                        </div>
                    </div>

                    <!-- Service Body -->
                    <div class="p-6">
                        <!-- Description -->
                        <p class="text-gray-700 mb-4 line-clamp-2">
                            {{ Str::limit($service->service_description, 100) }}
                        </p>

                        <!-- Details -->
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span>{{ $petTypes[$service->service_pet_type] ?? $service->service_pet_type }}</span>
                            </div>

                            <!-- Requirements Badges -->
                            @if($service->vaccination_required || $service->accepts_untrained_pets || $service->accepts_aggressive_pets)
                                <div class="flex flex-wrap gap-2">
                                    @if($service->vaccination_required)
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Vaccination
                                        </span>
                                    @endif
                                    @if($service->accepts_untrained_pets)
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Untrained
                                        </span>
                                    @endif
                                    @if($service->accepts_aggressive_pets)
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Aggressive
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Action Button -->
                        <div class="border-t border-gray-100 pt-4">
                            <button wire:click="viewService({{ $service->service_id }})" 
                                    class="w-full px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition duration-200 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($services->hasPages())
            <div class="mt-8">
                {{ $services->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No services found</h3>
            <p class="mt-2 text-gray-600">
                @if($search || $categoryFilter || $petTypeFilter)
                    Try adjusting your filters to find what you're looking for.
                @else
                    You haven't created any services yet.
                @endif
            </p>
            @if($search || $categoryFilter || $petTypeFilter)
                <button wire:click="resetFilters" 
                        class="mt-4 inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition">
                    Reset Filters
                </button>
            @endif
        </div>
    @endif
</div>
