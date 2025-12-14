<div class="min-h-screen bg-gray-50 font-sans">
    <!-- Header Section with Gradient like listing page -->
    <div class="relative bg-white overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-[#B82E6E]/5 to-[#B82E6E]/10 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 mb-8 text-sm font-medium text-gray-500">
                <a href="/" wire:navigate class="hover:text-[#B82E6E] transition-colors flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Accueil
                </a>
                <span class="text-gray-300">/</span>
                <a href="/services" wire:navigate class="hover:text-[#B82E6E] transition-colors">
                    Services
                </a>
                <span class="text-gray-300">/</span>
                <span class="text-[#B82E6E] font-bold">Inscription Réussie</span>
            </nav>
        </div>
    </div>

    <!-- Success Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Success Header with Gradient -->
            <div class="bg-gradient-to-r from-[#B82E6E] to-[#D94686] px-8 py-12 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-white mb-4">
                    Candidature Soumise avec Succès !
                </h1>
                <p class="text-white/90 text-lg max-w-2xl mx-auto">
                    Votre candidature babysitter a été prise en charge et est actuellement en cours de validation
                </p>
            </div>

            <!-- Success Details -->
            <div class="px-8 py-12">
                <div class="text-center mb-10">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-pink-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">
                        Merci pour votre inscription !
                    </h2>
                    <p class="text-gray-600 max-w-lg mx-auto">
                        Nous avons bien reçu votre dossier. Notre équipe va l'examiner attentivement et vous contactera sous 48h pour vous informer de la suite.
                    </p>
                </div>

                <!-- Next Steps -->
                <div class="bg-gray-50 rounded-xl p-8 mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#B82E6E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Prochaines Étapes
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center mt-0.5">
                                <span class="text-pink-600 text-sm font-bold">1</span>
                            </div>
                            <p class="ml-3 text-gray-700">Validation de votre dossier par notre équipe (24-48h)</p>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center mt-0.5">
                                <span class="text-pink-600 text-sm font-bold">2</span>
                            </div>
                            <p class="ml-3 text-gray-700">Email de confirmation avec votre statut</p>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center mt-0.5">
                                <span class="text-pink-600 text-sm font-bold">3</span>
                            </div>
                            <p class="ml-3 text-gray-700">Activation de votre profil pour recevoir des missions</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-blue-900 mb-1">Besoin d'aide ?</h4>
                            <p class="text-blue-800 text-sm">
                                Contactez notre support à 
                                <a href="mailto:support@helpora.com" class="underline hover:text-blue-900">support@helpora.com</a>
                                ou par téléphone au 
                                <a href="tel:0612345678" class="underline hover:text-blue-900">06 12 34 56 78</a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/" wire:navigate
                        class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-[#B82E6E] to-[#D94686] text-white font-semibold rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Retour à l'accueil
                    </a>
         
                </div>
            </div>
        </div>
    </div>
</div>
