<div class="flex min-h-screen bg-gray-50">
    {{-- Sidebar --}}
    @livewire('shared.admin.admin-sidebar', ['currentPage' => 'admin-reclamations'])

    {{-- Main Content --}}
    <div class="flex-1 overflow-auto">
        <div class="p-8 max-w-5xl mx-auto">
            {{-- Header avec bouton retour --}}
            <div class="mb-8">
                <a href="{{ route('admin.reclamations') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour aux réclamations
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Détails de la réclamation</h1>
            </div>

            {{-- Informations principales --}}
            <div class="bg-white rounded-xl p-8 shadow-sm border border-gray-100 mb-6">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $reclamation->sujet }}</h2>
                        
                        {{-- Badges --}}
                        <div class="flex items-center gap-2 mb-4 flex-wrap">
                            {{-- Service Badge --}}
                            <span class="inline-block px-3 py-1 text-xs font-medium rounded-full
                                {{ $serviceType === 'Soutien Scolaire' ? 'bg-blue-50 text-blue-700' : '' }}
                                {{ $serviceType === 'Babysitting' ? 'bg-pink-50 text-pink-700' : '' }}
                                {{ $serviceType === 'Pet Keeping' || $serviceType === 'Garde d\'animaux' ? 'bg-green-50 text-green-700' : '' }}
                                {{ $serviceType === 'Non spécifié' ? 'bg-gray-50 text-gray-700' : '' }}
                            ">
                                {{ $serviceType }}
                            </span>

                            {{-- Status Badge --}}
                            @if($reclamation->statut === 'resolue')
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                    ✓ Résolue
                                </span>
                            @else
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">
                                    ⏱ En attente
                                </span>
                            @endif

                            {{-- Priority Badge --}}
                            @if($reclamation->priorite === 'urgente')
                                <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">
                                    ⚠ Urgente
                                </span>
                            @elseif($reclamation->priorite === 'moyenne')
                                <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-semibold rounded-full">
                                    ◉ Moyenne
                                </span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full">
                                    ○ Faible
                                </span>
                            @endif
                        </div>

                        {{-- Date --}}
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Créée le {{ \Carbon\Carbon::parse($reclamation->dateCreation)->format('d M Y à H:i') }}</span>
                        </div>
                    </div>

                    {{-- Bouton traiter --}}
                    @if($reclamation->statut !== 'resolue')
                        <a 
                            href="{{ route('admin.reclamations.traiter', $reclamation->idReclamation) }}" 
                            class="ml-4 px-6 py-3 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors shadow-sm flex items-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Répondre par email
                        </a>
                    @endif
                </div>

                {{-- Feedback associé --}}
                @if($reclamation->feedback)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-5 mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-blue-900 mb-2">Feedback associé</h3>
                                @if($reclamation->feedback->commentaire)
                                    <p class="text-sm text-gray-700 mb-3">{{ $reclamation->feedback->commentaire }}</p>
                                @endif
                                
                                {{-- Notes du feedback --}}
                                <div class="grid grid-cols-2 md:grid-cols-5 gap-3 text-xs">
                                    @if($reclamation->feedback->credibilite)
                                        <div class="bg-white rounded px-2 py-1">
                                            <span class="text-gray-500">Crédibilité:</span>
                                            <span class="font-semibold text-gray-900">{{ $reclamation->feedback->credibilite }}/5</span>
                                        </div>
                                    @endif
                                    @if($reclamation->feedback->sympathie)
                                        <div class="bg-white rounded px-2 py-1">
                                            <span class="text-gray-500">Sympathie:</span>
                                            <span class="font-semibold text-gray-900">{{ $reclamation->feedback->sympathie }}/5</span>
                                        </div>
                                    @endif
                                    @if($reclamation->feedback->ponctualite)
                                        <div class="bg-white rounded px-2 py-1">
                                            <span class="text-gray-500">Ponctualité:</span>
                                            <span class="font-semibold text-gray-900">{{ $reclamation->feedback->ponctualite }}/5</span>
                                        </div>
                                    @endif
                                    @if($reclamation->feedback->proprete)
                                        <div class="bg-white rounded px-2 py-1">
                                            <span class="text-gray-500">Propreté:</span>
                                            <span class="font-semibold text-gray-900">{{ $reclamation->feedback->proprete }}/5</span>
                                        </div>
                                    @endif
                                    @if($reclamation->feedback->qualiteTravail)
                                        <div class="bg-white rounded px-2 py-1">
                                            <span class="text-gray-500">Qualité:</span>
                                            <span class="font-semibold text-gray-900">{{ $reclamation->feedback->qualiteTravail }}/5</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Parties impliquées --}}
                <div class="grid grid-cols-2 gap-6 mb-6 pb-6 border-b border-gray-200">
                    {{-- Auteur de la réclamation --}}
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase mb-3">Réclamation par</h3>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr($reclamation->auteur->prenom ?? 'U', 0, 1) }}{{ substr($reclamation->auteur->nom ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">
                                    {{ $reclamation->auteur->prenom ?? '' }} {{ $reclamation->auteur->nom ?? '' }}
                                </p>
                                <p class="text-sm text-gray-600">{{ $reclamation->auteur->email ?? '' }}</p>
                            </div>
                        </div>
                        <span class="inline-block px-3 py-1 text-xs font-medium rounded-full
                            {{ $auteurRole === 'Client' ? 'bg-purple-100 text-purple-700' : 'bg-indigo-100 text-indigo-700' }}
                        ">
                            {{ $auteurRole }}
                        </span>
                    </div>

                    {{-- Cible de la réclamation --}}
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase mb-3">Réclamation contre</h3>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr($reclamation->cible->prenom ?? 'U', 0, 1) }}{{ substr($reclamation->cible->nom ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">
                                    {{ $reclamation->cible->prenom ?? '' }} {{ $reclamation->cible->nom ?? '' }}
                                </p>
                                <p class="text-sm text-gray-600">{{ $reclamation->cible->email ?? '' }}</p>
                            </div>
                        </div>
                        <span class="inline-block px-3 py-1 text-xs font-medium rounded-full
                            {{ $cibleRole === 'Client' ? 'bg-purple-100 text-purple-700' : 'bg-indigo-100 text-indigo-700' }}
                        ">
                            {{ $cibleRole }}
                        </span>
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Description de la réclamation</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $reclamation->description }}</p>
                    </div>
                </div>

                {{-- Preuves si disponibles --}}
                @if($reclamation->preuves)
                    <div class="mt-6">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Preuves jointes</h3>
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                            @php
                                $preuves = is_string($reclamation->preuves) ? json_decode($reclamation->preuves, true) : $reclamation->preuves;
                                if (!is_array($preuves)) {
                                    $preuves = [$reclamation->preuves];
                                }
                            @endphp
                            
                            <div class="space-y-3">
                                @foreach($preuves as $preuve)
                                    @php
                                        $extension = pathinfo($preuve, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                                        $isPdf = strtolower($extension) === 'pdf';
                                        $fileName = basename($preuve);
                                    @endphp
                                    
                                    <div class="flex items-center gap-3 bg-white rounded-lg p-3 hover:shadow-md transition-shadow">
                                        {{-- Icône selon le type de fichier --}}
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0
                                            {{ $isImage ? 'bg-blue-100' : ($isPdf ? 'bg-red-100' : 'bg-gray-100') }}
                                        ">
                                            @if($isImage)
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            @elseif($isPdf)
                                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        
                                        {{-- Nom du fichier --}}
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $fileName }}</p>
                                            <p class="text-xs text-gray-500">{{ strtoupper($extension) }}</p>
                                        </div>
                                        
                                        {{-- Boutons d'action --}}
<div class="flex gap-2">
    @if($isImage || $isPdf)
        {{-- Bouton Aperçu pour les images et PDFs --}}
        <button 
            onclick="window.open('{{ asset('storage/reclamations/' . $fileName) }}', '_blank')"
            class="px-3 py-2 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-1"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
            {{ $isPdf ? 'Ouvrir' : 'Aperçu' }}
        </button>
    @endif
    
    {{-- Bouton Télécharger --}}
    <a 
        href="{{ asset('storage/reclamations/' . $fileName) }}" 
        download
        class="px-3 py-2 bg-gray-600 text-white text-xs font-medium rounded-lg hover:bg-gray-700 transition-colors flex items-center gap-1"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
        </svg>
        Télécharger
    </a>
</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Message de succès --}}
            @if (session()->has('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-semibold text-green-900">Succès!</h3>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>