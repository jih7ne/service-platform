<div class="flex h-screen bg-[#F3F4F6] font-sans overflow-hidden">

    {{-- ========================================== --}}
    {{--                 SIDEBAR                    --}}
    {{-- ========================================== --}}
    <aside class="w-72 bg-white border-r border-gray-100 flex flex-col justify-between shadow-sm z-20">
        <div>
            <!-- Logo -->
            <div class="px-8 py-6 flex items-center gap-2">
                <span class="text-2xl font-bold text-gray-800">Helpora</span>
            </div>
            
            <!-- Profil Prof -->
            <div class="px-6 mb-6">
            <a href="{{ route('tutoring.profile') }}" class="block bg-[#EFF6FF] rounded-2xl p-4 flex items-center gap-4 border border-blue-100 hover:bg-blue-50 transition-colors cursor-pointer">
                    @if($photo_prof)
                        <img src="{{ asset('storage/'.$photo_prof) }}" class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">{{ substr($prenom_prof, 0, 1) }}</div>
                    @endif
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">{{ $prenom_prof }}</h3>
                        <p class="text-xs text-blue-600 font-medium">Professeur</p>
                    </div>
                </div>
            </div>

            <!-- Menu -->
            <nav class="px-4 space-y-1">
                <a href="{{ route('tutoring.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition-all">
                <svg class="w-5 h-5 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>                    Tableau de bord
                </a>
                <a href="{{ route('tutoring.requests') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Mes demandes
                </a>
                <a href="{{ route('tutoring.disponibilites') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Disponibilité
                </a>

                <!-- LIEN ACTIF -->
                <a href="{{ route('tutoring.clients') }}" class="flex items-center gap-3 px-4 py-3 bg-[#EFF6FF] text-blue-700 rounded-xl font-bold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Mes clients
                </a>

                <a href="{{ route('tutoring.courses') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Mes cours
                </a>
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

    {{-- ========================================== --}}
    {{--            CONTENU PRINCIPAL               --}}
    {{-- ========================================== --}}
    <main class="flex-1 overflow-y-auto p-8">
        
        <!-- Bouton Retour -->
        <a href="{{ route('tutoring.clients') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 font-bold mb-6 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Retour à la liste
        </a>

        <!-- En-tête Client -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8 flex flex-col md:flex-row items-center gap-8">
            <div class="relative">
                @if($client->photo)
                    <img src="{{ asset('storage/'.$client->photo) }}" class="w-24 h-24 rounded-full object-cover border-4 border-[#EFF6FF]">
                @else
                    <div class="w-24 h-24 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-3xl border-4 border-[#EFF6FF]">
                        {{ substr($client->prenom, 0, 1) }}
                    </div>
                @endif
                <div class="absolute bottom-1 right-1 w-5 h-5 bg-green-500 border-4 border-white rounded-full"></div>
            </div>
            <div class="text-center md:text-left flex-1">
                <h1 class="text-3xl font-extrabold text-gray-900">{{ $client->prenom }} {{ $client->nom }}</h1>
                <p class="text-gray-500 flex items-center justify-center md:justify-start gap-2 mt-1">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ $client->ville ?? 'Ville non renseignée' }}
                </p>
                <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-4">
                    {{-- 1. J'ai supprimé le badge "Client Vérifié" car il n'existe pas --}}
                    
                    {{-- 2. Le compteur affiche maintenant la vraie variable calculée --}}
                    @if($coursTerminesCount > 0)
                        <span class="px-3 py-1 bg-yellow-50 text-yellow-700 text-xs font-bold rounded-lg border border-yellow-100">
                            {{ $coursTerminesCount }} Cours terminés
                        </span>
                    @else
                        <span class="px-3 py-1 bg-gray-50 text-gray-500 text-xs font-bold rounded-lg border border-gray-200">
                            Nouveau client
                        </span>
                    @endif
                </div>
            </div>
            
            <!-- Actions Rapides -->
            <div class="flex gap-3">
                <a href="mailto:{{ $client->email }}" class="p-3 bg-gray-100 rounded-xl text-gray-600 hover:bg-blue-100 hover:text-blue-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Colonne Gauche : Coordonnées -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Coordonnées</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                            <div class="text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></div>
                            <div class="overflow-hidden">
                                <p class="text-xs text-gray-400 font-bold uppercase">Email</p>
                                <p class="text-sm font-semibold text-gray-800 truncate" title="{{ $client->email }}">{{ $client->email }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                            <div class="text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg></div>
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase">Téléphone</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $client->telephone ?? 'Non renseigné' }}</p>
                            </div>
                        </div>

                        @if($client->adresse)
                        <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                            <div class="text-gray-400 mt-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase">Adresse</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $client->adresse }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Colonne Droite : Historique & Avis -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Historique -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Historique des cours
                    </h3>

                    <div class="overflow-hidden">
                        @forelse($coursHistorique as $cours)
                            <div class="flex items-center justify-between p-4 border-b border-gray-50 last:border-0 hover:bg-gray-50 transition-colors rounded-lg">
                                <div class="flex items-center gap-4">
                                    <div class="bg-blue-100 text-blue-600 font-bold px-3 py-1 rounded text-xs uppercase">
                                        {{ $cours->nom_matiere }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">
                                            {{ \Carbon\Carbon::parse($cours->dateSouhaitee)->format('d M Y') }}
                                        </p>
                                        <p class="text-xs text-gray-500">{{ substr($cours->heureDebut, 0, 5) }} - {{ substr($cours->heureFin, 0, 5) }} • {{ $cours->type_service }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="block font-bold text-gray-900">{{ $cours->montant_total }} DH</span>
                                    @if($cours->statut == 'validée')
                                        <span class="text-[10px] text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded-full">À venir</span>
                                    @else
                                        <span class="text-[10px] text-gray-500 font-bold bg-gray-100 px-2 py-0.5 rounded-full">Terminé</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-gray-400 italic">Aucun cours effectué pour le moment.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Feedbacks (Avis d'autres profs) -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        Avis des intervenants
                    </h3>

                    <div class="space-y-4">
                        @forelse($feedbacks as $fb)
                            <div class="bg-gray-50 p-4 rounded-xl">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-gray-300 flex items-center justify-center text-xs font-bold text-white">
                                            {{ substr($fb->auteur_prenom, 0, 1) }}
                                        </div>
                                        <span class="text-sm font-bold text-gray-800">{{ $fb->auteur_prenom }} {{ $fb->auteur_nom }}</span>
                                    </div>
                                    <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($fb->dateCreation)->diffForHumans() }}</span>
                                </div>
                                <!-- Etoiles -->
                                <div class="flex text-yellow-400 text-xs mb-2">
                                    @for($i=0; $i<5; $i++)
                                        <svg class="w-3 h-3 {{ $i < ($fb->sympathie ?? 5) ? 'fill-current' : 'text-gray-200' }}" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    @endfor
                                </div>
                                <p class="text-sm text-gray-600 italic">"{{ $fb->commentaire }}"</p>
                            </div>
                        @empty
                            <div class="text-center py-6 text-gray-400 italic">Aucun avis pour le moment.</div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </main>
</div>