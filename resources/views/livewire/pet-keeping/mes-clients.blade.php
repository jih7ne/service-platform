<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Mes Clients</h1>
            <p class="text-gray-600 mt-2">Gérez votre clientèle et suivez vos interventions</p>
        </div>
        
        <!-- User Profile -->
        <div class="flex items-center space-x-4">
            <a href="/pet-keeper/dashboard" 
            class="ml-4 px-4 py-2.5 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-semibold rounded-lg hover:from-yellow-600 hover:to-yellow-700 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </div>
            </a>
            
            <button wire:click="logout" 
                    class="ml-4 px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors font-medium">
                Déconnexion
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Clients Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Clients Totaux</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $this->totalClients }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-yellow-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Revenu Total</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ number_format($this->totalRevenue, 2, ',', ' ') }} €
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Interventions Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Interventions Actives</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $this->clients->where('statut', 'validée')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           wire:model.live="search"
                           placeholder="Rechercher un client..." 
                           class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition">
                </div>
            </div>

            <!-- View Toggle and Filter -->
            <div class="flex items-center space-x-4">
                <!-- View Toggle -->
                <div class="flex items-center space-x-2">
                    <span class="text-sm font-medium text-gray-700">Affichage :</span>
                    <div class="flex bg-gray-100 rounded-lg p-1">
                        <button wire:click="$set('viewMode', 'table')" 
                                class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center space-x-2
                                       {{ ($viewMode ?? 'table') === 'table' ? 'bg-white shadow-sm text-yellow-600' : 'text-gray-600 hover:text-gray-900' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            <span>Tableau</span>
                        </button>
                        <button wire:click="$set('viewMode', 'cards')" 
                                class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center space-x-2
                                       {{ ($viewMode ?? 'table') === 'cards' ? 'bg-white shadow-sm text-yellow-600' : 'text-gray-600 hover:text-gray-900' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                            <span>Cartes</span>
                        </button>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="flex items-center space-x-2">
                    <span class="text-sm font-medium text-gray-700">Statut :</span>
                    <div class="flex bg-gray-100 rounded-lg p-1">
                        <button wire:click="setFilter('all')" 
                                class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 
                                       {{ $filterStatus === 'all' ? 'bg-white shadow-sm text-yellow-600' : 'text-gray-600 hover:text-gray-900' }}">
                            Tous
                        </button>
                        <button wire:click="setFilter('en_cours')" 
                                class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 
                                       {{ $filterStatus === 'en_cours' ? 'bg-white shadow-sm text-yellow-600' : 'text-gray-600 hover:text-gray-900' }}">
                            En cours
                        </button>
                        <button wire:click="setFilter('terminé')" 
                                class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 
                                       {{ $filterStatus === 'terminé' ? 'bg-white shadow-sm text-yellow-600' : 'text-gray-600 hover:text-gray-900' }}">
                            Terminé
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table View -->
    @if(($viewMode ?? 'table') === 'table')
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                Client
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                Dernière intervention
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                Statut
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                Montant
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($this->clients as $client)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <!-- Client Info -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 relative">
                                            @if($client->photo)
                                                <img class="h-12 w-12 rounded-full border-2 border-yellow-600 object-cover"
                                                     src="{{ asset('storage/' . $client->photo) }}" 
                                                     alt="{{ $client->prenom }}">
                                            @else
                                                <div class="h-12 w-12 rounded-full border-2 border-yellow-600 bg-yellow-100 flex items-center justify-center">
                                                    <span class="font-semibold text-yellow-600 text-lg">
                                                        {{ strtoupper(substr($client->prenom, 0, 1)) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $client->prenom }} {{ $client->nom }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                ID: #{{ str_pad($client->client_id, 6, '0', STR_PAD_LEFT) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Last Intervention Date -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($client->dateSouhaitee)->format('d/m/Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($client->dateSouhaitee)->diffForHumans() }}
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($client->statut === 'validée')
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            En cours
                                        </span>
                                    @elseif($client->statut === 'terminée')
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Terminé
                                        </span>
                                    @endif
                                </td>

                                <!-- Amount -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    @if($client->montantTotal)
                                        {{ number_format($client->montantTotal, 2, ',', ' ') }} €
                                    @else
                                        <span class="text-gray-400">Non facturé</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <p class="text-lg font-medium text-gray-900 mb-2">Aucun client trouvé</p>
                                        <p class="text-gray-500">Commencez par accepter des demandes d'intervention</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            @if($this->clients->count() > 0)
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Affichage de <span class="font-medium">{{ $this->clients->count() }}</span> clients
                        </div>
                        <div class="text-sm text-gray-500">
                            Dernière mise à jour : {{ now()->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @else
        <!-- Cards View -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($this->clients as $client)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200">
                    <!-- Client Header -->
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    @if($client->photo)
                                        <img class="h-14 w-14 rounded-full border-2 border-yellow-600 object-cover"
                                             src="{{ asset('storage/' . $client->photo) }}" 
                                             alt="{{ $client->prenom }}">
                                    @else
                                        <div class="h-14 w-14 rounded-full border-2 border-yellow-600 bg-yellow-100 flex items-center justify-center">
                                            <span class="font-semibold text-yellow-600 text-xl">
                                                {{ strtoupper(substr($client->prenom, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg text-gray-900">
                                        {{ $client->prenom }} {{ $client->nom }}
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        ID: #{{ str_pad($client->client_id, 6, '0', STR_PAD_LEFT) }}
                                    </p>
                                </div>
                            </div>
                            @if($client->statut === 'validée')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    En cours
                                </span>
                            @elseif($client->statut === 'terminée')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Terminé
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Client Details -->
                    <div class="p-6">
                        <!-- Last Intervention -->
                        <div class="mb-6">
                            <p class="text-sm font-medium text-gray-500 mb-2">Dernière intervention</p>
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($client->dateSouhaitee)->format('d/m/Y') }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($client->dateSouhaitee)->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Revenue -->
                        <div class="mb-6">
                            <p class="text-sm font-medium text-gray-500 mb-2">Revenu généré</p>
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">
                                        @if($client->montantTotal)
                                            {{ number_format($client->montantTotal, 2, ',', ' ') }} €
                                        @else
                                            <span class="text-gray-400">Non facturé</span>
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Total des interventions
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-3">
                            <button class="flex-1 px-4 py-2 bg-yellow-50 text-yellow-700 rounded-lg hover:bg-yellow-100 transition-colors font-medium text-sm">
                                Voir profil
                            </button>
                            <button class="flex-1 px-4 py-2 bg-gray-50 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors font-medium text-sm">
                                Historique
                            </button>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="px-6 py-4 bg-gray-50 rounded-b-xl border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="text-xs text-gray-500">
                                Client depuis {{ \Carbon\Carbon::parse($client->dateSouhaitee)->format('m/Y') }}
                            </div>
                            <button class="text-sm font-medium text-yellow-600 hover:text-yellow-700 transition-colors">
                                Contacter →
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State for Cards View -->
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-sm p-12 text-center border border-gray-200">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-20 h-20 text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p class="text-xl font-medium text-gray-900 mb-3">Aucun client trouvé</p>
                            <p class="text-gray-500 max-w-md mx-auto">
                                Les clients apparaîtront ici une fois que vous aurez accepté des demandes d'intervention.
                                Vérifiez vos demandes en attente pour commencer.
                            </p>
                            <button class="mt-6 px-6 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors font-medium">
                                Voir les demandes
                            </button>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Cards View Footer -->
        @if($this->clients->count() > 0)
            <div class="mt-8 flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Affichage de <span class="font-medium">{{ $this->clients->count() }}</span> clients
                </div>
                <div class="text-sm text-gray-500">
                    Dernière mise à jour : {{ now()->format('d/m/Y H:i') }}
                </div>
            </div>
        @endif
    @endif
</div>