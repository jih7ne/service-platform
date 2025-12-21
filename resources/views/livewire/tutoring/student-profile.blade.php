<div class="flex h-screen bg-[#F3F4F6] font-sans overflow-hidden">

    <livewire:tutoring.components.professeur-sidebar :currentPage="'tutoring-requests'" />

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 md:p-8">
        
        <a href="{{ $backUrl }}" class="inline-flex items-center text-xs sm:text-sm text-gray-500 hover:text-blue-600 font-bold mb-4 sm:mb-6 transition-colors">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            @if(str_contains($backUrl, 'demande/'))
                Retour aux détails de la demande
            @else
                Retour à la liste des demandes
            @endif
        </a>
        
        <!-- Header Profil -->
        <div class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 md:p-8 shadow-sm border border-gray-100 mb-6 sm:mb-8 flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-6">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-6 w-full">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-indigo-600 flex items-center justify-center text-white text-2xl sm:text-3xl font-bold border-4 border-[#F3F4F6] shadow-lg overflow-hidden flex-shrink-0">
                    @if($eleve->photo)
                        <img src="{{ asset('storage/'.$eleve->photo) }}" class="w-full h-full object-cover">
                    @else
                        {{ substr($eleve->prenom, 0, 1) }}
                    @endif
                </div>
                <div class="text-center sm:text-left w-full">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-2 sm:gap-3">
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-gray-900">{{ $eleve->prenom }} {{ $eleve->nom }}</h1>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-500 flex items-center justify-center sm:justify-start mt-2">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $eleve->ville ?? 'Ville non renseignée' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
            
            <!-- Colonne Gauche : Infos (Restreintes pour un candidat) -->
            <div class="lg:col-span-1 space-y-4 sm:space-y-6">
                <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-5 md:p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-sm sm:text-base text-gray-900 mb-3 sm:mb-4">À propos de l'élève</h3>
                    
                    <div class="space-y-3 sm:space-y-4">
                        <div class="flex items-center gap-2 sm:gap-3 p-3 bg-gray-50 rounded-lg sm:rounded-xl">
                            <div class="text-gray-400 flex-shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase">Membre depuis</p>
                                <p class="text-xs sm:text-sm font-semibold text-gray-800">{{ \Carbon\Carbon::parse($eleve->created_at)->format('M Y') }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Colonne Droite : Avis des autres profs -->
            <div class="lg:col-span-2 space-y-4 sm:space-y-6">
                
                <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-5 md:p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-sm sm:text-base text-gray-900 mb-4 sm:mb-6 flex items-center gap-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                        <span class="truncate">Avis des intervenants précédents</span>
                    </h3>

                    <div class="space-y-3 sm:space-y-4">
                        @forelse($feedbacks as $fb)
                            <div class="bg-gray-50 p-4 sm:p-5 rounded-xl sm:rounded-2xl border border-gray-100">
                                <div class="flex flex-col sm:flex-row justify-between items-start gap-2 mb-2 sm:mb-3">
                                    <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto">
                                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gray-300 flex items-center justify-center text-xs sm:text-sm font-bold text-white flex-shrink-0">
                                            {{ substr($fb->prof_prenom, 0, 1) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs sm:text-sm font-bold text-gray-800 truncate">{{ $fb->prof_prenom }} {{ $fb->prof_nom }}</p>
                                            <p class="text-[9px] sm:text-[10px] text-gray-500 uppercase tracking-wide">Professeur</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] sm:text-xs text-gray-400 whitespace-nowrap ml-auto sm:ml-0">{{ \Carbon\Carbon::parse($fb->dateCreation)->diffForHumans() }}</span>
                                </div>
                                
                                <!-- Etoiles -->
                                <div class="flex text-yellow-400 text-xs mb-2 sm:mb-3 ml-0 sm:ml-11">
                                    @for($i=0; $i<5; $i++)
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 {{ $i < ($fb->sympathie ?? 5) ? 'fill-current' : 'text-gray-200' }}" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    @endfor
                                </div>

                                <p class="text-xs sm:text-sm text-gray-600 italic ml-0 sm:ml-11 break-words">"{{ $fb->commentaire }}"</p>
                            </div>
                        @empty
                            <div class="text-center py-8 sm:py-10 bg-white rounded-lg sm:rounded-xl border-2 border-dashed border-gray-200">
                                <p class="text-sm sm:text-base text-gray-400 italic">Aucun avis pour le moment.</p>
                                <p class="text-[10px] sm:text-xs text-gray-300 mt-1">Cet élève est peut-être nouveau sur la plateforme.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>