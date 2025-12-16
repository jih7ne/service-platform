<div class="flex h-screen bg-[#F3F4F6] font-sans overflow-hidden">

    {{-- SIDEBAR (On garde la navigation active sur "Mes Demandes" car on est dans ce processus) --}}
    <aside class="w-72 bg-white border-r border-gray-100 flex flex-col justify-between shadow-sm z-20">
        <div>
            <div class="px-8 py-6 flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">H</div>
                <span class="text-2xl font-bold text-gray-800">Helpora</span>
            </div>
            
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
                </a>
            </div>

            <nav class="px-4 space-y-1">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-4">Menu Principal</p>
                
                <a href="#" class="flex items-center gap-3 px-4 py-3 bg-[#EFF6FF] text-blue-700 rounded-xl font-bold transition-all">
                <svg class="w-5 h-5 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>                    Tableau de bord
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
            </nav>
        </div>
        <div class="p-4 border-t border-gray-100">
            
            <button wire:click="logout" class="w-full flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl font-medium transition-all">Déconnexion</button>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto p-8">
        
        <a href="{{ $backUrl }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 font-bold mb-6 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            @if(str_contains($backUrl, 'demande/'))
                Retour aux détails de la demande
            @else
                Retour à la liste des demandes
            @endif
        </a>
        
        <!-- Header Profil -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 rounded-full bg-indigo-600 flex items-center justify-center text-white text-3xl font-bold border-4 border-[#F3F4F6] shadow-lg overflow-hidden">
                    @if($eleve->photo)
                        <img src="{{ asset('storage/'.$eleve->photo) }}" class="w-full h-full object-cover">
                    @else
                        {{ substr($eleve->prenom, 0, 1) }}
                    @endif
                </div>
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-3xl font-extrabold text-gray-900">{{ $eleve->prenom }} {{ $eleve->nom }}</h1>
                    </div>
                    <p class="text-gray-500 flex items-center mt-2">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $eleve->ville ?? 'Ville non renseignée' }}
                    </p>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Colonne Gauche : Infos (Restreintes pour un candidat) -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">À propos de l'élève</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                            <div class="text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase">Membre depuis</p>
                                <p class="text-sm font-semibold text-gray-800">{{ \Carbon\Carbon::parse($eleve->created_at)->format('M Y') }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Colonne Droite : Avis des autres profs -->
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                        Avis des intervenants précédents
                    </h3>

                    <div class="space-y-4">
                        @forelse($feedbacks as $fb)
                            <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-xs font-bold text-white">
                                            {{ substr($fb->prof_prenom, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">{{ $fb->prof_prenom }} {{ $fb->prof_nom }}</p>
                                            <p class="text-[10px] text-gray-500 uppercase tracking-wide">Professeur</p>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($fb->dateCreation)->diffForHumans() }}</span>
                                </div>
                                
                                <!-- Etoiles -->
                                <div class="flex text-yellow-400 text-xs mb-3 ml-11">
                                    @for($i=0; $i<5; $i++)
                                        <svg class="w-3 h-3 {{ $i < ($fb->sympathie ?? 5) ? 'fill-current' : 'text-gray-200' }}" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    @endfor
                                </div>

                                <p class="text-sm text-gray-600 italic ml-11">"{{ $fb->commentaire }}"</p>
                            </div>
                        @empty
                            <div class="text-center py-10 bg-white rounded-xl border-2 border-dashed border-gray-200">
                                <p class="text-gray-400 italic">Aucun avis pour le moment.</p>
                                <p class="text-xs text-gray-300 mt-1">Cet élève est peut-être nouveau sur la plateforme.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>