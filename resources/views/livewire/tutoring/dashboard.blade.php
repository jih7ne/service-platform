<div class="flex h-screen bg-[#F3F4F6] font-sans overflow-hidden">

    {{-- ========================================== --}}
    {{--              SIDEBAR (GAUCHE)              --}}
    {{-- ========================================== --}}
    <livewire:tutoring.components.professeur-sidebar :currentPage="'tutoring-dashboard'" />

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
                    <h3 class="text-3xl font-extrabold text-gray-800">{{ $note }}</h3>
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
            </div>
        @endif
    </main>
</div>