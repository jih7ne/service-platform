<div class="flex h-screen bg-[#F3F4F6] font-sans overflow-hidden">

    {{-- SIDEBAR --}}
    <aside class="w-72 bg-white border-r border-gray-100 flex flex-col justify-between shadow-sm z-20">
        <div>
            <div class="px-8 py-6 flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">H</div>
                <span class="text-2xl font-bold text-gray-800">Helpora</span>
            </div>
            <div class="px-6 mb-6">
                <a href="{{ route('tutoring.profile') }}" class="block bg-[#EFF6FF] rounded-2xl p-4 flex items-center gap-4 border border-blue-100 hover:bg-blue-50 transition-colors cursor-pointer">
                    @if($photo) <img src="{{ asset('storage/'.$photo) }}" class="w-10 h-10 rounded-full object-cover">
                    @else <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">{{ substr($prenom, 0, 1) }}</div> @endif
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">{{ $prenom }}</h3>
                        <p class="text-xs text-blue-600 font-medium">Professeur</p>
                    </div>
                </a>
            </div>
            <nav class="px-4 space-y-1">
                <a href="{{ route('tutoring.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition-all"><svg class="w-5 h-5 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg> Tableau de bord</a>
                <a href="{{ route('tutoring.requests') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition-all">                    <svg class="w-5 h-5 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                 Mes demandes</a>
                <a href="{{ route('tutoring.disponibilites') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> Disponibilité</a>
                <a href="{{ route('tutoring.clients') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg> Mes clients</a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 bg-[#EFF6FF] text-blue-700 rounded-xl font-bold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Mes cours
                </a>
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
    <main class="flex-1 overflow-y-auto p-8 relative">
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900 flex items-center gap-2">Mes cours</h1>
                <p class="text-gray-500 mt-1">Gérez votre catalogue de cours</p>
            </div>
            
            <button wire:click="openCreateModal" class="bg-[#1E40AF] hover:bg-blue-800 text-white px-6 py-3 rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-blue-100 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Ajouter un cours
            </button>
        </div>

        @if (session()->has('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 text-green-700 border border-green-200 font-medium">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($this->cours as $cours)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all flex flex-col justify-between h-full {{ $cours->status === 'inactif' ? 'opacity-70 bg-gray-50' : '' }}">
                    
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $cours->nom_matiere }}</h3>
                                @if($cours->status == 'actif')
                                    <span class="inline-flex items-center gap-1 mt-1 bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase"><span class="w-2 h-2 bg-green-500 rounded-full"></span> Visible</span>
                                @else
                                    <span class="inline-flex items-center gap-1 mt-1 bg-gray-200 text-gray-600 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase"><span class="w-2 h-2 bg-gray-500 rounded-full"></span> Masqué</span>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-400 font-bold uppercase">Prix</p>
                                <p class="text-xl font-extrabold text-[#1E40AF]">{{ $cours->prix_par_heure }} <span class="text-sm text-gray-500">DH/h</span></p>
                            </div>
                        </div>

                        <!-- J'ai SUPPRIMÉ la description ici comme demandé -->

                        <div class="bg-white border border-gray-200 rounded-xl p-3 mb-6">
                            <p class="text-xs text-gray-400 font-bold uppercase mb-1">Public cible</p>
                            <p class="text-sm font-bold text-gray-800">{{ $cours->nom_niveau }}</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="grid grid-cols-3 gap-3 pt-4 border-t border-gray-100">
                        <button wire:click="showDetails({{ $cours->id_service }})" class="flex justify-center items-center gap-2 py-2.5 bg-[#EFF6FF] text-[#1E40AF] rounded-lg text-xs font-bold hover:bg-blue-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Stats
                        </button>
                        <button wire:click="edit({{ $cours->id_service }})" class="flex justify-center items-center gap-2 py-2.5 bg-[#FFF7ED] text-[#EA580C] rounded-lg text-xs font-bold hover:bg-orange-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Modifier
                        </button>
                        <button wire:click="toggleStatus({{ $cours->id_service }})" class="flex justify-center items-center gap-1 py-2.5 rounded-lg text-xs font-bold transition-colors border {{ $cours->status === 'actif' ? 'bg-white border-red-200 text-red-500 hover:bg-red-50' : 'bg-green-50 border-green-200 text-green-600 hover:bg-green-100' }}">
                            @if($cours->status === 'actif')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg> Masquer
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> Publier
                            @endif
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-dashed border-gray-300">
                    <p class="text-gray-500 mb-6">Ajoutez votre premier cours pour commencer !</p>
                    <button wire:click="openCreateModal" class="bg-[#1E40AF] text-white px-6 py-2 rounded-lg font-bold shadow-md">Ajouter un cours</button>
                </div>
            @endforelse
        </div>

        {{-- MODAL AJOUT (NOUVEAU) --}}
        @if($showCreateModal)
            <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
                <div class="bg-white rounded-2xl w-full max-w-lg p-8 shadow-2xl">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-extrabold text-gray-900">Ajouter une matière</h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-red-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                    
                    <div class="space-y-5">
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Matière -->
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Matière *</label>
                                <select wire:model="newMatiereId" class="w-full border border-gray-300 rounded-xl p-3 bg-white focus:ring-2 focus:ring-blue-500 outline-none">
                                    <option value="">Choisir</option>
                                    @foreach($matieresDispo as $mat)
                                        <option value="{{ $mat->id_matiere }}">{{ $mat->nom_matiere }}</option>
                                    @endforeach
                                </select>
                                @error('newMatiereId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <!-- Niveau -->
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Niveau *</label>
                                <select wire:model="newNiveauId" class="w-full border border-gray-300 rounded-xl p-3 bg-white focus:ring-2 focus:ring-blue-500 outline-none">
                                    <option value="">Choisir</option>
                                    @foreach($niveauxDispo as $niv)
                                        <option value="{{ $niv->id_niveau }}">{{ $niv->nom_niveau }}</option>
                                    @endforeach
                                </select>
                                @error('newNiveauId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Tarif -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tarif (DH/h) *</label>
                            <input type="number" wire:model="newPrix" placeholder="150" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none font-bold text-gray-800">
                            @error('newPrix') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Type de cours (Radio Buttons) -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Type de cours</label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" wire:model="newType" value="enligne" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    <span class="text-gray-700">En ligne</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" wire:model="newType" value="domicile" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    <span class="text-gray-700">À domicile</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
                        <button wire:click="create" class="bg-[#1E40AF] text-white font-bold py-3 px-8 rounded-xl hover:bg-blue-800 transition-colors shadow-lg shadow-blue-100">
                            + Ajouter une matière
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- MODAL MODIFICATION (Inchangé mais présent) --}}
        @if($showEditModal)
            <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
                <div class="bg-white rounded-2xl w-full max-w-lg p-8 shadow-2xl">
                    <h3 class="text-xl font-extrabold text-gray-900 mb-4">Modifier le cours</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Matière</label>
                            <input type="text" wire:model="titre" disabled class="w-full bg-gray-100 border border-gray-200 rounded-xl p-3 text-gray-500 font-bold cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Niveau Cible</label>
                            <select wire:model="niveau" class="w-full border border-gray-300 rounded-xl p-3 bg-white outline-none">
                                @foreach($niveauxDispo as $niv) <option value="{{ $niv->id_niveau }}">{{ $niv->nom_niveau }}</option> @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Prix (DH/h)</label>
                                <input type="number" wire:model="prix" class="w-full border border-gray-300 rounded-xl p-3 outline-none font-bold">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Type</label>
                                <select wire:model="type" class="w-full border border-gray-300 rounded-xl p-3 outline-none">
                                    <option value="enligne">En ligne</option>
                                    <option value="domicile">Domicile</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-6">
                        <button wire:click="closeModal" class="flex-1 py-3 text-gray-500 font-bold hover:bg-gray-50 rounded-xl">Annuler</button>
                        <button wire:click="update" class="flex-1 py-3 bg-[#1E40AF] text-white font-bold rounded-xl hover:bg-blue-800">Sauvegarder</button>
                    </div>
                </div>
            </div>
        @endif

        {{-- MODAL STATS (Inchangé) --}}
        @if($showDetailModal && $detailCours)
            <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
                <div class="bg-white rounded-2xl w-full max-w-sm p-8 shadow-2xl text-center">
                    <h3 class="text-xl font-extrabold text-gray-900 mb-6">{{ $detailCours->nom_matiere }}</h3>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-[#F8F9FD] p-4 rounded-2xl border border-gray-100">
                            <p class="text-3xl font-black text-blue-900 mb-1">{{ $statsClients }}</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Élèves</p>
                        </div>
                        <div class="bg-[#F8F9FD] p-4 rounded-2xl border border-gray-100">
                            <p class="text-3xl font-black text-blue-900 mb-1">{{ $statsHeures }}<span class="text-lg">h</span></p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Enseignées</p>
                        </div>
                    </div>
                    <button wire:click="closeModal" class="w-full py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200">Fermer</button>
                </div>
            </div>
        @endif

    </main>
</div>