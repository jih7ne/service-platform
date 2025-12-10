<div class="min-h-screen bg-[#F7F7F7]">
    <!-- Header -->
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 mb-4 text-sm font-semibold text-gray-500">
                <a href="/" wire:navigate class="hover:text-[#B82E6E] transition-colors">
                    Accueil
                </a>
                <span>›</span>
                <a href="/services" wire:navigate class="hover:text-[#B82E6E] transition-colors">
                    Services
                </a>
                <span>›</span>
                <span class="text-[#B82E6E] font-bold">Babysitting</span>
            </div>

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-4xl mb-2 text-black font-extrabold">
                        Trouver une Babysitter
                    </h1>
                    <p class="text-lg text-[#3a3a3a] font-medium">
                        6 babysitters disponibles à Casablanca
                    </p>
                </div>
                <a href="/services" wire:navigate class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-bold">
                    ← Retour
                </a>
            </div>

            <!-- Search Bar -->
            <div class="flex gap-4">
                <div class="flex-1 relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input
                        type="text"
                        placeholder="Rechercher par nom, quartier..."
                        class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#B82E6E] focus:border-transparent font-medium"
                    />
                </div>
                <button
                    onclick="toggleFilters()"
                    class="px-6 py-4 rounded-xl flex items-center gap-2 transition-all font-bold bg-white border border-gray-200 text-gray-700 hover:bg-gray-50"
                    id="filterButton"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path>
                    </svg>
                    Filtres
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex gap-8">
            <!-- Filters Sidebar -->
            <div class="w-80 flex-shrink-0 hidden" id="filtersSidebar">
                <div class="bg-white rounded-2xl p-6 border border-gray-100 sticky top-8" style="box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08)">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl text-black font-extrabold">
                            Filtres
                        </h3>
                        <button
                            onclick="clearFilters()"
                            class="text-sm text-red-500 hover:text-red-600 font-bold"
                        >
                            Effacer tout
                        </button>
                    </div>

                    <div class="space-y-6">
                        <!-- Ville -->
                        <div>
                            <label class="block text-sm mb-3 text-[#0a0a0a] font-bold">
                                Ville
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#B82E6E] font-semibold">
                                <option value="Casablanca">Casablanca</option>
                                <option value="Rabat">Rabat</option>
                                <option value="Marrakech">Marrakech</option>
                                <option value="Tanger">Tanger</option>
                            </select>
                        </div>

                        <!-- Prix -->
                        <div>
                            <label class="block text-sm mb-3 text-[#0a0a0a] font-bold">
                                Budget horaire
                            </label>
                            <div class="space-y-3">
                                <input
                                    type="range"
                                    min="30"
                                    max="150"
                                    value="150"
                                    class="w-full"
                                    id="priceRange"
                                    oninput="updatePriceDisplay(this.value)"
                                />
                                <div class="flex items-center justify-between">
                                    <span class="text-[#B82E6E] font-bold">30 DH</span>
                                    <span class="text-[#B82E6E] font-bold" id="maxPrice">150 DH</span>
                                </div>
                            </div>
                        </div>

                        <!-- Caractéristiques -->
                        <div>
                            <label class="block text-sm mb-3 text-[#0a0a0a] font-bold">
                                Caractéristiques
                            </label>
                            <div class="space-y-3">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" class="w-5 h-5 text-[#B82E6E] rounded" style="accent-color: #B82E6E" />
                                    <span class="text-[#2a2a2a] font-semibold">Profil vérifié</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" class="w-5 h-5 text-[#B82E6E] rounded" style="accent-color: #B82E6E" />
                                    <span class="text-[#2a2a2a] font-semibold">Non-fumeur</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" class="w-5 h-5 text-[#B82E6E] rounded" style="accent-color: #B82E6E" />
                                    <span class="text-[#2a2a2a] font-semibold">Possède un permis</span>
                                </label>
                            </div>
                        </div>

                        <!-- Services -->
                        <div>
                            <label class="block text-sm mb-3 text-[#0a0a0a] font-bold">
                                Services proposés
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @php
                                $services = ['Cuisine', 'Tâches ménagères', 'Aide aux devoirs', 'Lecture', 'Musique', 'Jeux créatifs', 'Dessin', 'Travaux manuels'];
                                @endphp
                                @foreach($services as $service)
                                <button
                                    onclick="toggleService(this)"
                                    class="px-4 py-2 rounded-xl transition-all font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200"
                                >
                                    {{ $service }}
                                </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Expérience -->
                        <div>
                            <label class="block text-sm mb-3 text-[#0a0a0a] font-bold">
                                Expérience minimum
                            </label>
                            <select class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#B82E6E] font-semibold">
                                <option value="0">Tous</option>
                                <option value="1">1 an minimum</option>
                                <option value="3">3 ans minimum</option>
                                <option value="5">5 ans minimum</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div class="flex-1">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                    $babysitters = [
                        [
                            'id' => 1,
                            'nom' => 'Alami',
                            'prenom' => 'Fatima',
                            'photo' => 'https://images.unsplash.com/photo-1675526607070-f5cbd71dde92?w=400',
                            'ville' => 'Casablanca',
                            'quartier' => 'Maârif',
                            'rating' => 4.9,
                            'reviewCount' => 120,
                            'prixHoraire' => 60,
                            'services' => ['Cuisine', 'Aide aux devoirs']
                        ],
                        [
                            'id' => 2,
                            'nom' => 'Bennani',
                            'prenom' => 'Khadija',
                            'photo' => 'https://images.unsplash.com/photo-1758525862933-73398157e165?w=400',
                            'ville' => 'Casablanca',
                            'quartier' => 'Agdal',
                            'rating' => 4.8,
                            'reviewCount' => 85,
                            'prixHoraire' => 55,
                            'services' => ['Tâches ménagères', 'Aide aux devoirs']
                        ],
                        [
                            'id' => 3,
                            'nom' => 'El Fassi',
                            'prenom' => 'Amina',
                            'photo' => 'https://images.unsplash.com/photo-1758600587728-9bde755354ad?w=400',
                            'ville' => 'Casablanca',
                            'quartier' => 'Anfa',
                            'rating' => 4.9,
                            'reviewCount' => 95,
                            'prixHoraire' => 65,
                            'services' => ['Musique', 'Jeux créatifs', 'Aide aux devoirs']
                        ],
                        [
                            'id' => 4,
                            'nom' => 'Idrissi',
                            'prenom' => 'Salma',
                            'photo' => 'https://images.unsplash.com/photo-1676552055618-22ec8cde399a?w=400',
                            'ville' => 'Casablanca',
                            'quartier' => 'CIL',
                            'rating' => 4.7,
                            'reviewCount' => 67,
                            'prixHoraire' => 50,
                            'services' => ['Dessin', 'Travaux manuels', 'Cuisine']
                        ],
                        [
                            'id' => 5,
                            'nom' => 'Tazi',
                            'prenom' => 'Nour',
                            'photo' => 'https://images.unsplash.com/photo-1675526607070-f5cbd71dde92?w=400',
                            'ville' => 'Casablanca',
                            'quartier' => 'Mers Sultan',
                            'rating' => 4.8,
                            'reviewCount' => 102,
                            'prixHoraire' => 58,
                            'services' => ['Cuisine', 'Tâches ménagères', 'Aide aux devoirs']
                        ],
                        [
                            'id' => 6,
                            'nom' => 'Mansouri',
                            'prenom' => 'Yasmine',
                            'photo' => 'https://images.unsplash.com/photo-1758525862933-73398157e165?w=400',
                            'ville' => 'Casablanca',
                            'quartier' => 'Bourgogne',
                            'rating' => 4.9,
                            'reviewCount' => 134,
                            'prixHoraire' => 70,
                            'services' => ['Aide aux devoirs', 'Musique', 'Cuisine']
                        ]
                    ];
                    @endphp

                    @foreach($babysitters as $babysitter)
                    <a href="/babysitter-profile/{{ $babysitter['id'] }}" wire:navigate 
                       class="bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl transition-all group block"
                       style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                        <!-- Image -->
                        <div class="relative h-56 overflow-hidden bg-gray-100">
                            <img
                                src="{{ $babysitter['photo'] }}"
                                alt="{{ $babysitter['prenom'] }} {{ $babysitter['nom'] }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            />
                        </div>

                        <!-- Content -->
                        <div class="p-5">
                            <h3 class="text-xl mb-2 text-black font-extrabold">
                                {{ $babysitter['prenom'] }} {{ substr($babysitter['nom'], 0, 1) }}.
                            </h3>
                            
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-4 h-4 text-[#B82E6E]" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                </svg>
                                <span class="text-sm text-[#3a3a3a] font-semibold">
                                    {{ $babysitter['quartier'] }}, {{ $babysitter['ville'] }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2 mb-4">
                                <div class="flex items-center">
                                    @for($i = 0; $i < 5; $i++)
                                    <svg class="w-4 h-4 {{ $i < floor($babysitter['rating']) ? 'text-[#C78500] fill-current' : 'text-gray-300' }}" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                    @endfor
                                </div>
                                <span class="text-black font-bold">{{ $babysitter['rating'] }}</span>
                                <span class="text-sm text-gray-500 font-medium">({{ $babysitter['reviewCount'] }} avis)</span>
                            </div>

                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach(array_slice($babysitter['services'], 0, 2) as $service)
                                <span class="px-3 py-1 bg-[#F9E0ED] rounded-lg text-sm text-[#B82E6E] font-semibold">
                                    {{ $service }}
                                </span>
                                @endforeach
                                @if(count($babysitter['services']) > 2)
                                <span class="px-3 py-1 bg-gray-100 rounded-lg text-sm text-gray-500 font-semibold">
                                    +{{ count($babysitter['services']) - 2 }}
                                </span>
                                @endif
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div>
                                    <span class="text-sm text-gray-500 font-medium">À partir de</span>
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-2xl text-[#B82E6E] font-extrabold">
                                            {{ $babysitter['prixHoraire'] }}
                                        </span>
                                        <span class="text-sm text-gray-500 font-semibold">DH/h</span>
                                    </div>
                                </div>
                                <span class="px-5 py-2.5 bg-[#B82E6E] text-white rounded-xl group-hover:bg-[#A02860] transition-all flex items-center gap-2 font-bold">
                                    Voir profil
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleFilters() {
            const sidebar = document.getElementById('filtersSidebar');
            const button = document.getElementById('filterButton');
            
            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
                button.classList.remove('bg-white', 'border-gray-200', 'text-gray-700');
                button.classList.add('bg-[#B82E6E]', 'text-white');
            } else {
                sidebar.classList.add('hidden');
                button.classList.add('bg-white', 'border-gray-200', 'text-gray-700');
                button.classList.remove('bg-[#B82E6E]', 'text-white');
            }
        }

        function updatePriceDisplay(value) {
            document.getElementById('maxPrice').textContent = value + ' DH';
        }

        function toggleService(button) {
            if (button.classList.contains('bg-[#B82E6E]')) {
                button.classList.remove('bg-[#B82E6E]', 'text-white');
                button.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            } else {
                button.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                button.classList.add('bg-[#B82E6E]', 'text-white');
            }
        }

        function clearFilters() {
            // Reset price range
            document.getElementById('priceRange').value = 150;
            updatePriceDisplay(150);
            
            // Uncheck all checkboxes
            document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Reset service buttons
            document.querySelectorAll('#filtersSidebar button').forEach(button => {
                if (button.classList.contains('bg-[#B82E6E]')) {
                    button.classList.remove('bg-[#B82E6E]', 'text-white');
                    button.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                }
            });
            
            // Reset select elements
            document.querySelectorAll('select').forEach(select => {
                select.selectedIndex = 0;
            });
        }
    </script>
</div>