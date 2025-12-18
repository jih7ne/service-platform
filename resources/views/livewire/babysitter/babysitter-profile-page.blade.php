@php
    $user = $babysitter->intervenant->utilisateur;
    $age = \Carbon\Carbon::parse($user->dateNaissance)->age;
    $address = $user->localisations->first();
    $ville = $address ? $address->ville : 'Non spécifié';
    $quartier = ''; // Masquer l'adresse exacte pour la confidentialité
    $rating = $user->note ?? 0;
    $reviewCount = $user->nbrAvis ?? 0;
    $photoUrl = $user->photo 
        ? '/storage/' . $user->photo 
        : ($babysitter->intervenant->photo 
            ? '/storage/' . $babysitter->intervenant->photo 
            : 'https://ui-avatars.com/api/?name=' . urlencode($user->prenom . ' ' . $user->nom));


    $dayNames = [
        'lundi' => 'Lundi',
        'mardi' => 'Mardi',
        'mercredi' => 'Mercredi',
        'jeudi' => 'Jeudi',
        'vendredi' => 'Vendredi',
        'samedi' => 'Samedi',
        'dimanche' => 'Dimanche'
    ];
@endphp

<div class="min-h-screen bg-[#F7F7F7]">
    <livewire:shared.header-babysitting />
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <a href="/liste-babysitter" wire:navigate
                class="flex items-center gap-2 text-gray-600 hover:text-gray-900 font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour à la recherche
            </a>
        </div>
    </div>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex items-start gap-8">
                <div class="relative flex-shrink-0">
                    <div class="w-40 h-40 rounded-3xl overflow-hidden border-4 border-white"
                        style="box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15)">
                        <img src="{{ $photoUrl }}" 
                            alt="{{ $user->prenom }} {{ $user->nom }}"
                            class="w-full h-full object-cover" 
                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->prenom . ' ' . $user->nom) }}&size=160&background=B82E6E&color=fff'" />
                    </div>
                </div>

                <div class="flex-1">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h1 class="text-4xl mb-2 text-black font-extrabold">{{ $user->prenom }} {{ $user->nom }}
                            </h1>
                            <div class="flex items-center gap-4 mb-3">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-[#B82E6E]" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                    </svg>
                                    <span class="text-lg text-[#3a3a3a] font-semibold">{{ $ville }}, Maroc</span>
                                </div>
                                <span
                                    class="px-4 py-1.5 bg-[#F9E0ED] rounded-full text-sm text-[#B82E6E] font-bold">{{ $age }}
                                    ans</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="flex items-center">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="w-5 h-5 {{ $i < floor($rating) ? 'text-[#C78500] fill-current' : 'text-gray-300' }}"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-xl text-black font-extrabold">{{ number_format($rating, 1) }}</span>
                                <span class="text-gray-500 font-semibold">({{ $reviewCount }} avis)</span>
                            </div>
                        </div>
                        @auth
                        <a href="/babysitter-booking/{{ $babysitter->idBabysitter }}" wire:navigate
                            class="px-8 py-3 bg-[#B82E6E] text-white rounded-xl hover:bg-[#A02860] transition-all font-bold"
                            style="box-shadow: 0 4px 20px rgba(184, 46, 110, 0.3)">
                            Demander un service
                        </a>
                        @else
                        <div class="px-8 py-3 bg-gray-300 text-gray-600 rounded-xl font-bold text-center cursor-not-allowed">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span>Connectez-vous pour demander un service</span>
                            </div>
                        </div>
                        <a href="/connexion" class="px-8 py-3 bg-[#B82E6E] text-white rounded-xl hover:bg-[#A02860] transition-all font-bold text-center block mt-2">
                            Se connecter
                        </a>
                        @endauth
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-[#F7F7F7] rounded-xl p-4">
                            <p class="text-sm mb-1 text-gray-500 font-semibold">Expérience</p>
                            <p class="text-2xl text-[#B82E6E] font-extrabold">{{ $babysitter->expAnnee }} ans</p>
                        </div>
                        <div class="bg-[#F7F7F7] rounded-xl p-4">
                            <p class="text-sm mb-1 text-gray-500 font-semibold">Tarif horaire</p>
                            <p class="text-2xl text-[#B82E6E] font-extrabold">{{ $babysitter->prixHeure }} DH</p>
                        </div>
                        <div class="bg-[#F7F7F7] rounded-xl p-4">
                            <p class="text-sm mb-1 text-gray-500 font-semibold">Certifications</p>
                            <p class="text-2xl text-[#B82E6E] font-extrabold">{{ $babysitter->formations->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column (Main Info) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- About -->
                <div class="bg-white rounded-2xl p-8 border border-gray-100"
                    style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                    <h2 class="text-2xl mb-4 text-black font-extrabold">À propos</h2>
                    <p class="text-lg leading-relaxed text-[#3a3a3a] font-medium">{{ $babysitter->description }}</p>
                </div>

                <!-- Characteristics -->
                <div class="bg-white rounded-2xl p-8 border border-gray-100"
                    style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                    <h2 class="text-2xl mb-6 text-black font-extrabold">Caractéristiques</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-[#0a0a0a] font-semibold">Compte Vérifié</span>
                            </div>
                            <span
                                class="px-3 py-1 bg-green-600 text-white rounded-lg text-sm font-bold">{{ $babysitter->intervenant->statut === 'VALIDE' ? 'Oui' : 'Non' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-[#F7F7F7] rounded-xl">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                                <span class="text-[#0a0a0a] font-semibold">Fumeur</span>
                            </div>
                            <span
                                class="px-3 py-1 bg-gray-200 text-gray-800 rounded-lg text-sm font-bold">{{ $babysitter->estFumeur ? 'Oui' : 'Non' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-[#F7F7F7] rounded-xl">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#B82E6E]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-[#0a0a0a] font-semibold">Permis de conduire</span>
                            </div>
                            <span
                                class="px-3 py-1 bg-[#B82E6E] text-white rounded-lg text-sm font-bold">{{ $babysitter->permisConduite ? 'Oui' : 'Non' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-[#F7F7F7] rounded-xl">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#B82E6E]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                                <span class="text-[#0a0a0a] font-semibold">A des enfants</span>
                            </div>
                            <span
                                class="px-3 py-1 bg-[#B82E6E] text-white rounded-lg text-sm font-bold">{{ $babysitter->possedeEnfant ? 'Oui' : 'Non' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Languages -->
                @if($babysitter->langues && count($babysitter->langues) > 0)
                    <div class="bg-white rounded-2xl p-8 border border-gray-100"
                        style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                        <h2 class="text-2xl mb-4 text-black font-extrabold">Langues parlées</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($babysitter->langues as $langue)
                                <span class="px-4 py-2 bg-[#F9E0ED] rounded-xl text-[#B82E6E] font-bold">{{ $langue }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                {{-- Maladies / Conditions médicales --}}
                @if(!empty($maladies) && count($maladies) > 0)
                    <div class="bg-white rounded-2xl p-8 border border-gray-100" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                        <h2 class="text-2xl mb-4 text-black font-extrabold">Informations médicales</h2>
                        <div class="space-y-2">
                            @foreach($maladies as $maladie)
                                <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-xl">
                                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-blue-900 font-medium">{{ $maladie }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Expériences avec besoins spéciaux --}}
                @if($experiencesBesoins->count() > 0)
                    <div class="bg-white rounded-2xl p-8 border border-gray-100" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                        <h2 class="text-2xl mb-6 text-black font-extrabold">Expérience avec besoins spéciaux</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($experiencesBesoins as $exp)
                                <div class="flex items-center gap-3 p-4 bg-purple-50 rounded-xl">
                                    <svg class="w-6 h-6 text-purple-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-purple-900 font-semibold">{{ $exp->experience }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Formations -->
                @if($babysitter->formations->count() > 0)
                    <div class="bg-white rounded-2xl p-8 border border-gray-100"
                        style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                        <h2 class="text-2xl mb-6 text-black font-extrabold">Formations & Certifications</h2>
                        <div class="space-y-4">
                            @foreach($babysitter->formations as $cert)
                                <div class="flex items-start gap-4 p-4 bg-[#F7F7F7] rounded-xl">
                                    <div
                                        class="w-12 h-12 bg-[#B82E6E] rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg mb-1 text-black font-bold">{{ $cert->formation }}</h3>
                                        <p class="text-gray-500 font-semibold">Certifié</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Services / Categories Children -->
                @php $categories = \App\Models\Babysitting\CategorieEnfant::join('choisir_categories', 'categorie_enfants.idCategorie', '=', 'choisir_categories.idCategorie')->where('choisir_categories.idBabysitter', $babysitter->idBabysitter)->get(); @endphp
                @if($categories->count() > 0)
                    <div class="bg-white rounded-2xl p-8 border border-gray-100"
                        style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                        <h2 class="text-2xl mb-6 text-black font-extrabold">Catégories d'enfants</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($categories as $cat)
                                <div class="p-6 bg-[#F7F7F7] rounded-xl text-center">
                                    <div class="text-4xl mb-3">👶</div>
                                    <h3 class="text-black font-bold">{{ $cat->categorie }}</h3>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Superpowers -->
                @if($babysitter->superpouvoirs->count() > 0)
                    <div class="bg-white rounded-2xl p-8 border border-gray-100"
                        style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                        <h2 class="text-2xl mb-6 text-black font-extrabold">Mes superpouvoirs</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($babysitter->superpouvoirs as $power)
                                <div
                                    class="p-6 bg-[#F9E0ED] rounded-xl text-center hover:shadow-lg transition-all cursor-pointer">
                                    <div class="text-4xl mb-3">
                                        @if(str_contains($power->superpouvoir, 'lecture')) 📖
                                        @elseif(str_contains($power->superpouvoir, 'Musique')) 🎵
                                        @elseif(str_contains($power->superpouvoir, 'Jeux')) 🎨
                                        @elseif(str_contains($power->superpouvoir, 'Dessin')) ✏️
                                        @elseif(str_contains($power->superpouvoir, 'manuels')) 🛠️
                                        @elseif(str_contains($power->superpouvoir, 'Cuisine')) 🍳
                                        @elseif(str_contains($power->superpouvoir, 'devoirs')) 📚
                                        @elseif(str_contains($power->superpouvoir, 'ménagères')) 🧹
                                        @else ✨
                                        @endif
                                    </div>
                                    <h3 class="text-sm text-[#B82E6E] font-bold">{{ $power->superpouvoir }}</h3>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Reviews -->
                <div class="bg-white rounded-2xl p-8 border border-gray-100"
                    style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                    <h2 class="text-2xl mb-6 text-black font-extrabold">Avis ({{ $reviewCount }})</h2>
                    <div class="space-y-6">
                        @forelse($reviews as $review)
                            <div class="p-6 bg-[#F7F7F7] rounded-xl">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200">
                                        <img src="{{ $review->auteur->photo ? asset('storage/' . $review->auteur->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($review->auteur->nom) }}"
                                            alt="{{ $review->auteur->nom }}" class="w-full h-full object-cover" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="text-black font-bold">{{ $review->auteur->prenom }}
                                                {{ $review->auteur->nom }}</h4>
                                            <span
                                                class="text-sm text-gray-500 font-medium">{{ \Carbon\Carbon::parse($review->dateCreation)->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex items-center mb-3">
                                            @for($i = 0; $i < 5; $i++)
                                                <svg class="w-4 h-4 {{ $i < $review->note ? 'text-[#C78500] fill-current' : 'text-gray-300' }}"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                                </svg>
                                            @endfor
                                        </div>
                                        <p class="mb-3 text-[#3a3a3a] font-medium">{{ $review->commentaire }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Aucun avis pour le moment.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column (Sidebar) -->
            <div class="space-y-6">
                <!-- Location -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100"
                    style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                    <h2 class="text-xl mb-4 text-black font-extrabold">Emplacement</h2>
                    <div id="babysitter-profile-map" class="relative w-full h-64 rounded-xl overflow-hidden border-2 border-gray-100 mb-4"></div>
                    <div class="flex items-start gap-3 p-3 bg-[#F7F7F7] rounded-xl">
                        <svg class="w-5 h-5 text-[#B82E6E] flex-shrink-0 mt-0.5" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                        </svg>
                        <div>
                            <p class="text-black font-bold">{{ $ville }}, Maroc</p>
                            <p class="text-sm mt-1 text-gray-500 font-semibold">Zone d'intervention dans un rayon de 5
                                km</p>
                        </div>
                    </div>
                </div>

                <!-- Availability (Sticky) -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 sticky top-8"
                    style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06); max-height: calc(100vh - 4rem); overflow-y: auto">
                    <h2 class="text-xl mb-6 text-black font-extrabold">Disponibilités</h2>
                    <div class="space-y-3">
                        @foreach($dayNames as $key => $name)
                            @php
                                $slots = $availability[$key] ?? [];
                            @endphp
                            <div class="p-4 bg-[#F7F7F7] rounded-xl">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-sm text-black font-bold">{{ $name }}</h3>
                                    @if(count($slots) === 0)
                                        <span class="text-xs px-2 py-1 bg-gray-200 text-gray-600 rounded-lg font-semibold">Non
                                            disponible</span>
                                    @endif
                                </div>
                                @if(count($slots) > 0)
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        @foreach($slots as $slot)
                                            <div
                                                class="flex items-center gap-2 px-3 py-1.5 bg-white rounded-lg border border-[#B82E6E]">
                                                <svg class="w-4 h-4 text-[#B82E6E]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="text-xs text-[#B82E6E] font-bold">{{ $slot }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 p-3 bg-[#F9E0ED] rounded-xl">
                        <p class="text-xs text-center text-[#B82E6E] font-semibold">💡 Les disponibilités peuvent varier
                            selon les semaines</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
              integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
              crossorigin=""/>
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
                crossorigin=""></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Obtenir les données de localisation depuis le backend
                const mapData = @json($this->getMapData());
                
                // Centrer la carte sur les coordonnées de la babysitter
                const map = L.map('babysitter-profile-map').setView([mapData.latitude, mapData.longitude], 13);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
                
                // Ajouter un marqueur pour la position de la babysitter
                L.marker([mapData.latitude, mapData.longitude]).addTo(map)
                    .bindPopup('<strong>{{ $babysitter->prenom }} {{ $babysitter->nom }}</strong><br><small>' + mapData.address + '</small>')
                    .openPopup();
                
                // Ajuster la taille de la carte après le chargement
                setTimeout(() => map.invalidateSize(), 200);
            });
        </script>
    @endpush
</div>