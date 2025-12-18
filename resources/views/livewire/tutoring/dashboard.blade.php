<div class="flex h-screen bg-[#F3F4F6] font-sans overflow-hidden">

    {{-- ========================================== --}}
    {{--              SIDEBAR (GAUCHE)              --}}
    {{-- ========================================== --}}
    <aside class="w-72 bg-white border-r border-gray-100 flex flex-col justify-between shadow-sm z-20">
        
        <!-- Partie Haute -->
        <div>
            <!-- Logo -->
            <div class="px-14 py-6 flex items-center gap-2">
                <span class="text-2xl font-bold text-gray-800">Helpora</span>
            </div>

            <!-- Carte Profil (Style Petkeeper) -->
            <div class="px-6 mb-6">
                <a href="{{ route('tutoring.profile') }}" class="block bg-[#EFF6FF] rounded-2xl p-4 flex items-center gap-4 border border-blue-100 hover:bg-blue-50 transition-colors cursor-pointer">
                    @if($photo)
                        <img src="{{ asset('storage/'.$photo) }}" class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">{{ substr($prenom, 0, 1) }}</div>
                    @endif
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">{{ $prenom }}</h3>
                        <p class="text-xs text-blue-600 font-medium">Professeur</p>
                    </div>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="px-4 space-y-1">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-4">Menu Principal</p>
                
                <a href="{{ route('tutoring.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-[#EFF6FF] text-blue-700 rounded-xl font-bold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Tableau de bord
                </a>

                <a href="{{ route('tutoring.requests') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 rounded-xl font-medium transition-all group">
                    <svg class="w-5 h-5 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Mes demandes
                    @if($enAttente > 0)
                        <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $enAttente }}</span>
                    @endif
                </a>

            
                <a href="{{ route('tutoring.disponibilites') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> Disponibilité</a>

                <a href="{{ route('tutoring.clients') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition-all group">
                    <svg class="w-5 h-5 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Mes clients
                </a>

                <a href="{{ route('tutoring.courses') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 rounded-xl font-medium transition-all group">
                    <svg class="w-5 h-5 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Mes cours
                </a>

                <a href="{{ route('tutoring.avis') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-gray-900 rounded-xl font-medium transition-all group">
                    <svg class="w-5 h-5 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    Avis
                </a>
            </nav>
        </div>

        <!-- Partie Basse (Paramètres & Déconnexion) -->
        <div class="p-4 border-t border-gray-100 space-y-1">
            <button wire:click="logout" class="w-full flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl font-medium transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Déconnexion
            </button>
        </div>
    </aside>

    {{-- ========================================== --}}
    {{--            CONTENU PRINCIPAL (DROITE)      --}}
    {{-- ========================================== --}}
    <main class="flex-1 overflow-y-auto p-8">
        
        {{-- CAS 1 : COMPTE NON VALIDÉ --}}
        @if($isPending)
            <div class="h-full flex flex-col justify-center items-center text-center">
                <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 max-w-lg w-full">
                    <div class="w-20 h-20 bg-yellow-50 text-yellow-500 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl animate-pulse">⏳</div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Vérification en cours</h1>
                    <p class="text-gray-500 mb-6">Votre profil est en cours d'examen par l'équipe Helpora.</p>
                    <button wire:click="logout" class="text-red-500 hover:underline font-bold text-sm">Se déconnecter</button>
                </div>
            </div>

        {{-- CAS 2 : DASHBOARD ACTIF --}}
        @else
            <!-- Header du Contenu -->
            <header class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8 flex flex-col md:flex-row justify-between items-center">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-800 flex items-center gap-2">
                        Bonjour, {{ $prenom }} ! 
                    </h1>
                    <p class="text-gray-500 mt-1">Vous avez <strong class="text-blue-600">{{ $enAttente }} nouvelles demandes</strong> aujourd'hui</p>
                </div>
                
            </header>

            <!-- KPIs (Stats) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Carte 1 -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-green-50 rounded-xl text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                       
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Cours actifs</p>
                    <h3 class="text-3xl font-extrabold text-gray-800">{{ $coursActifs }}</h3>
                </div>

                <!-- Carte 2 -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-yellow-50 rounded-xl text-yellow-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        </div>
                        
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Note Moyenne</p>
                    <h3 class="text-3xl font-extrabold text-gray-800">{{ $note }}
                </div>

                <!-- Carte 3 -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </div>
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">En attente</p>
                    <h3 class="text-3xl font-extrabold text-gray-800">{{ $enAttente }}</h3>
                </div>

                <!-- Carte 4 -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-pink-50 rounded-xl text-pink-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    
                    </div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Revenu ce mois</p>
                    <h3 class="text-3xl font-extrabold text-gray-800">{{ number_format($totalGagne, 0, ',', ' ') }} <span class="text-lg text-gray-500 font-bold">DH</span></h3>
                </div>
            </div>

            <!-- Section 2 : Dernières Demandes & Calendrier -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Liste des Demandes (Largeur 2/3) -->
                <div class="lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                            Dernières demandes reçues
                        </h2>
                        <a href="{{ route('tutoring.requests') }}" class="text-sm font-bold text-blue-500 hover:text-blue-600 hover:underline">Voir tout →</a>
                    </div>

                    <div class="space-y-4">
                        @forelse($demandesRecentes as $demande)
                            <div class="bg-white border border-gray-100 rounded-2xl p-6 flex flex-col md:flex-row justify-between items-center transition-transform hover:-translate-y-1 shadow-sm hover:shadow-md">
                                
                                <!-- Gauche -->
                                <div class="flex items-center gap-4 w-full md:w-auto mb-4 md:mb-0">
                                    <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg border-2 border-white shadow-sm">
                                        {{ substr($demande->client_prenom, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-lg">{{ $demande->client_prenom }} {{ $demande->client_nom }}</h4>
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded font-bold uppercase">{{ $demande->nom_matiere ?? 'Soutien' }}</span>
                                            • {{ $demande->type_service }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Droite : Date et Prix -->
                                <div class="text-right flex flex-col items-end">
                                    <span class="text-xs text-gray-400 font-medium mb-1">
                                        {{ \Carbon\Carbon::parse($demande->dateDemande)->diffForHumans() }}
                                    </span>
                                    <p class="text-xl font-extrabold text-gray-900">{{ $demande->montant_total }} DH</p>
                                    
                                    {{-- Lien vers détails --}}
                                    <a href="{{ route('tutoring.request.details', ['id' => $demande->idDemande]) }}" class="mt-2 text-xs font-bold text-blue-600 hover:underline">
                                        Traiter la demande
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white p-8 rounded-2xl border border-dashed border-gray-300 text-center h-40 flex flex-col justify-center items-center">
                                <p class="text-gray-400 font-medium">Aucune nouvelle demande pour le moment.</p>
                                <p class="text-xs text-gray-300 mt-1">Votre profil est visible, patience !</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                <!-- Widget Droit : Prochains Cours (Réel) -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-gray-800">Cours à venir</h3>
                        <a href="#" class="text-xs font-bold text-blue-600 hover:underline">Voir calendrier</a>
                    </div>

                    <div class="relative pl-4 border-l-2 border-gray-100 space-y-6">
                        @forelse($coursAVenir as $cours)
                            <div class="relative group">
                                <!-- Point timeline -->
                                <div class="absolute -left-[21px] top-1 w-4 h-4 bg-white border-4 border-blue-500 rounded-full shadow-sm group-hover:scale-110 transition-transform"></div>
                                
                                <p class="text-xs font-bold text-blue-500 mb-1 capitalize">
                                    {{ \Carbon\Carbon::parse($cours->dateSouhaitee)->isoFormat('dddd D MMM') }}, {{ substr($cours->heureDebut, 0, 5) }}
                                </p>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                                        {{ substr($cours->client_prenom, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">{{ $cours->client_prenom }} {{ $cours->client_nom }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $cours->nom_matiere }} • {{ $cours->montant_total }} DH
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-4 text-center">
                                <p class="text-sm text-gray-400">Aucun cours planifié prochainement.</p>
                            </div>
                        @endforelse
                    </div>

                    
                </div>
        @endif
    </main>
</div>