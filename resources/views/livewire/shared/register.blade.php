<div class="min-h-screen bg-white">
    <livewire:shared.header />

    <div class="min-h-screen bg-[#F7F7F7] py-12 flex items-center justify-center">
        <div class="max-w-2xl w-full mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Choix du type de compte -->
            <div class="bg-white rounded-2xl p-8 shadow-md border border-gray-100">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl mb-2 text-black font-extrabold">
                        Créer votre compte
                    </h1>
                </div>

                <!-- Question -->
                <div class="mb-8">
                    <h2 class="text-lg text-black font-bold mb-6">
                        Quel type de compte souhaitez-vous créer ?
                    </h2>

                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Option Client -->
                        <a href="/inscriptionClient" class="relative cursor-pointer block">
                            <div class="p-6 border-2 rounded-xl transition-all hover:border-[#2B5AA8] hover:bg-blue-50 border-gray-300 bg-white">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-[#2B5AA8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-black mb-1">Client</h3>
                                        <p class="text-sm text-[#2a2a2a] font-medium">Je recherche des services</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <!-- Option Intervenant -->
                        <a href="/inscriptionIntervenant" class="relative cursor-pointer block">
                            <div class="p-6 border-2 rounded-xl transition-all hover:border-[#B82E6E] hover:bg-pink-50 border-gray-300 bg-white">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-[#B82E6E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-black mb-1">Intervenant</h3>
                                        <p class="text-sm text-[#2a2a2a] font-medium">Je propose mes services</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Lien retour -->
                <div class="flex flex-col items-center gap-4">
                    <a href="/connexion" class="text-sm text-[#2B5AA8] hover:underline font-semibold">
                        Retour à la page d'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <livewire:shared.footer />
</div>