@php
    $pendingRequestsCount = 0;
    if ($babysitter && $babysitter->utilisateur) {
        $pendingRequestsCount = \App\Models\Babysitting\DemandeIntervention::where('idIntervenant', $babysitter->utilisateur->id)
            ->where('statut', 'en_attente')
            ->count();
    }
@endphp

<!-- Sidebar -->
<div class="w-64 bg-white shadow-lg h-screen fixed left-0 top-0 z-40">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-bold text-purple-600">Helpora</h2>
        <p class="text-sm text-gray-600">Espace Babysitter</p>
    </div>

    <!-- Profile Section -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            @if($babysitter?->utilisateur?->photo)
                <img src="{{ asset('storage/' . $babysitter->utilisateur->photo) }}" alt="Profile"
                    class="w-12 h-12 rounded-full object-cover">
            @else
                <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                    <span
                        class="text-gray-600 font-bold">{{ substr($babysitter?->utilisateur?->prenom ?? 'B', 0, 1) }}</span>
                </div>
            @endif
            <div class="flex-1">
                <h3 class="font-semibold text-gray-800">{{ $babysitter?->utilisateur?->prenom ?? 'Babysitter' }}</h3>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="p-6">
        <ul class="space-y-2">
            <li>
                <a href="/test-babysitter-dashboard/{{ $babysitter?->utilisateur?->id ?? 1 }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ $currentPage === 'dashboard' ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/test-babysitter-profile/{{ $babysitter?->utilisateur?->id ?? 1 }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ $currentPage === 'profile' ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Mon Profil</span>
                </a>
            </li>
            <li>
                <a href="#"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Mes Gardes</span>
                </a>
            </li>
            <li>
                <a href="#"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span>Notifications
                        @if($pendingRequestsCount > 0)
                            <span
                                class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $pendingRequestsCount }}</span>
                        @endif
                    </span>
                </a>
            </li>
            <li>
                <a href="#"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Revenus</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Bottom Section -->
    <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-gray-200">
        <a href="/logout"
            class="flex items-center space-x-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span>Déconnexion</span>
        </a>
    </div>
</div>