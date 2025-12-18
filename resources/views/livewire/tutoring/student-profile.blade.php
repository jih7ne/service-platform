<div class="flex h-screen bg-[#F3F4F6] font-sans overflow-hidden">

    <livewire:tutoring.components.professeur-sidebar :currentPage="'tutoring-requests'" />

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