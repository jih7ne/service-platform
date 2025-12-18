<div class="flex h-screen bg-[#F3F4F6] font-sans overflow-hidden">

    <livewire:tutoring.components.professeur-sidebar :currentPage="'tutoring-courses'" />

    {{-- CONTENU PRINCIPAL --}}
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 md:p-8 relative">
        
        <!-- Header -->
        <div class="bg-white p-4 sm:p-5 md:p-6 rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900 flex items-center gap-2">Mes cours</h1>
                    <p class="text-sm sm:text-base text-gray-500 mt-1">Gérez votre catalogue de cours</p>
                </div>
                
                <button wire:click="openCreateModal" class="w-full sm:w-auto bg-[#1E40AF] hover:bg-blue-800 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg sm:rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-blue-100 transition-all text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Ajouter un cours
                </button>
            </div>
        </div>

        <!-- Message de succès -->
        @if (session()->has('success'))
            <div class="mb-4 sm:mb-6 p-3 sm:p-4 rounded-lg sm:rounded-xl bg-green-50 text-green-700 border border-green-200 font-medium text-sm sm:text-base">
                {{ session('success') }}
            </div>
        @endif

        <!-- Grille des cours -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            @forelse($this->cours as $cours)
                <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all flex flex-col justify-between h-full {{ $cours->status === 'inactif' ? 'opacity-70 bg-gray-50' : '' }}">
                    
                    <div>
                        <div class="flex justify-between items-start mb-4 gap-3">
                            <div class="min-w-0 flex-1">
                                <h3 class="text-lg sm:text-xl font-bold text-gray-900 truncate">{{ $cours->nom_matiere }}</h3>
                                @if($cours->status == 'actif')
                                    <span class="inline-flex items-center gap-1 mt-1 bg-green-100 text-green-700 text-[9px] sm:text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">
                                        <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-green-500 rounded-full"></span> Visible
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 mt-1 bg-gray-200 text-gray-600 text-[9px] sm:text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">
                                        <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-gray-500 rounded-full"></span> Masqué
                                    </span>
                                @endif
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase">Prix</p>
                                <p class="text-lg sm:text-xl font-extrabold text-[#1E40AF]">{{ $cours->prix_par_heure }} <span class="text-xs sm:text-sm text-gray-500">DH/h</span></p>
                            </div>
                        </div>

                        <!-- Public cible -->
                        <div class="bg-white border border-gray-200 rounded-lg sm:rounded-xl p-2.5 sm:p-3 mb-4 sm:mb-6">
                            <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase mb-1">Public cible</p>
                            <p class="text-xs sm:text-sm font-bold text-gray-800">{{ $cours->nom_niveau }}</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="grid grid-cols-3 gap-2 sm:gap-3 pt-3 sm:pt-4 border-t border-gray-100">
                        <button wire:click="showDetails({{ $cours->id_service }})" class="flex flex-col sm:flex-row justify-center items-center gap-1 sm:gap-2 py-2 sm:py-2.5 bg-[#EFF6FF] text-[#1E40AF] rounded-lg text-[10px] sm:text-xs font-bold hover:bg-blue-100 transition-colors">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            <span class="hidden sm:inline">Stats</span>
                        </button>
                        <button wire:click="edit({{ $cours->id_service }})" class="flex flex-col sm:flex-row justify-center items-center gap-1 sm:gap-2 py-2 sm:py-2.5 bg-[#FFF7ED] text-[#EA580C] rounded-lg text-[10px] sm:text-xs font-bold hover:bg-orange-100 transition-colors">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            <span class="hidden sm:inline">Modifier</span>
                        </button>
                        <button wire:click="toggleStatus({{ $cours->id_service }})" class="flex flex-col sm:flex-row justify-center items-center gap-1 py-2 sm:py-2.5 rounded-lg text-[10px] sm:text-xs font-bold transition-colors border {{ $cours->status === 'actif' ? 'bg-white border-red-200 text-red-500 hover:bg-red-50' : 'bg-green-50 border-green-200 text-green-600 hover:bg-green-100' }}">
                            @if($cours->status === 'actif')
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                <span class="hidden sm:inline">Masquer</span>
                            @else
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <span class="hidden sm:inline">Publier</span>
                            @endif
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 sm:py-16 text-center bg-white rounded-2xl sm:rounded-3xl border border-dashed border-gray-300">
                    <p class="text-sm sm:text-base text-gray-500 mb-4 sm:mb-6">Ajoutez votre premier cours pour commencer !</p>
                    <button wire:click="openCreateModal" class="bg-[#1E40AF] text-white px-5 sm:px-6 py-2 sm:py-2.5 rounded-lg font-bold shadow-md text-sm sm:text-base">
                        Ajouter un cours
                    </button>
                </div>
            @endforelse
        </div>

        {{-- MODAL AJOUT (NOUVEAU) --}}
        @if($showCreateModal)
            <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
                <div class="bg-white rounded-xl sm:rounded-2xl w-full max-w-lg p-5 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-5 sm:mb-6">
                        <h3 class="text-xl sm:text-2xl font-extrabold text-gray-900">Ajouter une matière</h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-red-500 p-1">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <div class="space-y-4 sm:space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Matière -->
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold text-gray-500 uppercase mb-1">Matière *</label>
                                <select wire:model="newMatiereId" class="w-full border border-gray-300 rounded-lg sm:rounded-xl p-2.5 sm:p-3 bg-white focus:ring-2 focus:ring-blue-500 outline-none text-sm sm:text-base">
                                    <option value="">Choisir</option>
                                    @foreach($matieresDispo as $mat)
                                        <option value="{{ $mat->id_matiere }}">{{ $mat->nom_matiere }}</option>
                                    @endforeach
                                </select>
                                @error('newMatiereId') <span class="text-red-500 text-[10px] sm:text-xs">{{ $message }}</span> @enderror
                            </div>
                            <!-- Niveau -->
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold text-gray-500 uppercase mb-1">Niveau *</label>
                                <select wire:model="newNiveauId" class="w-full border border-gray-300 rounded-lg sm:rounded-xl p-2.5 sm:p-3 bg-white focus:ring-2 focus:ring-blue-500 outline-none text-sm sm:text-base">
                                    <option value="">Choisir</option>
                                    @foreach($niveauxDispo as $niv)
                                        <option value="{{ $niv->id_niveau }}">{{ $niv->nom_niveau }}</option>
                                    @endforeach
                                </select>
                                @error('newNiveauId') <span class="text-red-500 text-[10px] sm:text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Tarif -->
                        <div>
                            <label class="block text-[10px] sm:text-xs font-bold text-gray-500 uppercase mb-1">Tarif (DH/h) *</label>
                            <input type="number" wire:model="newPrix" placeholder="150" class="w-full border border-gray-300 rounded-lg sm:rounded-xl p-2.5 sm:p-3 focus:ring-2 focus:ring-blue-500 outline-none font-bold text-gray-800 text-sm sm:text-base">
                            @error('newPrix') <span class="text-red-500 text-[10px] sm:text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Type de cours (Radio Buttons) -->
                        <div>
                            <label class="block text-[10px] sm:text-xs font-bold text-gray-500 uppercase mb-2">Type de cours</label>
                            <div class="flex flex-col sm:flex-row gap-3 sm:gap-6">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" wire:model="newType" value="enligne" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm sm:text-base text-gray-700">En ligne</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" wire:model="newType" value="domicile" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm sm:text-base text-gray-700">À domicile</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6 sm:mt-8">
                        <button wire:click="create" class="w-full sm:w-auto bg-[#1E40AF] text-white font-bold py-2.5 sm:py-3 px-6 sm:px-8 rounded-lg sm:rounded-xl hover:bg-blue-800 transition-colors shadow-lg shadow-blue-100 text-sm sm:text-base">
                            + Ajouter une matière
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- MODAL MODIFICATION --}}
        @if($showEditModal)
            <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
                <div class="bg-white rounded-xl sm:rounded-2xl w-full max-w-lg p-5 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
                    <h3 class="text-lg sm:text-xl font-extrabold text-gray-900 mb-4">Modifier le cours</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] sm:text-xs font-bold text-gray-400 uppercase mb-1">Matière</label>
                            <input type="text" wire:model="titre" disabled class="w-full bg-gray-100 border border-gray-200 rounded-lg sm:rounded-xl p-2.5 sm:p-3 text-gray-500 font-bold cursor-not-allowed text-sm sm:text-base">
                        </div>
                        <div>
                            <label class="block text-[10px] sm:text-xs font-bold text-gray-500 uppercase mb-1">Niveau Cible</label>
                            <select wire:model="niveau" class="w-full border border-gray-300 rounded-lg sm:rounded-xl p-2.5 sm:p-3 bg-white outline-none text-sm sm:text-base">
                                @foreach($niveauxDispo as $niv) <option value="{{ $niv->id_niveau }}">{{ $niv->nom_niveau }}</option> @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold text-gray-500 uppercase mb-1">Prix (DH/h)</label>
                                <input type="number" wire:model="prix" class="w-full border border-gray-300 rounded-lg sm:rounded-xl p-2.5 sm:p-3 outline-none font-bold text-sm sm:text-base">
                            </div>
                            <div>
                                <label class="block text-[10px] sm:text-xs font-bold text-gray-500 uppercase mb-1">Type</label>
                                <select wire:model="type" class="w-full border border-gray-300 rounded-lg sm:rounded-xl p-2.5 sm:p-3 outline-none text-sm sm:text-base">
                                    <option value="enligne">En ligne</option>
                                    <option value="domicile">Domicile</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 mt-6">
                        <button wire:click="closeModal" class="flex-1 py-2.5 sm:py-3 text-gray-500 font-bold hover:bg-gray-50 rounded-lg sm:rounded-xl text-sm sm:text-base">
                            Annuler
                        </button>
                        <button wire:click="update" class="flex-1 py-2.5 sm:py-3 bg-[#1E40AF] text-white font-bold rounded-lg sm:rounded-xl hover:bg-blue-800 text-sm sm:text-base">
                            Sauvegarder
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- MODAL STATS --}}
        @if($showDetailModal && $detailCours)
            <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
                <div class="bg-white rounded-xl sm:rounded-2xl w-full max-w-sm p-6 sm:p-8 shadow-2xl text-center">
                    <h3 class="text-lg sm:text-xl font-extrabold text-gray-900 mb-5 sm:mb-6">{{ $detailCours->nom_matiere }}</h3>
                    <div class="grid grid-cols-2 gap-3 sm:gap-4 mb-5 sm:mb-6">
                        <div class="bg-[#F8F9FD] p-3 sm:p-4 rounded-xl sm:rounded-2xl border border-gray-100">
                            <p class="text-2xl sm:text-3xl font-black text-blue-900 mb-1">{{ $statsClients }}</p>
                            <p class="text-[9px] sm:text-[10px] font-bold text-gray-400 uppercase">Élèves</p>
                        </div>
                        <div class="bg-[#F8F9FD] p-3 sm:p-4 rounded-xl sm:rounded-2xl border border-gray-100">
                            <p class="text-2xl sm:text-3xl font-black text-blue-900 mb-1">{{ $statsHeures }}<span class="text-base sm:text-lg">h</span></p>
                            <p class="text-[9px] sm:text-[10px] font-bold text-gray-400 uppercase">Enseignées</p>
                        </div>
                    </div>
                    <button wire:click="closeModal" class="w-full py-2.5 sm:py-3 bg-gray-100 text-gray-700 font-bold rounded-lg sm:rounded-xl hover:bg-gray-200 text-sm sm:text-base">
                        Fermer
                    </button>
                </div>
            </div>
        @endif

    </main>
</div>