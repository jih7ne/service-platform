<div class="min-h-screen bg-[#F8F9FA] font-sans text-gray-800 flex">

    <!-- SIDEBAR (Identique au Dashboard pour ne pas perdre le menu) -->
    <aside class="w-72 bg-white h-screen fixed left-0 top-0 border-r border-gray-100 flex flex-col z-40">
        <div class="p-8 flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-700 rounded-xl flex items-center justify-center text-white font-bold shadow-amber-200 shadow-lg">H</div>
            <span class="text-2xl font-extrabold text-gray-800 tracking-tight">Helpora</span>
        </div>
        
        <nav class="flex-1 px-4 space-y-2 mt-4">
            <a href="/pet-keeper/dashboard" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour Dashboard
            </a>
        </nav>
    </aside>

    <!-- CONTENU PRINCIPAL -->
    <main class="flex-1 ml-72 p-10">
        
        <!-- En-tête -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        {{ $demande->statut }}
                    </span>
                    <span class="text-gray-400 text-sm">#MSN-{{ $demande->id_demande_reelle }}</span>
                </div>
                <h1 class="text-3xl font-extrabold text-gray-900">Détails de la mission</h1>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500 uppercase font-bold">Total Estimé</p>
                <p class="text-4xl font-black text-amber-600">{{ number_format($prix_estime, 0) }} <span class="text-lg text-gray-400">DH</span></p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-8">
            
            <!-- COLONNE GAUCHE : CLIENT & ANIMAL (2/3) -->
            <div class="col-span-2 space-y-6">
                
                <!-- Carte Client -->
                <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                    <h3 class="font-bold text-lg text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">👤</span>
                        Informations Client
                    </h3>
                    
                    <div class="flex items-start gap-6">
                        <div class="w-20 h-20 rounded-2xl bg-gray-200 overflow-hidden">
                            @if($demande->photo_client)
                                <img src="{{ Storage::url($demande->photo_client) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-2xl">👤</div>
                            @endif
                        </div>
                        <div class="space-y-3 flex-1">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase">Nom complet</p>
                                    <p class="font-bold text-gray-900">{{ $demande->prenom_client }} {{ $demande->nom_client }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase">Ville</p>
                                    <p class="font-bold text-gray-900">{{ $demande->ville_client ?? 'Non renseigné' }}</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-xs text-gray-400 font-bold uppercase">Adresse</p>
                                    <p class="font-bold text-gray-900">{{ $demande->adresse_client ?? $demande->lieu ?? 'Adresse non communiquée' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carte Animal -->
                <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                    <h3 class="font-bold text-lg text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-amber-500">🐶</span>
                        Profil de l'animal
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-2xl">
                            <p class="text-xs text-gray-400 font-bold uppercase">Nom</p>
                            <p class="text-xl font-bold text-gray-900">{{ $demande->nom_animal ?? 'Inconnu' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-2xl">
                            <p class="text-xs text-gray-400 font-bold uppercase">Race</p>
                            <p class="text-xl font-bold text-gray-900">{{ $demande->race_animal ?? 'Non spécifiée' }}</p>
                        </div>
                        <div class="col-span-2 bg-gray-50 p-4 rounded-2xl">
                            <p class="text-xs text-gray-400 font-bold uppercase">Notes spéciales / Besoins</p>
                            <p class="text-gray-700 mt-1">{{ $demande->note_speciales ?? $demande->details_animal ?? 'Aucune instruction particulière pour cet animal.' }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- COLONNE DROITE : PLANNING (1/3) -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm h-full">
                    <h3 class="font-bold text-lg text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-500">📅</span>
                        Planning
                    </h3>

                    <div class="relative pl-6 border-l-2 border-gray-100 space-y-8">
                        <!-- Date -->
                        <div class="relative">
                            <div class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-green-500 border-4 border-white shadow-sm"></div>
                            <p class="text-xs text-gray-400 font-bold uppercase">Date de la mission</p>
                            <p class="text-lg font-bold text-gray-900">{{ \Carbon\Carbon::parse($demande->dateSouhaitee)->format('d F Y') }}</p>
                        </div>

                        <!-- Heure Début -->
                        <div class="relative">
                            <div class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-gray-300 border-4 border-white"></div>
                            <p class="text-xs text-gray-400 font-bold uppercase">Arrivée</p>
                            <p class="text-lg font-bold text-gray-900">{{ \Carbon\Carbon::parse($demande->heureDebut)->format('H:i') }}</p>
                        </div>

                        <!-- Heure Fin -->
                        <div class="relative">
                            <div class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-gray-300 border-4 border-white"></div>
                            <p class="text-xs text-gray-400 font-bold uppercase">Départ</p>
                            <p class="text-lg font-bold text-gray-900">{{ \Carbon\Carbon::parse($demande->heureFin)->format('H:i') }}</p>
                        </div>
                    </div>
                    
                    @if($demande->statut === 'en_attente')
                        <div class="mt-10 pt-6 border-t border-gray-100 space-y-3">
                            <p class="text-center text-sm text-gray-500 mb-4">Cette mission est en attente de votre réponse.</p>
                            <button class="w-full py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-bold rounded-xl shadow-lg shadow-amber-200 hover:shadow-xl hover:scale-105 transition-all">
                                Accepter la mission
                            </button>
                            <button class="w-full py-3 bg-white border-2 border-red-50 text-red-500 font-bold rounded-xl hover:bg-red-50 transition-colors">
                                Refuser
                            </button>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </main>
</div>