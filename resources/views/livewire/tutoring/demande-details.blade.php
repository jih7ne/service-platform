<div class="flex h-screen bg-[#F3F4F6] font-sans overflow-hidden">

    {{-- SIDEBAR --}}
    <aside class="w-72 bg-white border-r border-gray-100 flex flex-col justify-between shadow-sm z-20">
        <div>
            <div class="px-8 py-6 flex items-center gap-2">
                <span class="text-2xl font-bold text-gray-800">Helpora</span>
            </div>
            
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

            <nav class="px-4 space-y-1">
                <a href="{{ route('tutoring.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Tableau de bord
                </a>
                <a href="{{ route('tutoring.requests') }}" class="flex items-center gap-3 px-4 py-3 bg-[#EFF6FF] text-blue-700 rounded-xl font-bold transition-all">
                    <svg class="w-5 h-5 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Mes demandes
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> Disponibilité</a>
                <a href="{{ route('tutoring.clients') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg> Mes clients</a>
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
        
        <!-- Bouton Retour -->
        <a href="{{ route('tutoring.requests') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 font-bold mb-6 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Retour aux demandes
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Colonne Gauche (Info Client) -->
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-6 mb-8">
                        <!-- Avatar Unique -->
                        <div class="w-20 h-20 rounded-full bg-blue-600 flex items-center justify-center text-white text-3xl font-bold border-4 border-white shadow-md overflow-hidden flex-shrink-0">
                            @if($demande->client_photo)
                                <img src="{{ asset('storage/'.$demande->client_photo) }}" class="w-full h-full object-cover">
                            @else
                                {{ substr($demande->client_prenom, 0, 1) }}
                            @endif
                        </div>

                        <!-- Infos Texte -->
                        <div>
                            <h1 class="text-3xl font-extrabold text-gray-900">{{ $demande->client_prenom }} {{ $demande->client_nom }}</h1>
                            
                            <div class="mt-2 flex flex-wrap items-center gap-3">
                                @if($demande->type_service === 'enligne')
                                    <span class="inline-flex items-center bg-purple-50 text-purple-700 px-3 py-1 rounded-full text-sm font-bold border border-purple-100">
                                        Cours en Ligne
                                    </span>
                                @else
                                    <span class="inline-flex items-center bg-orange-50 text-orange-700 px-3 py-1 rounded-full text-sm font-bold border border-orange-100">
                                        Cours à Domicile
                                    </span>
                                @endif
                                
                                {{-- LIEN VERS LE PROFIL --}}
                                <a href="{{ route('tutoring.student.profile', ['id' => $demande->idClient, 'source' => 'details', 'demande_id' => $demande->idDemande]) }}"  class="text-sm font-bold text-blue-600 hover:underline flex items-center bg-blue-50 px-3 py-1 rounded-full">
                                    Voir profil complet
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Grille Détails -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-[#F8F9FD] p-6 rounded-2xl">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <p class="text-xs font-bold text-gray-400 uppercase mb-1">Matière</p>
                            <p class="text-lg font-bold text-blue-900">{{ $demande->nom_matiere }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <p class="text-xs font-bold text-gray-400 uppercase mb-1">Niveau</p>
                            <p class="text-lg font-bold text-gray-800">{{ $demande->nom_niveau }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <p class="text-xs font-bold text-gray-400 uppercase mb-1">Date & Heure</p>
                            <p class="text-lg font-bold text-gray-800">
                                {{ \Carbon\Carbon::parse($demande->dateSouhaitee)->format('d M Y') }}<br>
                                <span class="text-sm font-medium text-gray-500">{{ substr($demande->heureDebut, 0, 5) }} - {{ substr($demande->heureFin, 0, 5) }}</span>
                            </p>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <p class="text-xs font-bold text-gray-400 uppercase mb-1">Budget Total</p>
                            <p class="text-xl font-extrabold text-green-600">{{ $demande->montant_total }} DH</p>
                        </div>
                    </div>

                    @if($demande->note_speciales)
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <p class="text-sm font-bold text-gray-900 mb-2">Message de l'élève :</p>
                            <div class="bg-yellow-50 text-yellow-800 p-4 rounded-xl text-sm italic">
                                "{{ $demande->note_speciales }}"
                            </div>
                        </div>
                    @endif
                </div>

                {{-- BLOC LOCALISATION --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        @if($demande->type_service === 'enligne')
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            Mode de cours
                        @else
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Adresse du cours
                        @endif
                    </h3>

                    @if($demande->type_service === 'enligne')
                        <div class="bg-purple-50 text-purple-800 p-6 rounded-xl border border-purple-100 flex items-center gap-4">
                            <div class="bg-white p-3 rounded-full text-purple-600 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </div>
                            <p class="font-bold text-lg">Cours en ligne</p>
                        </div>
                    @else
                        <div class="flex items-start gap-4">
                            <div class="bg-orange-100 p-3 rounded-full text-orange-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-lg">{{ $demande->client_adresse }}</p>
                                <p class="text-gray-500 font-medium">{{ $demande->client_ville }}</p>
                            </div>
                        </div>
                        <div class="mt-4 w-full h-40 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 border border-gray-200">
                            <div class="text-center">
                                <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 7m0 13V7"></path></svg>
                                <span>Aperçu de la carte</span>
                            </div>
                        </div>
                    @endif
                </div>

            </div>

            <!-- Colonne Droite (Actions) -->
            <div class="lg:col-span-1 space-y-6">
                
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 sticky top-6">
                    <h3 class="font-bold text-gray-900 mb-4">Action requise</h3>
                    <p class="text-sm text-gray-500 mb-6">En acceptant, vous vous engagez à assurer ce cours. Un email de confirmation sera envoyé.</p>
                    
                    <div class="space-y-3">
                        <button 
                            wire:click="accepter" 
                            wire:confirm="Confirmer l'acceptation ?"
                            wire:loading.attr="disabled"
                            class="w-full py-3 bg-[#1E40AF] hover:bg-blue-800 text-white font-bold rounded-xl shadow-lg shadow-blue-100 transition-all flex justify-center items-center gap-2">
                            
                            <span wire:loading.remove wire:target="accepter">
                                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Accepter la demande
                            </span>
                            <span wire:loading wire:target="accepter">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </span>
                        </button>
                        
                        <button 
                            wire:click="refuser" 
                            wire:confirm="Refuser définitivement cette demande ?"
                            wire:loading.attr="disabled"
                            class="w-full py-3 bg-white border-2 border-gray-200 text-gray-600 hover:border-red-200 hover:text-red-600 font-bold rounded-xl transition-all flex justify-center items-center gap-2">
                            <span wire:loading.remove wire:target="refuser">Refuser</span>
                            <span wire:loading wire:target="refuser" class="text-red-600">
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </span>
                        </button>
                    </div>

                    @if($demande->client_tel)
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <p class="text-xs font-bold text-gray-400 uppercase mb-2">Contact</p>
                        <p class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            {{ $demande->client_tel }}
                        </p>
                    </div>
                    @endif
                </div>

            </div>

        </div>
    </main>
</div>