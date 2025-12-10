@php
// Tous les babysitters disponibles
$allBabysitters = [
    1 => [
        'id' => 1,
        'nom' => 'Alami',
        'prenom' => 'Fatima',
        'age' => 32,
        'photo' => 'https://images.unsplash.com/photo-1675526607070-f5cbd71dde92?w=400',
        'rating' => 4.9,
        'reviewCount' => 120,
        'prixHoraire' => 60,
        'ville' => 'Casablanca',
        'quartier' => 'Maârif',
        'experience' => 8,
        'verified' => true,
        'fumeur' => false,
        'permis' => true,
        'mobilite' => true,
        'aDesEnfants' => true,
        'langues' => ['Arabe', 'Français'],
        'description' => 'Expérimentée et passionnée, je prends soin des enfants depuis 8 ans. Je crée un environnement sûr et stimulant pour leur développement. Formée aux premiers secours et diplômée en éducation de la petite enfance.',
        'certifications' => [
            ['nom' => 'Diplôme en Éducation de la Petite Enfance', 'annee' => '2016', 'organisme' => 'Institut Supérieur de Casablanca'],
            ['nom' => 'Formation Premiers Secours Pédiatriques', 'annee' => '2018', 'organisme' => 'Croissant Rouge Marocain']
        ],
        'services' => ['Cuisine', 'Aide aux devoirs'],
        'superpouvoirs' => ['Faire la lecture', 'Jeux créatifs', 'Dessin'],
        'availability' => [
            'lundi' => ['09:00-12:00', '14:00-18:00'], 'mardi' => ['09:00-12:00', '14:00-18:00'],
            'mercredi' => ['14:00-18:00'], 'jeudi' => ['09:00-12:00', '14:00-18:00'],
            'vendredi' => ['09:00-12:00'], 'samedi' => ['09:00-12:00', '14:00-18:00'], 'dimanche' => []
        ]
    ],
    2 => [
        'id' => 2, 'nom' => 'Bennani', 'prenom' => 'Khadija', 'age' => 28,
        'photo' => 'https://images.unsplash.com/photo-1758525862933-73398157e165?w=400',
        'rating' => 4.8, 'reviewCount' => 85, 'prixHoraire' => 55,
        'ville' => 'Casablanca', 'quartier' => 'Agdal', 'experience' => 5,
        'verified' => true, 'fumeur' => false, 'permis' => true, 'mobilite' => true, 'aDesEnfants' => false,
        'langues' => ['Arabe', 'Français', 'Anglais'],
        'description' => 'Passionnée par le monde de l\'enfance depuis toujours, je suis une babysitter dévouée avec 5 ans d\'expérience. J\'adore créer des activités ludiques et éducatives pour stimuler l\'imagination des enfants.',
        'certifications' => [
            ['nom' => 'Diplôme en Éducation de la Petite Enfance', 'annee' => '2019', 'organisme' => 'Institut Supérieur de Casablanca'],
            ['nom' => 'Formation Premiers Secours Pédiatriques', 'annee' => '2021', 'organisme' => 'Croissant Rouge Marocain'],
            ['nom' => 'Certificat Montessori', 'annee' => '2022', 'organisme' => 'AMI Maroc']
        ],
        'services' => ['Tâches ménagères', 'Aide aux devoirs'],
        'superpouvoirs' => ['Faire la lecture', 'Musique', 'Travaux manuels'],
        'availability' => [
            'lundi' => ['09:00-12:00', '14:00-17:00'], 'mardi' => ['09:00-12:00', '14:00-17:00'],
            'mercredi' => [], 'jeudi' => ['14:00-17:00', '17:00-20:00'],
            'vendredi' => ['09:00-12:00'], 'samedi' => ['09:00-12:00', '14:00-17:00', '18:00-21:00'],
            'dimanche' => ['18:00-21:00']
        ]
    ],
    3 => [
        'id' => 3, 'nom' => 'El Fassi', 'prenom' => 'Amina', 'age' => 35,
        'photo' => 'https://images.unsplash.com/photo-1758600587728-9bde755354ad?w=400',
        'rating' => 4.9, 'reviewCount' => 95, 'prixHoraire' => 65,
        'ville' => 'Casablanca', 'quartier' => 'Anfa', 'experience' => 10,
        'verified' => true, 'fumeur' => false, 'permis' => true, 'mobilite' => true, 'aDesEnfants' => true,
        'langues' => ['Arabe', 'Français', 'Anglais', 'Espagnol'],
        'description' => 'Avec 10 ans d\'expérience, je suis spécialisée dans l\'éveil musical et artistique des enfants. Je crée des activités stimulantes qui développent leur créativité et leur confiance.',
        'certifications' => [
            ['nom' => 'Diplôme en Éducation Musicale', 'annee' => '2014', 'organisme' => 'Conservatoire de Casablanca'],
            ['nom' => 'Certificat Montessori', 'annee' => '2016', 'organisme' => 'AMI Maroc'],
            ['nom' => 'Formation Premiers Secours', 'annee' => '2020', 'organisme' => 'Croissant Rouge']
        ],
        'services' => ['Musique', 'Jeux créatifs', 'Aide aux devoirs'],
        'superpouvoirs' => ['Musique', 'Jeux créatifs', 'Dessin', 'Faire la lecture'],
        'availability' => [
            'lundi' => ['14:00-18:00'], 'mardi' => ['14:00-18:00'],
            'mercredi' => ['09:00-12:00', '14:00-18:00'], 'jeudi' => ['14:00-18:00'],
            'vendredi' => [], 'samedi' => ['09:00-12:00'], 'dimanche' => ['09:00-12:00']
        ]
    ],
    4 => [
        'id' => 4, 'nom' => 'Idrissi', 'prenom' => 'Salma', 'age' => 26,
        'photo' => 'https://images.unsplash.com/photo-1676552055618-22ec8cde399a?w=400',
        'rating' => 4.7, 'reviewCount' => 67, 'prixHoraire' => 50,
        'ville' => 'Casablanca', 'quartier' => 'CIL', 'experience' => 4,
        'verified' => true, 'fumeur' => false, 'permis' => false, 'mobilite' => false, 'aDesEnfants' => false,
        'langues' => ['Arabe', 'Français'],
        'description' => 'Jeune et dynamique, j\'apporte une énergie positive et créative dans la garde d\'enfants. Je suis particulièrement douée pour les activités artistiques et les travaux manuels.',
        'certifications' => [
            ['nom' => 'Diplôme en Arts Plastiques', 'annee' => '2020', 'organisme' => 'École des Beaux-Arts'],
            ['nom' => 'Formation Garde d\'Enfants', 'annee' => '2021', 'organisme' => 'Institut de Formation']
        ],
        'services' => ['Dessin', 'Travaux manuels', 'Cuisine'],
        'superpouvoirs' => ['Dessin', 'Travaux manuels', 'Jeux créatifs'],
        'availability' => [
            'lundi' => ['14:00-18:00'], 'mardi' => ['14:00-18:00'],
            'mercredi' => ['09:00-12:00', '14:00-18:00'], 'jeudi' => ['14:00-18:00'],
            'vendredi' => ['14:00-18:00'], 'samedi' => [], 'dimanche' => []
        ]
    ],
    5 => [
        'id' => 5, 'nom' => 'Tazi', 'prenom' => 'Nour', 'age' => 30,
        'photo' => 'https://images.unsplash.com/photo-1675526607070-f5cbd71dde92?w=400',
        'rating' => 4.8, 'reviewCount' => 102, 'prixHoraire' => 58,
        'ville' => 'Casablanca', 'quartier' => 'Mers Sultan', 'experience' => 6,
        'verified' => true, 'fumeur' => false, 'permis' => true, 'mobilite' => true, 'aDesEnfants' => true,
        'langues' => ['Arabe', 'Français', 'Anglais'],
        'description' => 'Maman de deux enfants, je comprends parfaitement les besoins des parents. Je propose un service complet incluant la garde, l\'aide aux devoirs et les tâches ménagères légères.',
        'certifications' => [
            ['nom' => 'Certificat en Puériculture', 'annee' => '2018', 'organisme' => 'Institut de Santé'],
            ['nom' => 'Formation Premiers Secours', 'annee' => '2019', 'organisme' => 'Croissant Rouge']
        ],
        'services' => ['Cuisine', 'Tâches ménagères', 'Aide aux devoirs'],
        'superpouvoirs' => ['Cuisine', 'Faire la lecture', 'Jeux créatifs'],
        'availability' => [
            'lundi' => ['09:00-12:00', '14:00-17:00'], 'mardi' => ['09:00-12:00', '14:00-17:00'],
            'mercredi' => ['09:00-12:00'], 'jeudi' => ['09:00-12:00', '14:00-17:00'],
            'vendredi' => ['09:00-12:00'], 'samedi' => ['09:00-12:00'], 'dimanche' => []
        ]
    ],
    6 => [
        'id' => 6, 'nom' => 'Mansouri', 'prenom' => 'Yasmine', 'age' => 29,
        'photo' => 'https://images.unsplash.com/photo-1758525862933-73398157e165?w=400',
        'rating' => 4.9, 'reviewCount' => 134, 'prixHoraire' => 70,
        'ville' => 'Casablanca', 'quartier' => 'Bourgogne', 'experience' => 7,
        'verified' => true, 'fumeur' => false, 'permis' => true, 'mobilite' => true, 'aDesEnfants' => false,
        'langues' => ['Arabe', 'Français', 'Anglais'],
        'description' => 'Professionnelle expérimentée avec une formation en éducation musicale. Je propose des activités enrichissantes qui allient apprentissage et plaisir pour le développement harmonieux des enfants.',
        'certifications' => [
            ['nom' => 'Master en Éducation', 'annee' => '2017', 'organisme' => 'Université Hassan II'],
            ['nom' => 'Certificat en Pédagogie Musicale', 'annee' => '2018', 'organisme' => 'Conservatoire'],
            ['nom' => 'Formation Premiers Secours', 'annee' => '2020', 'organisme' => 'Croissant Rouge']
        ],
        'services' => ['Aide aux devoirs', 'Musique', 'Cuisine'],
        'superpouvoirs' => ['Musique', 'Faire la lecture', 'Aide aux devoirs', 'Jeux créatifs'],
        'availability' => [
            'lundi' => ['14:00-18:00'], 'mardi' => ['14:00-18:00'],
            'mercredi' => ['09:00-12:00', '14:00-18:00'], 'jeudi' => ['14:00-18:00'],
            'vendredi' => ['14:00-18:00'], 'samedi' => ['10:00-13:00'], 'dimanche' => []
        ]
    ]
];

