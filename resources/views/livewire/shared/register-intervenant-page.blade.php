<div class="min-h-screen bg-white">
    <livewire:shared.header />

    <div class="min-h-screen bg-[#F7F7F7] py-12 flex items-center justify-center">
        <div class="max-w-3xl w-full mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Formulaire d'inscription Intervenant -->
            <div class="bg-white rounded-2xl p-8 shadow-md border border-gray-100">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl mb-2 text-black font-extrabold">
                        Créer votre compte
                    </h1>
                </div>

                <!-- Form -->
                <form wire:submit.prevent="register" class="space-y-6">
                    <!-- Étape 1: Type de compte -->
                    <div>
                        <h2 class="text-base text-black font-bold mb-4">
                            Quel type de compte souhaitez-vous créer ?
                        </h2>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Option Client -->
                            <label class="relative cursor-pointer">
                                <input 
                                    type="radio" 
                                    wire:model.live="accountType" 
                                    value="client"
                                    class="peer sr-only"
                                />
                                <div class="h-full p-4 border-2 rounded-xl transition-all peer-checked:border-[#2B5AA8] peer-checked:bg-blue-50 hover:border-gray-400 border-gray-300 bg-white">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-[#2B5AA8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-black text-base">Client</h3>
                                            <p class="text-sm text-[#6b7280]">Je recherche des services</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Option Intervenant -->
                            <label class="relative cursor-pointer">
                                <input 
                                    type="radio" 
                                    wire:model.live="accountType" 
                                    value="intervenant"
                                    class="peer sr-only"
                                />
                                <div class="h-full p-4 border-2 rounded-xl transition-all peer-checked:border-[#B82E6E] peer-checked:bg-pink-50 hover:border-gray-400 border-gray-300 bg-white">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-[#B82E6E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-black text-base">Intervenant</h3>
                                            <p class="text-sm text-[#6b7280]">Je propose mes services</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Étape 2: Type de service (visible seulement si intervenant) -->
                    @if($accountType === 'intervenant')
                    <div>
                        <h2 class="text-base text-black font-bold mb-4">
                            Quel service souhaitez-vous proposer ?
                        </h2>

                        <div class="grid grid-cols-3 gap-4">
                            <!-- Professeur -->
                            <label class="relative cursor-pointer">
                                <input 
                                    type="radio" 
                                    wire:model.live="serviceType" 
                                    value="professeur"
                                    class="peer sr-only"
                                />
                                <div class="h-full p-6 border-2 rounded-xl transition-all peer-checked:border-[#B82E6E] peer-checked:bg-pink-50 hover:border-gray-400 border-gray-300 bg-white">
                                    <div class="flex flex-col items-center gap-3 text-center">
                                        <div class="text-4xl">📚</div>
                                        <div>
                                            <h3 class="font-bold text-black mb-1">Professeur</h3>
                                            <p class="text-sm text-[#6b7280]">Cours de soutien scolaire</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Babysitter -->
                            <label class="relative cursor-pointer">
                                <input 
                                    type="radio" 
                                    wire:model.live="serviceType" 
                                    value="babysitter"
                                    class="peer sr-only"
                                />
                                <div class="h-full p-6 border-2 rounded-xl transition-all peer-checked:border-[#B82E6E] peer-checked:bg-pink-50 hover:border-gray-400 border-gray-300 bg-white">
                                    <div class="flex flex-col items-center gap-3 text-center">
                                        <div class="text-4xl">😊</div>
                                        <div>
                                            <h3 class="font-bold text-black mb-1">Babysitter</h3>
                                            <p class="text-sm text-[#6b7280]">Garde d'enfants</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- PetKeeper -->
                            <label class="relative cursor-pointer">
                                <input 
                                    type="radio" 
                                    wire:model.live="serviceType" 
                                    value="petkeeper"
                                    class="peer sr-only"
                                />
                                <div class="h-full p-6 border-2 rounded-xl transition-all peer-checked:border-[#B82E6E] peer-checked:bg-pink-50 hover:border-gray-400 border-gray-300 bg-white">
                                    <div class="flex flex-col items-center gap-3 text-center">
                                        <div class="text-4xl">🐕</div>
                                        <div>
                                            <h3 class="font-bold text-black mb-1">PetKeeper</h3>
                                            <p class="text-sm text-[#6b7280]">Garde d'animaux</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('serviceType') 
                            <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
                        @enderror
                    </div>
                    @endif

                    <!-- Boutons -->
                    <div class="flex flex-col gap-3 pt-4">
                        <button
                            type="submit"
                            class="w-full py-3.5 bg-[#2B5AA8] text-white rounded-xl hover:bg-[#224A91] transition-all font-bold shadow-md flex items-center justify-center gap-2"
                        >
                            Continuer
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                        <a
                            href="/inscription"
                            class="w-full py-3.5 bg-white border-2 border-gray-300 rounded-xl hover:bg-gray-50 transition-all text-black font-bold text-center"
                        >
                            Retour
                        </a>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <a href="/" class="text-sm text-[#2B5AA8] hover:underline font-semibold">
                        Retour à la page d'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <livewire:shared.footer />
</div>