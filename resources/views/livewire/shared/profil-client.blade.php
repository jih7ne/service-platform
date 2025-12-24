<div class="min-h-screen bg-white">
    <livewire:shared.header />

    <!-- Hero Section avec photo de profil -->
    <section class="relative overflow-hidden bg-gradient-to-r from-[#2B5AA8] to-[#224A91] py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <!-- Photo de profil -->
                <div class="relative">
                    @if($photo)
                        <img src="{{ asset('storage/' . $photo) }}" 
                             alt="Photo de profil"
                             class="h-32 w-32 rounded-full object-cover border-4 border-white shadow-2xl">
                    @else
                        <div class="h-32 w-32 rounded-full bg-white flex items-center justify-center text-[#2B5AA8] font-extrabold text-4xl border-4 border-white shadow-2xl">
                            {{ strtoupper(substr($prenom, 0, 1)) }}{{ strtoupper(substr($nom, 0, 1)) }}
                        </div>
                    @endif
                    
                    @if($editMode)
                        <label class="absolute bottom-0 right-0 bg-white rounded-full p-3 shadow-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <svg class="h-5 w-5 text-[#2B5AA8]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <input type="file" wire:model="newPhoto" class="hidden" accept="image/*">
                        </label>
                    @endif
                </div>
                
                <!-- Informations utilisateur -->
                <div class="flex-1 text-white text-center md:text-left">
                    <h1 class="text-3xl lg:text-4xl font-extrabold mb-2">{{ $prenom }} {{ $nom }}</h1>
                    <p class="text-blue-100 mb-4 font-medium">{{ $email }}</p>
                    
                    
                    @if($note > 0)
                        <div class="flex items-center gap-2 justify-center md:justify-start">
                            <div class="flex items-center gap-1">
                                <svg class="h-5 w-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="font-bold text-lg">{{ number_format($note, 1) }}</span>
                            </div>
                            <span class="text-blue-100 text-sm font-medium">({{ $nbrAvis }} avis)</span>
                        </div>
                    @endif
                </div>

                <!-- Bouton Modifier -->
                @if(!$editMode)
                    <button wire:click="toggleEditMode" 
                            class="px-6 py-3 bg-white text-[#2B5AA8] rounded-xl hover:bg-gray-50 transition-all font-bold shadow-lg">
                        Modifier le profil
                    </button>
                @endif
            </div>

            <!-- Affichage de l'erreur photo -->
            @if($newPhoto)
                <div class="mt-4 text-sm text-white font-medium text-center md:text-left">
                    <p>✓ Nouvelle photo sélectionnée : {{ $newPhoto->getClientOriginalName() }}</p>
                </div>
            @endif

            @error('newPhoto')
                <div class="mt-4 text-sm text-red-200 font-medium text-center md:text-left">{{ $message }}</div>
            @enderror
        </div>
    </section>

    <!-- Messages de succès/erreur -->
    @if (session()->has('success'))
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            <div class="bg-green-50 border-2 border-green-200 text-green-800 px-6 py-4 rounded-xl flex items-center gap-3 shadow-sm">
                <svg class="h-6 w-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            <div class="bg-red-50 border-2 border-red-200 text-red-800 px-6 py-4 rounded-xl flex items-center gap-3 shadow-sm">
                <svg class="h-6 w-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="font-bold">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Formulaire Profil -->
    <section class="py-12 bg-[#F7F7F7]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Titre Section -->
            <div class="text-center mb-10">
                <h2 class="text-2xl lg:text-3xl mb-3 text-black font-extrabold">
                    Informations personnelles
                </h2>
                <p class="max-w-2xl mx-auto text-sm text-[#1a1a1a] font-medium">
                    Gérez vos informations de compte et vos préférences.
                </p>
            </div>

            <!-- Carte Formulaire -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <form wire:submit.prevent="updateProfile" class="p-6 lg:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Prénom -->
                        <div>
                            <label class="block text-sm font-bold text-[#0a0a0a] mb-2">Prénom</label>
                            <input type="text" 
                                   wire:model="prenom"
                                   @if(!$editMode) disabled @endif
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent disabled:bg-gray-50 disabled:text-gray-500 transition-all font-medium text-[#1a1a1a]">
                            @error('prenom') <span class="text-red-500 text-sm font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Nom -->
                        <div>
                            <label class="block text-sm font-bold text-[#0a0a0a] mb-2">Nom</label>
                            <input type="text" 
                                   wire:model="nom"
                                   @if(!$editMode) disabled @endif
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent disabled:bg-gray-50 disabled:text-gray-500 transition-all font-medium text-[#1a1a1a]">
                            @error('nom') <span class="text-red-500 text-sm font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-bold text-[#0a0a0a] mb-2">Email</label>
                            <input type="email" 
                                   wire:model="email"
                                   @if(!$editMode) disabled @endif
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent disabled:bg-gray-50 disabled:text-gray-500 transition-all font-medium text-[#1a1a1a]">
                            @error('email') <span class="text-red-500 text-sm font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Téléphone -->
                        <div>
                            <label class="block text-sm font-bold text-[#0a0a0a] mb-2">Téléphone</label>
                            <input type="tel" 
                                   wire:model="telephone"
                                   @if(!$editMode) disabled @endif
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent disabled:bg-gray-50 disabled:text-gray-500 transition-all font-medium text-[#1a1a1a]">
                            @error('telephone') <span class="text-red-500 text-sm font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Date de naissance -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-[#0a0a0a] mb-2">Date de naissance</label>
                            <input type="date" 
                                   wire:model="dateNaissance"
                                   @if(!$editMode) disabled @endif
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent disabled:bg-gray-50 disabled:text-gray-500 transition-all font-medium text-[#1a1a1a]">
                            @error('dateNaissance') <span class="text-red-500 text-sm font-medium mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    @if($editMode)
                        <div class="mt-8 flex flex-col sm:flex-row items-center gap-3">
                            <button type="submit"
                                    class="w-full sm:w-auto px-6 py-3 bg-[#2B5AA8] text-white rounded-xl font-bold hover:bg-[#224A91] transition-all shadow-lg">
                                Enregistrer les modifications
                            </button>
                            <button type="button"
                                    wire:click="toggleEditMode"
                                    class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-300 transition-all">
                                Annuler
                            </button>
                            @if($photo)
                                <button type="button"
                                        wire:click="deletePhoto"
                                        wire:confirm="Êtes-vous sûr de vouloir supprimer votre photo ?"
                                        class="w-full sm:w-auto sm:ml-auto px-6 py-3 bg-red-50 text-red-600 rounded-xl font-bold hover:bg-red-100 transition-all border-2 border-red-200">
                                    Supprimer la photo
                                </button>
                            @endif
                        </div>
                    @endif
                </form>
            </div>

        </div>
    </section>

    <!-- Section Mot de passe -->
    <section class="py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Carte Mot de passe -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden border-2 border-gray-100">
                <div class="p-6 lg:p-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                        <div>
                            <h3 class="text-xl font-extrabold text-[#0a0a0a] mb-1">Sécurité du compte</h3>
                            <p class="text-sm text-[#2a2a2a] font-medium">Modifiez votre mot de passe régulièrement pour plus de sécurité</p>
                        </div>
                        <button wire:click="$toggle('showPasswordForm')"
                                class="px-6 py-2.5 text-sm font-bold rounded-xl transition-all {{ $showPasswordForm ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' : 'bg-[#2B5AA8] text-white hover:bg-[#224A91] shadow-lg' }}">
                            {{ $showPasswordForm ? 'Annuler' : 'Changer le mot de passe' }}
                        </button>
                    </div>

                    @if($showPasswordForm)
                        <form wire:submit.prevent="updatePassword" class="space-y-6 pt-6 border-t-2 border-gray-100">
                            <!-- Mot de passe actuel -->
                            <div>
                                <label class="block text-sm font-bold text-[#0a0a0a] mb-2">Mot de passe actuel</label>
                                <input type="password" 
                                       wire:model="currentPassword"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all font-medium text-[#1a1a1a]"
                                       placeholder="Entrez votre mot de passe actuel">
                                @error('currentPassword') <span class="text-red-500 text-sm font-medium mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Nouveau mot de passe -->
                            <div>
                                <label class="block text-sm font-bold text-[#0a0a0a] mb-2">Nouveau mot de passe</label>
                                <input type="password" 
                                       wire:model="newPassword"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all font-medium text-[#1a1a1a]"
                                       placeholder="Minimum 8 caractères">
                                @error('newPassword') <span class="text-red-500 text-sm font-medium mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Confirmation nouveau mot de passe -->
                            <div>
                                <label class="block text-sm font-bold text-[#0a0a0a] mb-2">Confirmer le nouveau mot de passe</label>
                                <input type="password" 
                                       wire:model="newPasswordConfirmation"
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all font-medium text-[#1a1a1a]"
                                       placeholder="Confirmez votre nouveau mot de passe">
                                @error('newPasswordConfirmation') <span class="text-red-500 text-sm font-medium mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Bouton soumettre -->
                            <button type="submit"
                                    class="w-full px-6 py-3 bg-[#2B5AA8] text-white rounded-xl font-bold hover:bg-[#224A91] transition-all shadow-lg">
                                Mettre à jour le mot de passe
                            </button>
                        </form>
                    @endif
                </div>
            </div>

        </div>
    </section>

    <livewire:shared.footer />
</div>