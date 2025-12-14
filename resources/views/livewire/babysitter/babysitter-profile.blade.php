<div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    @include('livewire.babysitter.babysitter-sidebar')

    <!-- Main Content -->
    <div class="flex-1 ml-64">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Mon Profil</h1>
                        <p class="text-gray-600 mt-1">Gérez vos informations personnelles et professionnelles</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Profile Content -->
        <main class="p-6">
            <!-- Profile Header -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center space-x-6">
                    <!-- Profile Photo -->
                    <div class="relative">
                        @if($photo)
                            <img src="{{ asset('storage/' . $photo) }}" alt="Profile" 
                                 class="w-24 h-24 rounded-full object-cover border-4 border-purple-100">
                        @else
                            <div class="w-24 h-24 bg-gray-300 rounded-full flex items-center justify-center border-4 border-purple-100">
                                <span class="text-gray-600 font-bold text-2xl">{{ substr($prenom ?? '', 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="absolute bottom-0 right-0 bg-purple-600 rounded-full p-2 cursor-pointer hover:bg-purple-700">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 6H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Basic Info -->
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $prenom }} {{ $nom }}</h2>
                        <div class="flex items-center space-x-4 mt-2">
                            <div class="flex items-center space-x-1">
                                <span class="text-yellow-500">★</span>
                                <span class="text-gray-700 font-medium">{{ number_format($utilisateur->note ?? 0, 1) }}</span>
                            </div>
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-600">{{ $statistics['completedSittings'] ?? 0 }} missions</span>
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-600">Niveau Débutant</span>
                            @if(false)
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">Expert</span>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="flex space-x-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">{{ $prixHeure }} MAD</div>
                            <div class="text-sm text-gray-600">/ heure</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">{{ $expAnnee }}</div>
                            <div class="text-sm text-gray-600">ans d'exp</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Information Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Informations personnelles</h3>
                        @if(!$editPersonalInfo)
                            <button wire:click="editPersonalInfo = true" 
                                    class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                                Modifier
                            </button>
                        @endif
                    </div>
                </div>
                <div class="p-6">
                    @if($editPersonalInfo)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                                <input type="text" wire:model="nom" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                @error('nom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                                <input type="text" wire:model="prenom" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                @error('prenom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" wire:model="email" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                                <input type="tel" wire:model="telephone" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                @error('telephone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date de naissance</label>
                                <input type="date" wire:model="dateNaissance" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                @error('dateNaissance') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Photo de profil</label>
                                <input type="file" wire:model="newPhoto" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                @error('newPhoto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="flex space-x-4 mt-6">
                            <button wire:click="savePersonalInfo" 
                                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                Enregistrer
                            </button>
                            <button wire:click="cancelEdit('personal')" 
                                    class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                                Annuler
                            </button>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Email</div>
                                <div class="text-gray-800">{{ $email }}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Téléphone</div>
                                <div class="text-gray-800">{{ $telephone }}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Date de naissance</div>
                                <div class="text-gray-800">{{ \Carbon\Carbon::parse($dateNaissance)->format('d F Y') }}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Adresse</div>
                                <div class="text-gray-800">{{ $adresse ?? 'Non spécifiée' }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Professional Information Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Informations professionnelles</h3>
                        @if(!$editProfessionalInfo)
                            <button wire:click="editProfessionalInfo = true" 
                                    class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                                Modifier
                            </button>
                        @endif
                    </div>
                </div>
                <div class="p-6">
                    @if($editProfessionalInfo)
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tarif horaire (MAD)</label>
                                    <input type="number" wire:model="prixHeure" step="0.01" min="0"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    @error('prixHeure') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Années d'expérience</label>
                                    <input type="number" wire:model="expAnnee" min="0"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    @error('expAnnee') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Niveau d'études</label>
                                    <input type="text" wire:model="niveauEtudes" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    @error('niveauEtudes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Préférence de domicile</label>
                                    <select wire:model="preference_domicil" 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        <option value="">Choisir...</option>
                                        <option value="domicil_babysitter">Au domicile de la babysitter</option>
                                        <option value="domicil_client">Au domicile du client</option>
                                        <option value="les_deux">Les deux options</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Langues parlées</label>
                                <div class="space-y-2">
                                    @foreach(['Français', 'Arabe', 'Anglais', 'Espagnol', 'Italien', 'Allemand'] as $langue)
                                        <label class="flex items-center">
                                            <input type="checkbox" wire:model="langues" value="{{ $langue }}" 
                                                   class="mr-2 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                            <span class="text-gray-700">{{ $langue }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea wire:model="description" rows="4"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                          placeholder="Décrivez votre expérience, votre style de garde..."></textarea>
                                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Informations médicales</label>
                                    <input type="text" wire:model="maladies" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                           placeholder="Allergies, maladies chroniques...">
                                    @error('maladies') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="estFumeur" 
                                           class="mr-2 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                    <span class="text-gray-700">Fumeur</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="mobilite" 
                                           class="mr-2 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                    <span class="text-gray-700">Mobile</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="possedeEnfant" 
                                           class="mr-2 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                    <span class="text-gray-700">A des enfants</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="permisConduite" 
                                           class="mr-2 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                    <span class="text-gray-700">Permis de conduire</span>
                                </label>
                            </div>
                        </div>
                        <div class="flex space-x-4 mt-6">
                            <button wire:click="saveProfessionalInfo" 
                                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                Enregistrer
                            </button>
                            <button wire:click="cancelEdit('professional')" 
                                    class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                                Annuler
                            </button>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Tarif horaire</div>
                                <div class="text-gray-800">{{ $prixHeure }} MAD</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Expérience</div>
                                <div class="text-gray-800">{{ $expAnnee }} {{ $expAnnee == 1 ? 'an' : 'ans' }}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Niveau d'études</div>
                                <div class="text-gray-800">{{ $niveauEtudes ?? 'Non spécifié' }}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Préférence de domicile</div>
                                <div class="text-gray-800">{{ $babysitter->preference_domicil_label ?? 'Non spécifiée' }}</div>
                            </div>
                            <div class="md:col-span-2">
                                <div class="text-sm text-gray-500 mb-1">Langues</div>
                                <div class="text-gray-800">{{ is_array($langues) ? implode(', ', $langues) : $langues }}</div>
                            </div>
                            @if($description)
                                <div class="md:col-span-2">
                                    <div class="text-sm text-gray-500 mb-1">Description</div>
                                    <div class="text-gray-800">{{ $description }}</div>
                                </div>
                            @endif
                            
                            <div class="md:col-span-2">
                                <div class="text-sm text-gray-500 mb-2">Documents & Certifications</div>
                                <div class="flex flex-wrap gap-2">
                                    @if($certifAptitudeMentale) 
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-md text-xs font-medium">Aptitude Mentale ✓</span> 
                                    @endif
                                    @if($radiographieThorax) 
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-md text-xs font-medium">Radio Thorax ✓</span> 
                                    @endif
                                    @if($coprocultureSelles) 
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-md text-xs font-medium">Coproculture ✓</span> 
                                    @endif
                                    @if($procedeJuridique) 
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-md text-xs font-medium">Non condamnation ✓</span> 
                                    @endif
                                    @if(!$certifAptitudeMentale && !$radiographieThorax && !$coprocultureSelles && !$procedeJuridique)
                                        <span class="text-gray-500 italic text-sm">Aucun document validé</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="md:col-span-2">
                                <div class="text-sm text-gray-500 mb-2">Autres informations</div>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="flex items-center text-gray-700">
                                        <span class="mr-2">{{ $estFumeur ? '🚬' : '🚭' }}</span>
                                        <span>{{ $estFumeur ? 'Fumeur' : 'Non-fumeur' }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-700">
                                        <span class="mr-2">{{ $mobilite ? '🚗' : '🚶' }}</span>
                                        <span>{{ $mobilite ? 'Véhiculé' : 'Non véhiculé' }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-700">
                                        <span class="mr-2">{{ $possedeEnfant ? '👶' : '🚫' }}</span>
                                        <span>{{ $possedeEnfant ? 'A des enfants' : 'Sans enfants' }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-700">
                                        <span class="mr-2">{{ $permisConduite ? '💳' : '✖' }}</span>
                                        <span>{{ $permisConduite ? 'Permis B' : 'Pas de permis' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Skills & Activities Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Compétences & Activités</h3>
                        @if(!$editSkills)
                            <button wire:click="editSkills = true" 
                                    class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                                Modifier
                            </button>
                        @endif
                    </div>
                </div>
                <div class="p-6">
                    @if($editSkills)
                        <div class="space-y-6">
                            <!-- Superpouvoirs -->
                            <div>
                                <h4 class="text-md font-medium text-gray-700 mb-3">Superpouvoirs</h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    @foreach($allSuperpouvoirs as $superpouvoir)
                                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                            <input type="checkbox" wire:model="selectedSuperpouvoirs" 
                                                   value="{{ $superpouvoir->idSuperpouvoir }}" 
                                                   class="mr-2 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                            <span class="text-gray-700">{{ $superpouvoir->superpouvoir }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Formations -->
                            <div>
                                <h4 class="text-md font-medium text-gray-700 mb-3">Formations</h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    @foreach($allFormations as $formation)
                                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                            <input type="checkbox" wire:model="selectedFormations" 
                                                   value="{{ $formation->idFormation }}" 
                                                   class="mr-2 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                            <span class="text-gray-700">{{ $formation->formation }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Catégories d'enfants -->
                            <div>
                                <h4 class="text-md font-medium text-gray-700 mb-3">Catégories d'enfants préférées</h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    @foreach($allCategories as $categorie)
                                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                            <input type="checkbox" wire:model="selectedCategories" 
                                                   value="{{ $categorie->idCategorie }}" 
                                                   class="mr-2 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                            <span class="text-gray-700">{{ $categorie->categorie }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Expériences besoins spéciaux -->
                            <div>
                                <h4 class="text-md font-medium text-gray-700 mb-3">Expériences avec besoins spéciaux</h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    @foreach($allExperiences as $experience)
                                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                            <input type="checkbox" wire:model="selectedExperiences" 
                                                   value="{{ $experience->idExperience }}" 
                                                   class="mr-2 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                            <span class="text-gray-700">{{ $experience->experience }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-4 mt-6">
                            <button wire:click="saveSkills" 
                                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                Enregistrer
                            </button>
                            <button wire:click="cancelEdit('skills')" 
                                    class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                                Annuler
                            </button>
                        </div>
                    @else
                        <div class="space-y-4">
                            @if($babysitter && $babysitter->superpouvoirs && $babysitter->superpouvoirs->count() > 0)
                                <div>
                                    <h4 class="text-md font-medium text-gray-700 mb-2">Superpouvoirs</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($babysitter->superpouvoirs as $superpouvoir)
                                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">{{ $superpouvoir->superpouvoir }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($babysitter && $babysitter->formations && $babysitter->formations->count() > 0)
                                <div>
                                    <h4 class="text-md font-medium text-gray-700 mb-2">Formations</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($babysitter->formations as $formation)
                                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">{{ $formation->formation }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($babysitter && $babysitter->categoriesEnfants && $babysitter->categoriesEnfants->count() > 0)
                                <div>
                                    <h4 class="text-md font-medium text-gray-700 mb-2">Catégories d'enfants</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($babysitter->categoriesEnfants as $categorie)
                                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">{{ $categorie->categorie }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($babysitter && $babysitter->experiencesBesoinsSpeciaux && $babysitter->experiencesBesoinsSpeciaux->count() > 0)
                                <div>
                                    <h4 class="text-md font-medium text-gray-700 mb-2">Expériences besoins spéciaux</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($babysitter->experiencesBesoinsSpeciaux as $experience)
                                            <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm">{{ $experience->experience }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Location Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Localisation</h3>
                        @if(!$editLocation)
                            <button wire:click="editLocation = true" 
                                    class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                                Modifier
                            </button>
                        @endif
                    </div>
                </div>
                <div class="p-6">
                    @if($editLocation)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                                <input type="text" wire:model="adresse" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                @error('adresse') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                                <input type="text" wire:model="ville" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                @error('ville') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="flex space-x-4 mt-6">
                            <button wire:click="saveLocation" 
                                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                Enregistrer
                            </button>
                            <button wire:click="cancelEdit('location')" 
                                    class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                                Annuler
                            </button>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Adresse</div>
                                <div class="text-gray-800">{{ $adresse ?? 'Non spécifiée' }}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Ville</div>
                                <div class="text-gray-800">{{ $ville ?? 'Non spécifiée' }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Success Message Modal -->
@if(session()->has('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
         class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    </div>
@endif

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('showMessage', (event) => {
            // Show success message
            const message = event.message;
            // You can implement a toast notification here
            console.log(message);
        });
    });
</script>