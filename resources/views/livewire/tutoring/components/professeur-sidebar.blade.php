<div 
    class="bg-white border-r border-gray-100 sticky top-0 transition-all duration-300 flex flex-col shadow-sm {{ $isCollapsed ? 'w-16' : 'w-72' }}"
    style="height: 100vh; max-height: 100vh;"
>
    {{-- Header avec Logo --}}
    <div class="py-6 flex items-center border-b border-gray-100 flex-shrink-0 {{ $isCollapsed ? 'px-3 justify-center' : 'px-6 justify-between' }}">
        @if(!$isCollapsed)
            <span class="text-2xl font-bold text-gray-800">Helpora</span>
        @endif
        <button
            wire:click="toggleCollapse"
            class="p-2 rounded-lg hover:bg-gray-100 transition-all"
            title="{{ $isCollapsed ? 'Agrandir' : 'Réduire' }}"
        >
            @if($isCollapsed)
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 18 6-6-6-6"/>
                </svg>
            @else
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 18-6-6 6-6"/>
                </svg>
            @endif
        </button>
    </div>

    {{-- Carte Profil --}}
    @if(!$isCollapsed)
        <div class="px-6 py-6 flex-shrink-0">
            <a 
                href="{{ route('tutoring.profile') }}"
                class="w-full bg-[#EFF6FF] rounded-2xl p-4 flex items-center gap-4 border border-blue-100 hover:bg-blue-50 transition-colors cursor-pointer"
            >
                @if($photo)
                    <img src="{{ asset('storage/'.$photo) }}" class="w-10 h-10 rounded-full object-cover">
                @else
                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">
                        {{ substr($prenom, 0, 1) }}
                    </div>
                @endif
                <div class="text-left">
                    <h3 class="font-bold text-gray-800 text-sm">{{ $prenom }}</h3>
                    <p class="text-xs text-blue-600 font-medium">Professeur</p>
                </div>
            </a>
        </div>
    @else
        <div class="px-3 py-6 flex justify-center flex-shrink-0">
            <a 
                href="{{ route('tutoring.profile') }}"
                class="relative"
                title="{{ $prenom }}"
            >
                @if($photo)
                    <img src="{{ asset('storage/'.$photo) }}" class="w-10 h-10 rounded-full object-cover border-2 border-blue-200 hover:border-blue-400 transition-colors">
                @else
                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold hover:bg-blue-700 transition-colors">
                        {{ substr($prenom, 0, 1) }}
                    </div>
                @endif
            </a>
        </div>
    @endif

    {{-- Navigation Menu --}}
    <nav class="flex-1 px-3 space-y-1 overflow-y-auto min-h-0 {{ $isCollapsed ? 'pt-4' : 'pt-2' }}">
        @if(!$isCollapsed)
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-2">Menu Principal</p>
        @endif
        
        {{-- Bouton Hub Services --}}
        <a 
            href="{{ route('intervenant.hub') }}"
            class="w-full flex items-center rounded-xl font-medium transition-all relative {{ request()->routeIs('intervenant.hub') ? 'bg-[#EFF6FF] text-blue-700 font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} {{ $isCollapsed ? 'justify-center p-3' : 'gap-3 px-4 py-3' }}"
            title="{{ $isCollapsed ? 'Hub Services' : '' }}"
        >
            <svg class="w-5 h-5 {{ $isCollapsed ? 'flex-shrink-0' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            @if(!$isCollapsed)
                <span>Hub Services</span>
            @endif
        </a>
        
        {{-- Tableau de bord --}}
        <a 
            href="{{ route('tutoring.dashboard') }}"
            class="w-full flex items-center rounded-xl font-medium transition-all relative {{ request()->routeIs('tutoring.dashboard') ? 'bg-[#EFF6FF] text-blue-700 font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} {{ $isCollapsed ? 'justify-center p-3' : 'gap-3 px-4 py-3' }}"
            title="{{ $isCollapsed ? 'Tableau de bord' : '' }}"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
            @if(!$isCollapsed)
                <span>Tableau de bord</span>
            @endif
        </a>

        {{-- Mes demandes --}}
        <a 
            href="{{ route('tutoring.requests') }}"
            class="w-full flex items-center rounded-xl font-medium transition-all group relative {{ request()->routeIs('tutoring.requests') ? 'bg-[#EFF6FF] text-blue-700 font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} {{ $isCollapsed ? 'justify-center p-3' : 'gap-3 px-4 py-3' }}"
            title="{{ $isCollapsed ? 'Mes demandes' : '' }}"
        >
            <svg class="w-5 h-5 group-hover:text-blue-600 {{ $isCollapsed ? 'flex-shrink-0' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            @if(!$isCollapsed)
                <span>Mes demandes</span>
                @if($enAttente > 0)
                    <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $enAttente }}</span>
                @endif
            @else
                @if($enAttente > 0)
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                @endif
            @endif
        </a>

        {{-- Disponibilité --}}
        <a 
            href="{{ route('tutoring.disponibilites') }}"
            class="w-full flex items-center rounded-xl font-medium transition-all relative {{ request()->routeIs('tutoring.disponibilites') ? 'bg-[#EFF6FF] text-blue-700 font-bold' : 'text-gray-500 hover:bg-gray-50' }} {{ $isCollapsed ? 'justify-center p-3' : 'gap-3 px-4 py-3' }}"
            title="{{ $isCollapsed ? 'Disponibilité' : '' }}"
        >
            <svg class="w-5 h-5 {{ $isCollapsed ? 'flex-shrink-0' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            @if(!$isCollapsed)
                <span>Disponibilité</span>
            @endif
        </a>

        {{-- Mes clients --}}
        <a 
            href="{{ route('tutoring.clients') }}"
            class="w-full flex items-center rounded-xl font-medium transition-all group relative {{ request()->routeIs('tutoring.clients') ? 'bg-[#EFF6FF] text-blue-700 font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} {{ $isCollapsed ? 'justify-center p-3' : 'gap-3 px-4 py-3' }}"
            title="{{ $isCollapsed ? 'Mes clients' : '' }}"
        >
            <svg class="w-5 h-5 group-hover:text-blue-600 {{ $isCollapsed ? 'flex-shrink-0' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            @if(!$isCollapsed)
                <span>Mes clients</span>
            @endif
        </a>

        {{-- Mes cours --}}
        <a 
            href="{{ route('tutoring.courses') }}"
            class="w-full flex items-center rounded-xl font-medium transition-all group relative {{ request()->routeIs('tutoring.courses') ? 'bg-[#EFF6FF] text-blue-700 font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} {{ $isCollapsed ? 'justify-center p-3' : 'gap-3 px-4 py-3' }}"
            title="{{ $isCollapsed ? 'Mes cours' : '' }}"
        >
            <svg class="w-5 h-5 group-hover:text-blue-600 {{ $isCollapsed ? 'flex-shrink-0' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            @if(!$isCollapsed)
                <span>Mes cours</span>
            @endif
        </a>

        {{-- Mes avis --}}
        <a 
            href="{{ route('tutoring.avis') }}"
            class="w-full flex items-center rounded-xl font-medium transition-all group relative {{ request()->routeIs('tutoring.avis') ? 'bg-[#EFF6FF] text-blue-700 font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }} {{ $isCollapsed ? 'justify-center p-3' : 'gap-3 px-4 py-3' }}"
            title="{{ $isCollapsed ? 'Mes avis' : '' }}"
        >
            <svg class="w-5 h-5 group-hover:text-blue-600 {{ $isCollapsed ? 'flex-shrink-0' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
            @if(!$isCollapsed)
                <span>Mes avis</span>
            @endif
        </a>
    </nav>

    {{-- Déconnexion --}}
    <div class="p-3 border-t border-gray-100 space-y-1 flex-shrink-0">
        <button 
            wire:click="logout" 
            class="w-full flex items-center text-red-500 hover:bg-red-50 rounded-xl font-medium transition-all {{ $isCollapsed ? 'justify-center p-3' : 'gap-3 px-4 py-3' }}"
            title="{{ $isCollapsed ? 'Déconnexion' : '' }}"
        >
            <svg class="w-5 h-5 {{ $isCollapsed ? 'flex-shrink-0' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            @if(!$isCollapsed)
                <span>Déconnexion</span>
            @endif
        </button>
    </div>
</div>