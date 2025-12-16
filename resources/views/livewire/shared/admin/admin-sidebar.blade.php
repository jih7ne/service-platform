<div 
    class="bg-white border-r border-gray-200 sticky top-0 transition-all duration-300 flex flex-col {{ $isCollapsed ? 'w-16' : 'w-56' }}"
    style="box-shadow: 2px 0 10px rgba(0, 0, 0, 0.04); height: 100vh; max-height: 100vh;"
>
    {{-- Header --}}
    <div class="p-3 border-b border-gray-200 flex-shrink-0">
        <div class="flex items-center justify-between">
            @if(!$isCollapsed)
                <h1 class="text-lg text-[#2B5AA8]" style="font-weight: 800;">
                    Helpora
                </h1>
            @endif
            <button
                wire:click="toggleCollapse"
                class="p-1 rounded-lg hover:bg-gray-100 transition-all"
            >
                @if($isCollapsed)
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                @endif
            </button>
        </div>
        @if(!$isCollapsed)
            <p class="text-xs mt-0.5" style="color: #6b7280; font-weight: 600;">
                Espace Administration
            </p>
        @endif
    </div>

    {{-- Menu Items --}}
    <nav class="flex-1 p-2 space-y-1 overflow-y-auto min-h-0">
        {{-- Dashboard --}}
        <button
            wire:click="navigate('admin-dashboard')"
            class="w-full flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-all {{ $currentPage === 'admin-dashboard' ? 'bg-[#2B5AA8] text-white' : 'hover:bg-gray-100 text-[#3a3a3a]' }}"
            style="font-weight: {{ $currentPage === 'admin-dashboard' ? '700' : '600' }}; box-shadow: {{ $currentPage === 'admin-dashboard' ? '0 2px 8px rgba(43, 90, 168, 0.3)' : 'none' }};"
            title="{{ $isCollapsed ? 'Dashboard' : '' }}"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="7" height="9" x="3" y="3" rx="1"/>
                <rect width="7" height="5" x="14" y="3" rx="1"/>
                <rect width="7" height="9" x="14" y="12" rx="1"/>
                <rect width="7" height="5" x="3" y="16" rx="1"/>
            </svg>
            @if(!$isCollapsed)
                <span>Dashboard</span>
            @endif
        </button>

        {{-- Utilisateurs --}}
        <button
            wire:click="navigate('admin-users')"
            class="w-full flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-all {{ $currentPage === 'admin-users' ? 'bg-[#2B5AA8] text-white' : 'hover:bg-gray-100 text-[#3a3a3a]' }}"
            style="font-weight: {{ $currentPage === 'admin-users' ? '700' : '600' }}; box-shadow: {{ $currentPage === 'admin-users' ? '0 2px 8px rgba(43, 90, 168, 0.3)' : 'none' }};"
            title="{{ $isCollapsed ? 'Utilisateurs' : '' }}"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            @if(!$isCollapsed)
                <span>Utilisateurs</span>
            @endif
        </button>

        {{-- Réclamations --}}
        <button
            wire:click="navigate('admin-complaints')"
            class="w-full flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-all {{ $currentPage === 'admin-complaints' ? 'bg-[#2B5AA8] text-white' : 'hover:bg-gray-100 text-[#3a3a3a]' }}"
            style="font-weight: {{ $currentPage === 'admin-complaints' ? '700' : '600' }}; box-shadow: {{ $currentPage === 'admin-complaints' ? '0 2px 8px rgba(43, 90, 168, 0.3)' : 'none' }};"
            title="{{ $isCollapsed ? 'Réclamations' : '' }}"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
            @if(!$isCollapsed)
                <span>Réclamations</span>
            @endif
        </button>

        {{-- Gestion des intervenants --}}
        <button
            wire:click="navigate('admin-intervenants')"
            class="w-full flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-all {{ $currentPage === 'admin-intervenants' ? 'bg-[#2B5AA8] text-white' : 'hover:bg-gray-100 text-[#3a3a3a]' }}"
            style="font-weight: {{ $currentPage === 'admin-intervenants' ? '700' : '600' }}; box-shadow: {{ $currentPage === 'admin-intervenants' ? '0 2px 8px rgba(43, 90, 168, 0.3)' : 'none' }};"
            title="{{ $isCollapsed ? 'Gestion des intervenants' : '' }}"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="20" height="14" x="2" y="7" rx="2" ry="2"/>
                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
            </svg>
            @if(!$isCollapsed)
                <span>Intervenants</span>
            @endif
        </button>
    </nav>

    {{-- Logout --}}
    <div class="p-2 border-t border-gray-200 flex-shrink-0">
        <form method="POST" action="{{ route('logout') }}" class="w-full">
    @csrf
    <button
        type="submit"
        class="w-full flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-red-50 text-red-600 transition-all"
        style="font-weight: 600;"
        title="{{ $isCollapsed ? 'Déconnexion' : '' }}"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
            <polyline points="16 17 21 12 16 7"/>
            <line x1="21" x2="9" y1="12" y2="12"/>
        </svg>
        @if(!$isCollapsed)
            <span>Déconnexion</span>
        @endif
    </button>
</form>
    </div>
</div>