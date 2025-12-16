<div class="flex h-screen bg-[#F3F4F6] font-sans overflow-hidden">

    {{-- SIDEBAR (Navigation) --}}
    <aside class="w-72 bg-white border-r border-gray-100 flex flex-col justify-between shadow-sm z-20">
        <div>
            <div class="px-8 py-6 flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">H</div>
                <span class="text-2xl font-bold text-gray-800">Helpora</span>
            </div>
            
            {{-- Profil Mini --}}
            <div class="px-6 mb-6">
                <a href="{{ route('tutoring.profile') }}" class="block bg-[#EFF6FF] rounded-2xl p-4 flex items-center gap-4 border border-blue-100 hover:bg-blue-50 transition-colors cursor-pointer">
                    @if($photo) <img src="{{ asset('storage/'.$photo) }}" class="w-10 h-10 rounded-full object-cover">
                    @else <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">{{ substr($prenom, 0, 1) }}</div> @endif
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">{{ $prenom }}</h3>
                        <p class="text-xs text-blue-600 font-medium">Professeur</p>
                    </div>
                </a>
            </div>

            <nav class="px-4 space-y-1">
                <a href="{{ route('tutoring.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition-all"><svg class="w-5 h-5 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Tableau de bord</a>
                <a href="{{ route('tutoring.requests') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition-all">                    <svg class="w-5 h-5 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                 Mes demandes</a>
                <a href="{{ route('tutoring.disponibilites') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> Disponibilité</a>
                
                {{-- LIEN ACTIF --}}
                <a href="#" class="flex items-center gap-3 px-4 py-3 bg-[#EFF6FF] text-blue-700 rounded-xl font-bold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Mes clients
                </a>

                <a href="{{ route('tutoring.courses') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg> Mes cours</a>
            </nav>
        </div>
        <div class="p-4 border-t border-gray-100">
            <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 rounded-xl font-medium transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Paramètres
            </a>
            <button wire:click="logout" class="w-full flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl font-medium transition-all">Déconnexion</button>
        </div>
    </aside>

    {{-- CONTENU PRINCIPAL --}}
    <main class="flex-1 overflow-y-auto p-8">
        
        <!-- 1. HEADER STATS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="p-3 bg-blue-50 rounded-xl text-blue-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                <div><p class="text-xs text-gray-400 font-bold uppercase">Total Clients</p><h3 class="text-2xl font-extrabold text-gray-800">{{ $this->stats['clients'] }}</h3></div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="p-3 bg-pink-50 rounded-xl text-pink-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></div>
                <div><p class="text-xs text-gray-400 font-bold uppercase">Cours donnés</p><h3 class="text-2xl font-extrabold text-gray-800">{{ $this->stats['cours'] }}</h3></div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="p-3 bg-yellow-50 rounded-xl text-yellow-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <div><p class="text-xs text-gray-400 font-bold uppercase">Heures enseignées</p><h3 class="text-2xl font-extrabold text-gray-800">{{ $this->stats['heures'] }}h</h3></div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="p-3 bg-green-50 rounded-xl text-green-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <div><p class="text-xs text-gray-400 font-bold uppercase">Total Revenus</p><h3 class="text-2xl font-extrabold text-green-600">{{ number_format($this->stats['revenus'], 0, ',', ' ') }} DH</h3></div>
            </div>
        </div>

        <!-- 2. BARRE DE FILTRES ET RECHERCHE -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="text-xl font-extrabold text-gray-900 ml-2">Mes clients</h2>
            
            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <div class="flex bg-gray-100 p-1 rounded-xl">
                    <button wire:click="setFilter('all')" class="px-4 py-2 rounded-lg text-sm font-bold transition-all {{ $filterStatus === 'all' ? 'bg-[#1E40AF] text-white shadow-sm' : 'text-gray-500 hover:text-gray-800' }}">Tous</button>
                    <button wire:click="setFilter('en_cours')" class="px-4 py-2 rounded-lg text-sm font-bold transition-all {{ $filterStatus === 'en_cours' ? 'bg-[#1E40AF] text-white shadow-sm' : 'text-gray-500 hover:text-gray-800' }}">En cours</button>
                    <button wire:click="setFilter('terminé')" class="px-4 py-2 rounded-lg text-sm font-bold transition-all {{ $filterStatus === 'terminé' ? 'bg-[#1E40AF] text-white shadow-sm' : 'text-gray-500 hover:text-gray-800' }}">Terminés</button>
                </div>

                <div class="relative">
                    <input type="text" wire:model.live="search" placeholder="Rechercher un client..." class="pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-full md:w-64">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- 3. GRILLE DES CARTES CLIENTS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($this->clients as $client)
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all flex flex-col items-center text-center group">
                    
                    <!-- Avatar -->
                    <div class="relative mb-4">
                        @if($client->photo)
                            <img src="{{ asset('storage/'.$client->photo) }}" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-md">
                        @else
                            <div class="w-20 h-20 rounded-full bg-blue-600 flex items-center justify-center text-white text-2xl font-bold border-4 border-white shadow-md">
                                {{ substr($client->prenom, 0, 1) }}
                            </div>
                        @endif
                        <!-- Status Badge -->
                        @if($client->statut === 'validée')
                            <div class="absolute bottom-0 right-0 px-2 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full border border-white">En cours</div>
                        @else
                            <div class="absolute bottom-0 right-0 px-2 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold rounded-full border border-white">Terminé</div>
                        @endif
                    </div>

                    <!-- Infos -->
                    <h3 class="text-lg font-bold text-gray-900">{{ $client->prenom }} {{ $client->nom }}</h3>
                    <p class="text-xs text-gray-400 mb-4">Client depuis le {{ \Carbon\Carbon::parse($client->dateSouhaitee)->format('d M Y') }}</p>

                    <div class="w-full space-y-2 mb-6">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Matière</span>
                            <span class="font-bold text-gray-800">{{ $client->nom_matiere }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Niveau</span>
                            <span class="font-bold text-gray-800">{{ $client->nom_niveau }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Tarif</span>
                            <span class="font-bold text-blue-600">{{ $client->montant_total }} DH</span>
                        </div>
                    </div>

                    <!-- Bouton Détails -->
                    <a href="{{ route('tutoring.client.details', $client->client_id) }}" class="w-full py-2.5 bg-[#1E40AF] text-white rounded-xl font-bold text-sm hover:bg-blue-800 transition-colors shadow-blue-100 shadow-lg">
                        Voir détails
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <p class="text-gray-500 font-medium">Aucun client trouvé.</p>
                </div>
            @endforelse
        </div>

    </main>
</div>