$babysitterId = $id ?? 1;
$babysitter = $allBabysitters[$babysitterId] ?? $allBabysitters[1];

$reviews = [
    ['id' => 1, 'author' => 'Amina T.', 'avatar' => 'https://images.unsplash.com/photo-1588495644868-1416d25d8b33?w=100',
     'rating' => 5, 'date' => 'Il y a 2 semaines',
     'comment' => $babysitter['prenom'] . ' est exceptionnelle ! Mes enfants l\'adorent et elle est toujours ponctuelle. Je la recommande vivement.',
     'tags' => ['Ponctuelle', 'Douce avec les enfants']],
    ['id' => 2, 'author' => 'Leila M.', 'avatar' => 'https://images.unsplash.com/photo-1696804218747-5c6ce0ec0739?w=100',
     'rating' => 5, 'date' => 'Il y a 1 mois',
     'comment' => 'Très professionnelle et attentionnée. Elle a su gérer mon fils de 3 ans avec brio. Merci ' . $babysitter['prenom'] . ' !',
     'tags' => ['Professionnelle', 'Patiente']],
    ['id' => 3, 'author' => 'Sara E.', 'avatar' => 'https://images.unsplash.com/photo-1675526607070-f5cbd71dde92?w=100',
     'rating' => 5, 'date' => 'Il y a 2 mois',
     'comment' => 'Excellente babysitter, je fais totalement confiance à ' . $babysitter['prenom'] . ' avec mes enfants.',
     'tags' => ['Fiable', 'Créative']]
];

