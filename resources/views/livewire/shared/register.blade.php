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

                <!-- Séparateur -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Ou continuer avec</span>
                    </div>
                </div>

                <!-- Bouton Google -->
                <div class="mb-6">
                    <a href="{{ route('auth.google') }}" 
                       class="w-full flex justify-center items-center px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Continuer avec Google
                    </a>
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