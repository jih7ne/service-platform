<div class="space-y-6">
    <h2 class="text-xl font-bold text-black mb-4">Où exercez-vous ?</h2>

    <!-- Bouton localisation automatique -->
    <button
        type="button"
        wire:click="getAutoLocation"
        class="w-full py-3 bg-[#E1EAF7] text-[#2B5AA8] rounded-lg hover:bg-[#d1dbf0] transition-all font-semibold flex items-center justify-center gap-2"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        Obtenir ma localisation automatique
    </button>

    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-4 bg-white text-gray-500 font-medium">ou</span>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <!-- Pays -->
        <div>
            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                Pays <span class="text-red-500">*</span>
            </label>
            <select
                wire:model="pays"
                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all"
            >
                <option value="">Sélectionnez un pays</option>
                <option value="Maroc">Maroc</option>
                <option value="France">France</option>
                <option value="Belgique">Belgique</option>
            </select>
            @error('pays') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Ville -->
        <div>
            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                Ville <span class="text-red-500">*</span>
            </label>
            <select
                wire:model="ville"
                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all"
            >
                <option value="">Sélectionnez une ville</option>
                <option value="Tétouan">Tétouan</option>
                <option value="Casablanca">Casablanca</option>
                <option value="Rabat">Rabat</option>
                <option value="Tanger">Tanger</option>
            </select>
            @error('ville') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Région / Province -->
    <div>
        <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
            Région / Province <span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            wire:model="region"
            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all"
            placeholder="Ex: Grand Casablanca"
        />
        @error('region') 
            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <!-- Adresse complète -->
    <div>
        <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
            Adresse complète <span class="text-red-500">*</span>
        </label>
        <textarea
            wire:model="adresseComplete"
            rows="3"
            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all resize-none"
            placeholder="Ex: 123 Rue Mohammed V, Quartier Maarif"
        ></textarea>
        @error('adresseComplete') 
            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
        @enderror
    </div>
</div>