<div>
    {{-- Contenu principal --}}
    <div class="p-8 max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Gestion des utilisateurs</h1>
            <p class="text-gray-600">Gérez tous les utilisateurs de la plateforme Helpora</p>
        </div>

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

        {{-- Error Message --}}
        @if (session()->has('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-800 px-5 py-4 rounded-r-lg flex items-center justify-between shadow-sm">
                <span class="text-sm font-medium">{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif


        {{-- Filtres et recherche --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                {{-- Recherche --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Rechercher</label>
                    <div class="relative">
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search"
                            placeholder="Nom, email, téléphone..."
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                {{-- Filtre par rôle --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Rôle</label>
                    <select 
                        wire:model.live="roleFilter"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="all">Tous les rôles</option>
                        <option value="client">Clients</option>
                        <option value="intervenant">Intervenants</option>
                    </select>
                </div>

                {{-- Filtre par statut --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Statut</label>
                    <select 
                        wire:model.live="statutFilter"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="all">Tous les statuts</option>
                        <option value="actif">Actifs</option>
                        <option value="suspendue">Suspendus</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Tableau des utilisateurs --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Utilisateur</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Inscription</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                {{-- Utilisateur --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($user->photo)
                                            <img src="{{ asset('storage/' . $user->photo) }}" class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                                <span class="text-white font-bold text-sm">{{ substr($user->prenom, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $user->prenom }} {{ $user->nom }}</p>
                                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Type --}}
                                <td class="px-6 py-4">
                                    @php
                                        $typeLabel = $this->getUserTypeLabel($user);
                                        $typeColors = [
                                            'Client' => 'bg-blue-100 text-blue-700',
                                            'Babysitter' => 'bg-pink-100 text-pink-700',
                                            'Professeur' => 'bg-purple-100 text-purple-700',
                                            'Gardien d\'animaux' => 'bg-orange-100 text-orange-700',
                                            'Intervenant' => 'bg-gray-100 text-gray-700',
                                        ];
                                        $colorClass = $typeColors[$typeLabel] ?? 'bg-gray-100 text-gray-700';
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $colorClass }}">
                                        {{ $typeLabel }}
                                    </span>
                                </td>

                                {{-- Contact --}}
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-900">{{ $user->telephone ?? 'Non renseigné' }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->ville ?? 'Ville non renseignée' }}</p>
                                </td>

                                {{-- Inscription --}}
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-900">{{ $user->created_at->format('d/m/Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                                </td>

                                {{-- Statut --}}
                                <td class="px-6 py-4">
                                    @if($user->statut === 'actif')
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                            Actif
                                        </span>
                                    @elseif($user->statut === 'suspendue')
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                            Suspendu
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                                            {{ ucfirst($user->statut) }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @if($user->statut === 'actif')
                                            <button 
                                                wire:click="openSuspendModal({{ $user->idUser }})"
                                                wire:loading.attr="disabled"
                                                class="px-3 py-1.5 bg-red-50 text-red-600 text-xs font-medium rounded-lg hover:bg-red-100 transition-colors disabled:opacity-50"
                                                title="Suspendre"
                                            >
                                                <span wire:loading.remove wire:target="openSuspendModal({{ $user->idUser }})">
                                                    Suspendre
                                                </span>
                                                <span wire:loading wire:target="openSuspendModal({{ $user->idUser }})">
                                                    Chargement...
                                                </span>
                                            </button>
                                        @elseif($user->statut === 'suspendue')
                                            <button 
                                                wire:click="openReactivateModal({{ $user->idUser }})"
                                                wire:loading.attr="disabled"
                                                class="px-3 py-1.5 bg-green-50 text-green-600 text-xs font-medium rounded-lg hover:bg-green-100 transition-colors disabled:opacity-50"
                                                title="Réactiver"
                                            >
                                                <span wire:loading.remove wire:target="openReactivateModal({{ $user->idUser }})">
                                                    Réactiver
                                                </span>
                                                <span wire:loading wire:target="openReactivateModal({{ $user->idUser }})">
                                                    Chargement...
                                                </span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Aucun utilisateur trouvé</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- 🎯 MODALS (dans le même élément racine) --}}
    {{-- Modal de suspension --}}
    @if($showSuspendModal && $selectedUser)
        <div class="modal-backdrop" wire:key="suspend-modal-{{ $selectedUser->idUser }}">
            <div class="modal-content modal-enter" @click.stop>
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Suspendre l'utilisateur</h3>
                            <p class="text-sm text-gray-500">{{ $selectedUser->prenom }} {{ $selectedUser->nom }}</p>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600 mb-4">
                        Cette action suspendra le compte de l'utilisateur et toutes ses offres de services. Il ne pourra plus se connecter et recevra un email de notification.
                    </p>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Raison de la suspension *</label>
                        <textarea 
                            wire:model="suspensionReason"
                            rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                            placeholder="Expliquez la raison de la suspension..."
                        ></textarea>
                        @error('suspensionReason')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-2xl">
                    <button 
                        wire:click="closeSuspendModal"
                        wire:loading.attr="disabled"
                        class="px-5 py-2.5 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium text-sm disabled:opacity-50"
                    >
                        Annuler
                    </button>
                    <button 
                        wire:click="suspendUser"
                        wire:loading.attr="disabled"
                        class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium text-sm shadow-sm disabled:opacity-50"
                    >
                        <span wire:loading.remove wire:target="suspendUser">
                            Confirmer la suspension
                        </span>
                        <span wire:loading wire:target="suspendUser">
                            Suspension...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal de réactivation --}}
    @if($showReactivateModal && $selectedUser)
        <div class="modal-backdrop" wire:key="reactivate-modal-{{ $selectedUser->idUser }}">
            <div class="modal-content modal-enter" @click.stop>
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Réactiver l'utilisateur</h3>
                            <p class="text-sm text-gray-500">{{ $selectedUser->prenom }} {{ $selectedUser->nom }}</p>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600 mb-4">
                        Cette action réactivera le compte de l'utilisateur et toutes ses offres de services. Il pourra à nouveau se connecter et recevra un email de notification.
                    </p>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Note (optionnel)</label>
                        <textarea 
                            wire:model="reactivationNote"
                            rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                            placeholder="Ajoutez une note pour l'utilisateur (optionnel)..."
                        ></textarea>
                        @error('reactivationNote')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-2xl">
                    <button 
                        wire:click="closeReactivateModal"
                        wire:loading.attr="disabled"
                        class="px-5 py-2.5 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium text-sm disabled:opacity-50"
                    >
                        Annuler
                    </button>
                    <button 
                        wire:click="reactivateUser"
                        wire:loading.attr="disabled"
                        class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium text-sm shadow-sm disabled:opacity-50"
                    >
                        <span wire:loading.remove wire:target="reactivateUser">
                            Confirmer la réactivation
                        </span>
                        <span wire:loading wire:target="reactivateUser">
                            Réactivation...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>