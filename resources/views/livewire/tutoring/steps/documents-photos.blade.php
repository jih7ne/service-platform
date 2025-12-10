<div class="space-y-6">
    <h2 class="text-xl font-bold text-black mb-4">Documents & Finalisation</h2>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <p class="text-sm text-blue-800">
            <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            Téléchargez vos documents pour obtenir le badge de certifié
        </p>
    </div>

    <!-- CIN -->
    <div>
        <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
            Numéro CIN <span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            wire:model="CIN"
            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all"
            placeholder="AB123456"
            maxlength="20"
        />
        @error('CIN') 
            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <!-- Niveau d'études -->
    <div>
        <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
            Niveau d'études <span class="text-red-500">*</span>
        </label>
        <select
            wire:model="niveauEtudes"
            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all"
        >
            <option value="">Sélectionnez votre niveau</option>
            <option value="Bac">Bac</option>
            <option value="Bac+2">Bac+2</option>
            <option value="Licence">Licence (Bac+3)</option>
            <option value="Master">Master (Bac+5)</option>
            <option value="Doctorat">Doctorat (Bac+8)</option>
        </select>
        @error('niveauEtudes') 
            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <!-- Upload Diplôme -->
        <div>
            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                Diplôme ou Certificat
            </label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-[#2B5AA8] transition-all cursor-pointer">
                <input 
                    type="file" 
                    wire:model="diplome" 
                    class="hidden" 
                    id="diplome-upload"
                    accept=".pdf,.jpg,.jpeg,.png"
                />
                <label for="diplome-upload" class="cursor-pointer">
                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <p class="text-sm text-gray-600">
                        Cliquez pour télécharger
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        PDF, JPG, PNG (max 5MB)
                    </p>
                </label>
            </div>
            @if($diplome)
                <p class="text-sm text-green-600 mt-2">✓ Fichier sélectionné</p>
            @endif
            @error('diplome') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Upload Photo -->
        <div>
            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">
                Photo de profil
            </label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-[#2B5AA8] transition-all cursor-pointer">
                <input 
                    type="file" 
                    wire:model="photo" 
                    class="hidden" 
                    id="photo-upload"
                    accept="image/*"
                />
                <label for="photo-upload" class="cursor-pointer">
                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <p class="text-sm text-gray-600">
                        Cliquez pour télécharger
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        JPG, PNG (max 2MB)
                    </p>
                </label>
            </div>
            @if($photo)
                <p class="text-sm text-green-600 mt-2">✓ Photo sélectionnée</p>
            @endif
            @error('photo') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <p class="text-sm text-yellow-800">
            Vos documents seront vérifiés par notre équipe sous 24-48h
        </p>
    </div>
</div>