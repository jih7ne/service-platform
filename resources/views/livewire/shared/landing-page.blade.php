<div class="min-h-screen bg-white">
    <livewire:shared.header />

    <!-- Hero Section -->
    <section class="relative overflow-hidden min-h-[400px] lg:min-h-[500px] flex items-center">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1723283126735-f24688fcfcc2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHx2aWJyYW50JTIwY29sb3JmdWwlMjBhYnN0cmFjdCUyMHBhdHRlcm58ZW58MXx8fHwxNzY0NTQxNjUwfDA&ixlib=rb-4.1.0&q=80&w=1080"
                 alt="Background"
                 class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-white/90"></div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-3xl lg:text-4xl mb-5 leading-tight font-extrabold text-black">
                    Des services de 
                    <span class="text-[#2B5AA8]">qualité</span>
                    pour votre quotidien
                </h1>
                
                <p class="text-base lg:text-lg mb-6 leading-relaxed text-[#1a1a1a] font-medium">
                    Helpora vous connecte avec des professionnels qualifiés pour le soutien scolaire, 
                    la garde d'enfants et la garde d'animaux.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-3 mb-8">
                    <a href="/services" wire:navigate
                       class="group px-4 py-2.5 bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91] transition-all flex items-center justify-center gap-2 text-sm font-bold shadow-lg">
                        Découvrir nos services
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    
                    <a href="/contact" wire:navigate
                       class="px-4 py-2.5 bg-white border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition-all text-sm text-[#0a0a0a] font-bold shadow-sm">
                        Nous contacter
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 pt-6">
                    <div>
                        <div class="text-2xl mb-1 text-[#2B5AA8] font-extrabold">10k+</div>
                        <div class="text-xs text-[#2a2a2a] font-semibold">Familles</div>
                    </div>
                    <div>
                        <div class="text-2xl mb-1 text-[#B82E6E] font-extrabold">500+</div>
                        <div class="text-xs text-[#2a2a2a] font-semibold">Professionnels</div>
                    </div>
                    <div>
                        <div class="text-2xl mb-1 text-[#C78500] font-extrabold">4.9</div>
                        <div class="text-xs text-[#2a2a2a] font-semibold">Note moyenne</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl mb-4 bg-[#E1EAF7]">
                        <svg class="w-6 h-6 text-[#2B5AA8]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="mb-2 text-[#0a0a0a] font-bold">Professionnels vérifiés</h3>
                    <p class="text-sm leading-relaxed text-[#2a2a2a] font-medium">Tous nos intervenants sont soigneusement sélectionnés</p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl mb-4 bg-[#F9E0ED]">
                        <svg class="w-6 h-6 text-[#B82E6E]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="mb-2 text-[#0a0a0a] font-bold">Disponibilité 24/7</h3>
                    <p class="text-sm leading-relaxed text-[#2a2a2a] font-medium">Un service accessible à tout moment</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl mb-4 bg-[#FFF0D4]">
                        <svg class="w-6 h-6 text-[#C78500]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <h3 class="mb-2 text-[#0a0a0a] font-bold">Qualité garantie</h3>
                    <p class="text-sm leading-relaxed text-[#2a2a2a] font-medium">Satisfaction client au cœur de nos priorités</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-12 bg-[#F7F7F7]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-2xl lg:text-3xl mb-3 text-black font-extrabold">
                    Nos Services
                </h2>
                <p class="max-w-2xl mx-auto text-sm text-[#1a1a1a] font-medium">
                    Choisissez le service adapté à vos besoins parmi notre sélection de prestations de qualité.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-5">
                <!-- Service 1: Soutien Scolaire -->
                <div class="group bg-white rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-500 cursor-pointer shadow-md"
                     onclick="window.location.href='/services'">
                    <div class="relative h-48 overflow-hidden bg-[#E1EAF7] flex items-center justify-center p-6">
                       <img src="{{ asset('images/soutien-scolaire.png') }}"
                             alt="Soutien scolaire"
                             class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700" />
                        <div class="absolute top-4 right-4 w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-[#2B5AA8]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="mb-2 text-[#0a0a0a] font-bold">Soutien scolaire</h3>
                        <p class="text-sm mb-4 leading-relaxed text-[#2a2a2a] font-medium">
                            Des professeurs qualifiés pour accompagner votre enfant dans sa réussite scolaire.
                        </p>
                    </div>
                </div>

                <!-- Service 2: Babysitter -->
                <div class="group bg-white rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-500 cursor-pointer shadow-md"
                     onclick="window.location.href='/services'">
                    <div class="relative h-48 overflow-hidden bg-[#F9E0ED] flex items-center justify-center p-6">
                        <img src="{{ asset('images/babysitter.png') }}"
                             alt="Babysitter"
                             class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700" />
                        <div class="absolute top-4 right-4 w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-[#B82E6E]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="mb-2 text-[#0a0a0a] font-bold">Babysitter</h3>
                        <p class="text-sm mb-4 leading-relaxed text-[#2a2a2a] font-medium">
                            Des babysitters expérimentés et de confiance pour prendre soin de vos enfants.
                        </p>
                    </div>
                </div>

                <!-- Service 3: Petkeeper -->
                <div class="group bg-white rounded-2xl overflow-hidden hover:shadow-2xl transition-all duration-500 cursor-pointer shadow-md"
                     onclick="window.location.href='/services'">
                    <div class="relative h-48 overflow-hidden bg-[#FFF0D4] flex items-center justify-center p-6">
                         <img src="{{ asset('images/petkeeper.png') }}"
                             alt="Petkeeper"
                             class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700" />
                        <div class="absolute top-4 right-4 w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-[#C78500]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="mb-2 text-[#0a0a0a] font-bold">Petkeeper</h3>
                        <p class="text-sm mb-4 leading-relaxed text-[#2a2a2a] font-medium">
                            Des gardiens passionnés pour veiller sur vos animaux de compagnie.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-12 bg-[#2B5AA8]">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl lg:text-3xl text-white mb-3 font-extrabold">
                Prêt à commencer ?
            </h2>
            <p class="text-sm text-white/95 mb-6 max-w-2xl mx-auto font-medium">
                Rejoignez des milliers de familles qui font confiance à Helpora pour leurs besoins quotidiens.
            </p>
            <a href="/inscription" wire:navigate
               class="inline-block px-6 py-3 bg-white rounded-xl hover:bg-gray-50 transition-all text-sm text-[#0a0a0a] font-bold shadow-lg">
                Créer un compte gratuitement
            </a>
        </div>
    </section>

    <livewire:shared.footer />
</div>