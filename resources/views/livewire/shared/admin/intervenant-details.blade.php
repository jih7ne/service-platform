<div class="flex min-h-screen bg-gray-50">
    {{-- Sidebar --}}
    @livewire('shared.admin.admin-sidebar', ['currentPage' => 'admin-intervenants'])

    {{-- Main Content --}}
    <div class="flex-1 overflow-auto">
        <div class="p-8 max-w-7xl mx-auto">
            {{-- Success Message --}}
            @if (session()->has('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 text-green-800 px-5 py-4 rounded-r-lg flex items-center justify-between shadow-sm">
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Header avec bouton retour --}}
            <div class="mb-8">
                <a href="{{ route('admin.intervenants') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Retour à la liste</span>
                </a>
            </div>

            {{-- Card principale --}}
            <div class="bg-white rounded-2xl shadow-md border border-gray-100">
                {{-- Header de la card avec profil --}}
                <div class="p-8 border-b border-gray-100">
                    <div class="flex items-start gap-6">
                        @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" class="w-20 h-20 rounded-full object-cover shadow-sm">
                        @else
                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-sm">
                                <span class="text-white font-bold text-2xl">{{ substr($user->prenom, 0, 1) }}</span>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h1 class="text-3xl font-bold text-gray-900">{{ $user->prenom }} {{ $user->nom }}</h1>
                                    <p class="text-gray-500 mt-1.5 text-base">{{ $user->email }}</p>
                                </div>
                                @php
                                    $status = strtoupper($intervenant->statut ?? $offre->statut ?? 'EN_ATTENTE');
                                @endphp
                                @if(in_array($status, ['VALIDE','VALIDÉ','ACTIVE']))
                                    <span class="px-4 py-2 inline-flex text-sm font-semibold rounded-full bg-green-100 text-green-700">
                                        Acceptée
                                    </span>
                                @elseif(in_array($status, ['REFUSE','REFUSÉ','ARCHIVED']))
                                    <span class="px-4 py-2 inline-flex text-sm font-semibold rounded-full bg-red-100 text-red-700">
                                        Refusée
                                    </span>
                                @else
                                    <span class="px-4 py-2 inline-flex text-sm font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                        En attente
                                    </span>
                                @endif
                            </div>
                            
                            <div class="flex flex-wrap gap-2.5 mt-4">
                                @if($serviceType)
                                    <span class="px-3.5 py-1.5 bg-blue-100 text-blue-700 text-sm font-semibold rounded-full">
                                        {{ $serviceType }}
                                    </span>
                                @endif
                                <span class="px-3.5 py-1.5 bg-gray-100 text-gray-600 text-sm font-medium rounded-full flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Demande le {{ $intervenant->created_at ? \Carbon\Carbon::parse($intervenant->created_at)->format('d M Y') : 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contenu --}}
                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {{-- Colonne gauche : Infos générales --}}
                        <div class="lg:col-span-1 space-y-6">
                            {{-- Coordonnées --}}
                            <div>
                                <h3 class="text-base font-bold text-gray-900 mb-5">Coordonnées</h3>
                                <div class="space-y-3">
                                    <div class="flex items-center gap-3 text-gray-700">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        <span class="text-sm">{{ $user->telephone ?? 'Non renseigné' }}</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-gray-700">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-sm">{{ $user->dateNaissance ? \Carbon\Carbon::parse($user->dateNaissance)->format('d/m/Y') : 'Non renseigné' }}</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-gray-700">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span class="text-sm">{{ $user->genre ?? 'Non renseigné' }}</span>
                                    </div>
                                    <div class="flex items-start gap-3 text-gray-700">
                                        <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <div class="flex-1">
                                            <div class="text-sm">{{ $user->ville ?? 'Non renseigné' }}</div>
                                            @if($user->adresse)
                                                <div class="text-sm text-gray-500 mt-1">{{ $user->adresse }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Colonne droite : Infos spécifiques --}}
                        <div class="lg:col-span-2 space-y-6">
                            {{-- PROFESSEUR --}}
                            @if($professeurData)
                                <div class="border border-gray-100 rounded-xl p-6 bg-white shadow-sm">
                                    <h3 class="text-base font-bold text-gray-900 mb-5">
                                        📚 Informations Professeur
                                    </h3>
                                    
                                    <div class="space-y-4 mb-6">
                                        @if($professeurData->surnom)
                                            <div class="flex items-center gap-3">
                                                <span class="text-sm text-gray-500 w-32">Surnom:</span>
                                                <span class="text-sm font-medium text-gray-900">{{ $professeurData->surnom }}</span>
                                            </div>
                                        @endif
                                        
                                        @if($professeurData->niveau_etudes)
                                            <div class="flex items-center gap-3">
                                                <span class="text-sm text-gray-500 w-32">Niveau d'études:</span>
                                                <span class="text-sm font-medium text-gray-900">{{ $professeurData->niveau_etudes }}</span>
                                            </div>
                                        @endif
                                        
                                        @if($professeurData->CIN)
                                            <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-lg">
                                                <div class="flex items-center gap-3">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    <span class="text-sm font-medium text-gray-700">Document CIN</span>
                                                </div>
                                                <a href="{{ asset('storage/' . $professeurData->CIN) }}" 
                                                   target="_blank" 
                                                   class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                                    Voir
                                                </a>
                                            </div>
                                        @endif
                                        
                                        @if($professeurData->diplome)
                                            <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-lg">
                                                <div class="flex items-center gap-3">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    <span class="text-sm font-medium text-gray-700">Document Diplôme</span>
                                                </div>
                                                <a href="{{ asset('storage/' . $professeurData->diplome) }}" 
                                                   target="_blank" 
                                                   class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                                    Voir
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    @if($professeurData->biographie)
                                        <div class="py-4 border-t border-gray-100">
                                            <p class="text-sm font-semibold text-gray-900 mb-2">Biographie</p>
                                            <p class="text-sm text-gray-600 leading-relaxed">{{ $professeurData->biographie }}</p>
                                        </div>
                                    @endif

                                    @if($professeurData->matieres && count($professeurData->matieres) > 0)
                                        <div class="pt-4 border-t border-gray-100">
                                            <p class="text-sm font-semibold text-gray-900 mb-4">Matières enseignées</p>
                                            <div class="space-y-3">
                                                @foreach($professeurData->matieres as $matiere)
                                                    <div class="flex justify-between items-center py-3 px-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-900">{{ $matiere->nom_matiere }}</p>
                                                            <p class="text-xs text-gray-500 mt-0.5">📍 {{ $matiere->type_service }}</p>
                                                        </div>
                                                        <span class="text-base font-bold text-blue-600">{{ $matiere->prix_par_heure }} MAD</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- BABYSITTER --}}
                            @if($babysitterData)
                                <div class="border border-gray-100 rounded-xl p-6 bg-white shadow-sm">
                                    <h3 class="text-base font-bold text-gray-900 mb-5">
                                        👶 Informations Babysitter
                                    </h3>
                                    
                                    <div class="space-y-4 mb-6">
                                        <div class="flex items-center gap-3">
                                            <span class="text-sm text-gray-500 w-32">Tarif horaire:</span>
                                            <span class="text-base font-bold text-pink-600">{{ $babysitterData->prixHeure }} MAD/h</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-sm text-gray-500 w-32">Expérience:</span>
                                            <span class="text-sm font-medium text-gray-900">{{ $babysitterData->expAnnee ?? 0 }} années</span>
                                        </div>
                                        @if(!empty($babysitterData->langues))
                                            <div class="flex items-center gap-3">
                                                <span class="text-sm text-gray-500 w-32">Langues:</span>
                                                <span class="text-sm font-medium text-gray-900">
                                                    {{ is_array($babysitterData->langues) ? implode(', ', $babysitterData->langues) : $babysitterData->langues }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    @if($babysitterData->description)
                                        <div class="bg-white p-4 rounded-lg border border-gray-200 mb-6">
                                            <p class="text-xs font-medium text-gray-500 uppercase mb-2">Description</p>
                                            <p class="text-sm text-gray-700 leading-relaxed">{{ $babysitterData->description }}</p>
                                        </div>
                                    @endif

                                    {{-- Caractéristiques en grid --}}
                                    <div class="grid grid-cols-2 gap-3 mb-6">
                                        <div class="bg-white p-3 rounded-lg border border-gray-200 flex items-center gap-2">
                                            <span class="text-2xl">{{ $babysitterData->estFumeur ? '🚬' : '🚭' }}</span>
                                            <span class="text-xs font-medium text-gray-700">{{ $babysitterData->estFumeur ? 'Fumeur' : 'Non fumeur' }}</span>
                                        </div>
                                        <div class="bg-white p-3 rounded-lg border border-gray-200 flex items-center gap-2">
                                            <span class="text-2xl">{{ $babysitterData->mobilite ? '🚗' : '🚶' }}</span>
                                            <span class="text-xs font-medium text-gray-700">{{ $babysitterData->mobilite ? 'Mobile' : 'Non mobile' }}</span>
                                        </div>
                                        <div class="bg-white p-3 rounded-lg border border-gray-200 flex items-center gap-2">
                                            <span class="text-2xl">👶</span>
                                            <span class="text-xs font-medium text-gray-700">{{ $babysitterData->possedeEnfant ? 'A des enfants' : 'Pas d\'enfants' }}</span>
                                        </div>
                                        <div class="bg-white p-3 rounded-lg border border-gray-200 flex items-center gap-2">
                                            <span class="text-2xl">{{ $babysitterData->permisConduite ? '🚗' : '❌' }}</span>
                                            <span class="text-xs font-medium text-gray-700">{{ $babysitterData->permisConduite ? 'Permis' : 'Pas de permis' }}</span>
                                        </div>
                                    </div>

                                    @if($babysitterData->superpouvoirs && count($babysitterData->superpouvoirs) > 0)
                                        <div class="pt-4 border-t border-gray-100">
                                            <p class="text-sm font-semibold text-gray-900 mb-3">✨ Compétences spéciales</p>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($babysitterData->superpouvoirs as $pouvoir)
                                                    <span class="px-3 py-1.5 bg-purple-50 text-purple-700 text-xs font-medium rounded-full border border-purple-100">{{ $pouvoir }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if($babysitterData->formations && count($babysitterData->formations) > 0)
                                        <div class="pt-4 border-t border-gray-100">
                                            <p class="text-sm font-semibold text-gray-900 mb-3">🎓 Formations</p>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($babysitterData->formations as $formation)
                                                    <span class="px-3 py-1.5 bg-green-50 text-green-700 text-xs font-medium rounded-full border border-green-100">{{ $formation }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if($babysitterData->categories && count($babysitterData->categories) > 0)
                                        <div class="pt-4 border-t border-gray-100">
                                            <p class="text-sm font-semibold text-gray-900 mb-3">👦 Tranches d'âge</p>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($babysitterData->categories as $categorie)
                                                    <span class="px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-medium rounded-full border border-blue-100">{{ $categorie }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if(isset($babysitterData->documents) && $babysitterData->documents->count() > 0)
                                        <div class="pt-4 border-t border-gray-100">
                                            <p class="text-sm font-semibold text-gray-900 mb-3">📂 Documents fournis</p>
                                            <div class="space-y-2">
                                                @foreach($babysitterData->documents as $doc)
                                                    <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-lg">
                                                        <span class="text-sm font-medium text-gray-800">{{ $doc['label'] }}</span>
                                                        <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Voir</a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- PETKEEPER --}}
                            @if($petkeeperData)
                                <div class="border border-gray-100 rounded-xl p-6 bg-white shadow-sm">
                                    <h3 class="text-base font-bold text-gray-900 mb-5">
                                        🐾 Informations Gardien d'animaux
                                    </h3>
                                    
                                    <div class="space-y-4 mb-6">
                                        <div class="flex items-center gap-3">
                                            <span class="text-sm text-gray-500 w-32">Spécialité:</span>
                                            <span class="text-sm font-medium text-gray-900">{{ $petkeeperData->specialite }}</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-sm text-gray-500 w-32">Services demandés:</span>
                                            <span class="text-sm font-medium text-gray-900">{{ $petkeeperData->nombres_services_demandes }}</span>
                                        </div>
                                    </div>

                                    @if(isset($petkeeperData->documents) && $petkeeperData->documents->count() > 0)
                                        <div class="pt-4 border-t border-gray-100">
                                            <p class="text-sm font-semibold text-gray-900 mb-4">📂 Documents fournis</p>
                                            <div class="space-y-3">
                                                @foreach($petkeeperData->documents as $doc)
                                                    <div class="py-3 px-4 bg-gray-50 rounded-lg flex items-center justify-between">
                                                        <span class="text-sm font-medium text-gray-900">{{ $doc['label'] }}</span>
                                                        <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Voir</a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @php
                                        $otherCerts = $petkeeperData->otherCertifications ?? $petkeeperData->certifications;
                                    @endphp

                                    @if($otherCerts && count($otherCerts) > 0)
                                        <div class="pt-4 border-t border-gray-100">
                                            <p class="text-sm font-semibold text-gray-900 mb-4">🏆 Autres certifications</p>
                                            <div class="space-y-3">
                                                @foreach($otherCerts as $cert)
                                                    <div class="py-3 px-4 bg-gray-50 rounded-lg flex items-center justify-between">
                                                        <p class="text-sm font-medium text-gray-900">{{ $cert->certification }}</p>
                                                        @if(!empty($cert->document))
                                                            <a href="{{ asset('storage/' . $cert->document) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Voir</a>
                                                        @else
                                                            <span class="text-xs text-gray-500">Aucun fichier</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Boutons d'action en bas de la page --}}
                @if($offre && $offre->statut === 'EN_ATTENTE')
                    <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end gap-3 px-8 pb-8">
                        <button 
                            wire:click="openRefusalModal"
                            class="px-6 py-2.5 bg-white text-red-600 border border-red-300 rounded-lg hover:bg-red-50 transition-colors font-medium text-sm"
                        >
                            Refuser
                        </button>
                        <button 
                            wire:click="approveIntervenant"
                            class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium text-sm shadow-sm"
                        >
                            Approuver
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal de refus --}}
    @if($showRefusalModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" wire:click.self="closeRefusalModal">
            <div class="bg-white rounded-2xl max-w-md w-full shadow-xl">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Motif du refus</h3>
                    <textarea 
                        wire:model="refusalReason"
                        rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                        placeholder="Expliquez la raison du refus..."
                    ></textarea>
                    @error('refusalReason')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-2xl">
                    <button 
                        wire:click="closeRefusalModal"
                        class="px-5 py-2.5 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium text-sm"
                    >
                        Annuler
                    </button>
                    <button 
                        wire:click="refuseIntervenant"
                        class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium text-sm shadow-sm"
                    >
                        Confirmer le refus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>