$dayNames = ['lundi' => 'Lundi', 'mardi' => 'Mardi', 'mercredi' => 'Mercredi', 'jeudi' => 'Jeudi',
             'vendredi' => 'Vendredi', 'samedi' => 'Samedi', 'dimanche' => 'Dimanche'];
@endphp

<div class="min-h-screen bg-[#F7F7F7]">
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <a href="/liste-babysitter" wire:navigate class="flex items-center gap-2 text-gray-600 hover:text-gray-900 font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour à la recherche
            </a>
        </div>
    </div>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex items-start gap-8">
                <div class="relative flex-shrink-0">
                    <div class="w-40 h-40 rounded-3xl overflow-hidden border-4 border-white" style="box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15)">
                        <img src="{{ $babysitter['photo'] }}" alt="{{ $babysitter['prenom'] }} {{ $babysitter['nom'] }}" class="w-full h-full object-cover" />
                    </div>
                </div>

                <div class="flex-1">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h1 class="text-4xl mb-2 text-black font-extrabold">{{ $babysitter['prenom'] }} {{ $babysitter['nom'] }}</h1>
                            <div class="flex items-center gap-4 mb-3">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-[#B82E6E]" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                    </svg>
                                    <span class="text-lg text-[#3a3a3a] font-semibold">{{ $babysitter['quartier'] }}, {{ $babysitter['ville'] }}</span>
                                </div>
                                <span class="px-4 py-1.5 bg-[#F9E0ED] rounded-full text-sm text-[#B82E6E] font-bold">{{ $babysitter['age'] }} ans</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="flex items-center">
                                    @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 {{ $i < floor($babysitter['rating']) ? 'text-[#C78500] fill-current' : 'text-gray-300' }}" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                    @endfor
                                </div>
                                <span class="text-xl text-black font-extrabold">{{ $babysitter['rating'] }}</span>
                                <span class="text-gray-500 font-semibold">({{ $babysitter['reviewCount'] }} avis)</span>
                            </div>
                        </div>
                        <a href="/babysitter-booking/{{ $babysitter['id'] }}" wire:navigate
   class="px-8 py-3 bg-[#B82E6E] text-white rounded-xl hover:bg-[#A02860] transition-all font-bold" 
   style="box-shadow: 0 4px 20px rgba(184, 46, 110, 0.3)">
    Demander un service
</a>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-[#F7F7F7] rounded-xl p-4">
                            <p class="text-sm mb-1 text-gray-500 font-semibold">Expérience</p>
                            <p class="text-2xl text-[#B82E6E] font-extrabold">{{ $babysitter['experience'] }} ans</p>
                        </div>
                        <div class="bg-[#F7F7F7] rounded-xl p-4">
                            <p class="text-sm mb-1 text-gray-500 font-semibold">Tarif horaire</p>
                            <p class="text-2xl text-[#B82E6E] font-extrabold">{{ $babysitter['prixHoraire'] }} DH</p>
                        </div>
                        <div class="bg-[#F7F7F7] rounded-xl p-4">
                            <p class="text-sm mb-1 text-gray-500 font-semibold">Certifications</p>
                            <p class="text-2xl text-[#B82E6E] font-extrabold">{{ count($babysitter['certifications']) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-2xl p-8 border border-gray-100" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                    <h2 class="text-2xl mb-4 text-black font-extrabold">À propos</h2>
                    <p class="text-lg leading-relaxed text-[#3a3a3a] font-medium">{{ $babysitter['description'] }}</p>
                </div>

                <div class="bg-white rounded-2xl p-8 border border-gray-100" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                    <h2 class="text-2xl mb-6 text-black font-extrabold">Formations & Certifications</h2>
                    <div class="space-y-4">
                        @foreach($babysitter['certifications'] as $cert)
                        <div class="flex items-start gap-4 p-4 bg-[#F7F7F7] rounded-xl">
                            <div class="w-12 h-12 bg-[#B82E6E] rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg mb-1 text-black font-bold">{{ $cert['nom'] }}</h3>
                                <p class="text-gray-500 font-semibold">{{ $cert['organisme'] }}</p>
                                <span class="inline-block mt-2 px-3 py-1 bg-white rounded-lg text-sm text-[#B82E6E] font-bold">{{ $cert['annee'] }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-8 border border-gray-100" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                    <h2 class="text-2xl mb-6 text-black font-extrabold">Je suis à l'aise avec</h2>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach($babysitter['services'] as $service)
                        <div class="p-6 bg-[#F7F7F7] rounded-xl text-center">
                            <div class="text-4xl mb-3">
                                @if($service === 'Cuisine') 🍳
                                @elseif($service === 'Tâches ménagères') 🧹
                                @elseif($service === 'Aide aux devoirs') 📚
                                @elseif($service === 'Musique') 🎵
                                @elseif($service === 'Jeux créatifs') 🎨
                                @elseif($service === 'Dessin') ✏️
                                @elseif($service === 'Travaux manuels') 🛠️
                                @endif
                            </div>
                            <h3 class="text-black font-bold">{{ $service }}</h3>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-8 border border-gray-100" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                    <h2 class="text-2xl mb-6 text-black font-extrabold">Mes superpouvoirs</h2>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach($babysitter['superpouvoirs'] as $power)
                        <div class="p-6 bg-[#F9E0ED] rounded-xl text-center hover:shadow-lg transition-all cursor-pointer">
                            <div class="text-4xl mb-3">
                                @if($power === 'Faire la lecture') 📖
                                @elseif($power === 'Musique') 🎵
                                @elseif($power === 'Jeux créatifs') 🎨
                                @elseif($power === 'Dessin') ✏️
                                @elseif($power === 'Travaux manuels') 🛠️
                                @elseif($power === 'Cuisine') 🍳
                                @elseif($power === 'Aide aux devoirs') 📚
                                @endif
                            </div>
                            <h3 class="text-sm text-[#B82E6E] font-bold">{{ $power }}</h3>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-8 border border-gray-100" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                    <h2 class="text-2xl mb-6 text-black font-extrabold">Avis ({{ $babysitter['reviewCount'] }})</h2>
                    <div class="space-y-6">
                        @foreach($reviews as $review)
                        <div class="p-6 bg-[#F7F7F7] rounded-xl">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200">
                                    <img src="{{ $review['avatar'] }}" alt="{{ $review['author'] }}" class="w-full h-full object-cover" />
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="text-black font-bold">{{ $review['author'] }}</h4>
                                        <span class="text-sm text-gray-500 font-medium">{{ $review['date'] }}</span>
                                    </div>
                                    <div class="flex items-center mb-3">
                                        @for($i = 0; $i < 5; $i++)
                                        <svg class="w-4 h-4 {{ $i < $review['rating'] ? 'text-[#C78500] fill-current' : 'text-gray-300' }}" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        @endfor
                                    </div>
                                    <p class="mb-3 text-[#3a3a3a] font-medium">{{ $review['comment'] }}</p>
                                    <div class="flex gap-2">
                                        @foreach($review['tags'] as $tag)
                                        <span class="px-3 py-1 bg-white rounded-lg text-sm text-[#B82E6E] font-semibold">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-2xl p-6 border border-gray-100" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                    <h2 class="text-xl mb-4 text-black font-extrabold">Emplacement</h2>
                    <div class="relative w-full h-64 rounded-xl overflow-hidden border-2 border-gray-100 mb-4">
                        <iframe width="100%" height="100%" frameBorder="0" scrolling="no" marginHeight="0" marginWidth="0"
                            src="https://www.openstreetmap.org/export/embed.html?bbox=-7.620,33.565,-7.570,33.590&layer=mapnik&marker=33.5731,-7.5898" style="border: 0"></iframe>
                    </div>
                    <div class="flex items-start gap-3 p-3 bg-[#F7F7F7] rounded-xl">
                        <svg class="w-5 h-5 text-[#B82E6E] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        <div>
                            <p class="text-black font-bold">{{ $babysitter['quartier'] }}, {{ $babysitter['ville'] }}</p>
                            <p class="text-sm mt-1 text-gray-500 font-semibold">Zone d'intervention dans un rayon de 5 km</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100 sticky top-8" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06); max-height: calc(100vh - 4rem); overflow-y: auto">
                    <h2 class="text-xl mb-6 text-black font-extrabold">Disponibilités</h2>
                    <div class="space-y-3">
                        @foreach($babysitter['availability'] as $day => $slots)
                        <div class="p-4 bg-[#F7F7F7] rounded-xl">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-sm text-black font-bold">{{ $dayNames[$day] }}</h3>
                                @if(count($slots) === 0)
                                <span class="text-xs px-2 py-1 bg-gray-200 text-gray-600 rounded-lg font-semibold">Non disponible</span>
                                @endif
                            </div>
                            @if(count($slots) > 0)
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach($slots as $slot)
                                <div class="flex items-center gap-2 px-3 py-1.5 bg-white rounded-lg border border-[#B82E6E]">
                                    <svg class="w-4 h-4 text-[#B82E6E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
                        <p class="text-xs text-center text-[#B82E6E] font-semibold">💡 Les disponibilités peuvent varier selon les semaines</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                    <h2 class="text-xl mb-6 text-black font-extrabold">Caractéristiques</h2>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-[#0a0a0a] font-semibold">Vérifié</span>
                            </div>
                            <span class="px-3 py-1 bg-green-600 text-white rounded-lg text-sm font-bold">Oui</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-[#F7F7F7] rounded-xl">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span class="text-[#0a0a0a] font-semibold">Fumeur</span>
                            </div>
                            <span class="px-3 py-1 bg-gray-200 text-gray-800 rounded-lg text-sm font-bold">{{ $babysitter['fumeur'] ? 'Oui' : 'Non' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-[#F7F7F7] rounded-xl">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#B82E6E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-[#0a0a0a] font-semibold">Permis</span>
                            </div>
                            <span class="px-3 py-1 bg-[#B82E6E] text-white rounded-lg text-sm font-bold">{{ $babysitter['permis'] ? 'Oui' : 'Non' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-[#F7F7F7] rounded-xl">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#B82E6E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span class="text-[#0a0a0a] font-semibold">A des enfants</span>
                            </div>
                            <span class="px-3 py-1 bg-[#B82E6E] text-white rounded-lg text-sm font-bold">{{ $babysitter['aDesEnfants'] ? 'Oui' : 'Non' }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-100" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                    <h2 class="text-xl mb-4 text-black font-extrabold">Langues parlées</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($babysitter['langues'] as $langue)
                        <span class="px-4 py-2 bg-[#F9E0ED] rounded-xl text-[#B82E6E] font-bold">{{ $langue }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>