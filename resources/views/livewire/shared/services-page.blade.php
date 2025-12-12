<div class="min-h-screen bg-[#F7F7F7]">
    <livewire:shared.header />

    <!-- Header -->
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center">
            <h1 class="text-3xl mb-2 text-black font-extrabold">
                Nos Services
            </h1>
            <p class="text-[#3a3a3a] font-semibold">
                Choisissez le service dont vous avez besoin
            </p>
        </div>
    </div>

    <!-- Services Grid -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid md:grid-cols-3 gap-5">
            <!-- Service 1: Soutien Scolaire -->
            <div class="bg-white rounded-2xl p-5 border border-gray-100 hover:shadow-2xl transition-all duration-300 cursor-pointer group shadow-md">
                <!-- Icon -->
                <div class="w-16 h-16 mx-auto mb-4 rounded-xl flex items-center justify-center bg-[#E1EAF7]">
                    <svg class="w-8 h-8 text-[#2B5AA8]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>

                <!-- Title -->
                <h3 class="text-lg mb-3 text-center text-black font-extrabold">
                    Soutien Scolaire
                </h3>

                <!-- Description -->
                <p class="text-center mb-5 leading-relaxed text-sm text-[#3a3a3a] font-semibold">
                    Trouvez des professeurs qualifiés pour tous niveaux et matières
                </p>

               <!-- Button -->
                <a href="{{ route('professors-list') }}" wire:navigate class="w-full py-2.5 rounded-lg flex items-center justify-center gap-2 group-hover:gap-3 transition-all text-sm bg-[#2B5AA8] text-white font-bold shadow-md hover:shadow-lg">
                    Découvrir
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- Service 2: Babysitters -->
            <div class="bg-white rounded-2xl p-5 border border-gray-100 hover:shadow-2xl transition-all duration-300 cursor-pointer group shadow-md">
                <!-- Icon -->
                <div class="w-16 h-16 mx-auto mb-4 rounded-xl flex items-center justify-center bg-[#F7E1EC]">
                    <svg class="w-8 h-8 text-[#B82E6E]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <!-- Title -->
                <h3 class="text-lg mb-3 text-center text-black font-extrabold">
                    Babysitters
                </h3>

                <!-- Description -->
                <p class="text-center mb-5 leading-relaxed text-sm text-[#3a3a3a] font-semibold">
                    Des babysitters de confiance pour garder vos enfants
                </p>

                <!-- Button -->
                <button class="w-full py-2.5 rounded-lg flex items-center justify-center gap-2 group-hover:gap-3 transition-all text-sm bg-[#B82E6E] text-white font-bold shadow-md hover:shadow-lg">
                    Découvrir
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <!-- Service 3: Garde d'Animaux -->
            <div class="bg-white rounded-2xl p-5 border border-gray-100 hover:shadow-2xl transition-all duration-300 cursor-pointer group shadow-md">
                <!-- Icon -->
                <div class="w-16 h-16 mx-auto mb-4 rounded-xl flex items-center justify-center bg-[#FFF3E0]">
                    <svg class="w-8 h-8 text-[#C78500]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                </div>

                <!-- Title -->
                <h3 class="text-lg mb-3 text-center text-black font-extrabold">
                    Garde d'Animaux
                </h3>

                <!-- Description -->
                <p class="text-center mb-5 leading-relaxed text-sm text-[#3a3a3a] font-semibold">
                    Des professionnels pour prendre soin de vos animaux
                </p>

                <!-- Button -->
                <button class="w-full py-2.5 rounded-lg flex items-center justify-center gap-2 group-hover:gap-3 transition-all text-sm bg-[#C78500] text-white font-bold shadow-md hover:shadow-lg">
                    Découvrir
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <livewire:shared.footer />
</div>