<div class="space-y-6">
    <h2 class="text-xl font-bold text-black mb-4">Matières enseignées</h2>

    <!-- Surnom et bio -->
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                Surnom (optionnel)
            </label>
            <input
                type="text"
                wire:model="surnom"
                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all"
                placeholder="Prof. Jean"
            />
        </div>
    </div>

    <div>
        <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
            Biographie (optionnel)
        </label>
        <textarea
            wire:model="biographie"
            rows="3"
            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all resize-none"
            placeholder="Parlez de votre expérience et de votre méthode d'enseignement..."
        ></textarea>
    </div>

    <!-- Liste des matières -->
    <div class="border-t pt-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-black">Matières et tarifs</h3>
            <button
                type="button"
                wire:click="$parent.addMatiere"
                class="px-4 py-2 bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91] transition-all font-semibold text-sm flex items-center gap-2"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Ajouter une matière
            </button>
        </div>

        @if(empty($matieres))
            <div class="text-center py-8 border-2 border-dashed border-gray-300 rounded-lg">
                <p class="text-gray-500">Aucune matière ajoutée. Cliquez sur "Ajouter une matière" pour commencer.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($matieres as $index => $matiere)
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="font-semibold text-black">Matière #{{ $index + 1 }}</h4>
                            <button
                                type="button"
                                wire:click="$parent.removeMatiere({{ $index }})"
                                class="text-red-500 hover:text-red-700"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <div class="grid md:grid-cols-3 gap-3">
                            <!-- Matière -->
                            <div>
                                <label class="block text-xs mb-1 text-gray-600 font-medium">
                                    Matière <span class="text-red-500">*</span>
                                </label>
                                <select
                                    wire:model="matieres.{{ $index }}.matiere_id"
                                    class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] text-sm"
                                >
                                    <option value="">Choisir</option>
                                    <option value="1">Mathématiques</option>
                                    <option value="2">Physique-Chimie</option>
                                    <option value="3">Français</option>
                                    <option value="4">Anglais</option>
                                </select>
                            </div>

                            <!-- Niveau -->
                            <div>
                                <label class="block text-xs mb-1 text-gray-600 font-medium">
                                    Niveau <span class="text-red-500">*</span>
                                </label>
                                <select
                                    wire:model="matieres.{{ $index }}.niveau_id"
                                    class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] text-sm"
                                >
                                    <option value="">Choisir</option>
                                    <option value="1">Primaire</option>
                                    <option value="2">Collège</option>
                                    <option value="3">Lycée</option>
                                    <option value="4">Université</option>
                                </select>
                            </div>

                            <!-- Prix -->
                            <div>
                                <label class="block text-xs mb-1 text-gray-600 font-medium">
                                    Tarif (DH/h) <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    wire:model="matieres.{{ $index }}.prix_par_heure"
                                    class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] text-sm"
                                    placeholder="150"
                                    min="0"
                                />
                            </div>
                        </div>

                        <!-- Type de service -->
                        <div class="mt-3">
                            <label class="block text-xs mb-1 text-gray-600 font-medium">
                                Type de cours
                            </label>
                            <div class="flex gap-4">
                                <label class="flex items-center">
                                    <input
                                        type="radio"
                                        wire:model="matieres.{{ $index }}.type_service"
                                        value="enligne"
                                        class="mr-2"
                                    />
                                    <span class="text-sm">En ligne</span>
                                </label>
                                <label class="flex items-center">
                                    <input
                                        type="radio"
                                        wire:model="matieres.{{ $index }}.type_service"
                                        value="domicile"
                                        class="mr-2"
                                    />
                                    <span class="text-sm">À domicile</span>
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @error('matieres') 
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>