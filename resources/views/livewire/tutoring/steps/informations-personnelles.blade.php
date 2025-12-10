<div class="space-y-6">
    <h2 class="text-xl font-bold text-black mb-4">Informations Personnelles</h2>

    <div class="grid md:grid-cols-2 gap-4">
        <!-- Prénom -->
        <div>
            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                Prénom  <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                wire:model="firstName"
                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all"
                placeholder="Jean"
            />
            @error('firstName') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Nom -->
        <div>
            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                Nom <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                wire:model="lastName"
                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all"
                placeholder="Dupont"
            />
            @error('lastName') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Email -->
    <div>
        <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
            Email <span class="text-red-500">*</span>
        </label>
        <input
            type="email"
            wire:model="email"
            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all"
            placeholder="jean.dupont@email.com"
        />
        @error('email') 
            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <!-- Téléphone -->
        <div>
            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                Téléphone <span class="text-red-500">*</span>
            </label>
            <input
                type="tel"
                wire:model="telephone"
                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all"
                placeholder="06XXXXXXXX"
            />
            @error('telephone') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Date de naissance -->
        <div>
            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                Date de Naissance <span class="text-red-500">*</span>
            </label>
            <input
                type="date"
                wire:model="dateNaissance"
                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all"
            />
            @error('dateNaissance') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Mot de passe -->
    <div>
        <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
            Mot de passe <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <input
                type="{{ $showPassword ? 'text' : 'password' }}"
                wire:model="password"
                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all pr-12"
                placeholder="••••••••"
            />
            <button 
                type="button"
                wire:click="togglePassword"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($showPassword)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    @endif
                </svg>
            </button>
        </div>
        @error('password') 
            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
        @enderror
        <p class="text-xs text-gray-500 mt-1">
            Le mot de passe doit contenir au moins 8 caractères
        </p>
    </div>
</div>