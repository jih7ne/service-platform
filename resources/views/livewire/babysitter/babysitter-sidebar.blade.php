@php
    // Ensure $babysitter is always defined to avoid undefined variable errors in views
    $babysitter = $babysitter ?? null;

    // Build a safe display name
    $given = $babysitter?->utilisateur?->prenom ?? '';
    $family = $babysitter?->utilisateur?->nom ?? '';
    $babysitterName = trim(sprintf('%s %s', $given, $family)) ?: 'Babysitter';

    $babysitterRating = $babysitter?->utilisateur?->note ?? 0;
    $babysitterPhoto = $babysitter?->utilisateur?->photo ?? null;
    $pendingRequestsCount = \App\Models\Babysitting\DemandeIntervention::where('idIntervenant', auth()->id())
        ->where('statut', 'en_attente')
        ->count();
@endphp

<!-- Sidebar -->
<div class="w-64 bg-white shadow-lg h-screen fixed left-0 top-0 border-r border-gray-200 z-50">
    <!-- Logo -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <div
                class="w-10 h-10 bg-gradient-to-r from-pink-500 to-rose-500 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-lg">H</span>
            </div>
            <span class="text-xl font-bold text-gray-800">Helpora</span>
        </div>
        <p class="text-xs text-gray-500 mt-1 ml-1">Espace Babysitter</p>
    </div>

    <!-- Babysitter Profile Section -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            @if($babysitterPhoto)
                <img src="{{ asset('storage/' . $babysitterPhoto) }}" alt="{{ $babysitterName }}"
                    class="w-12 h-12 rounded-full object-cover border-2 border-pink-100">
            @else
                <div
                    class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center text-pink-600 font-bold border-2 border-pink-50">
                    {{ substr($babysitterName, 0, 1) }}
                </div>
            @endif
            <div>
                <div class="font-semibold text-gray-800 text-sm">{{ $babysitterName }}</div>
                <div class="flex items-center space-x-1 mt-0.5">
                    <span class="text-yellow-500 text-xs">★</span>
                    <span class="text-xs text-gray-600 font-medium">{{ number_format($babysitterRating, 1) }}</span>
                    @if($babysitterRating >= 4.5)
                        <span
                            class="text-[10px] bg-pink-100 text-pink-800 px-1.5 py-0.5 rounded-full font-medium border border-pink-200">Expert</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="p-4">
        <!-- Return Button -->
        <div class="mb-4">
            <a href="{{ route('intervenant.hub') }}"
                class="w-full text-left px-4 py-3 rounded-lg flex items-center space-x-3 transition-colors text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Retour à l'espace intervenant</span>
            </a>
        </div>

        <ul class="space-y-2">
            <li>
                <a href="{{ route('babysitter.dashboard') }}" wire:navigate
                    class="w-full text-left px-4 py-3 rounded-lg flex items-center space-x-3 transition-colors
                          {{ request()->routeIs('babysitter.dashboard') ? 'bg-pink-50 text-pink-600 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Tableau de bord</span>
                </a>
            </li>

            <li>
                <a href="{{ route('babysitter.demandes') }}" wire:navigate
                    class="w-full text-left px-4 py-3 rounded-lg flex items-center space-x-3 transition-colors
                          {{ request()->routeIs('babysitter.demandes') ? 'bg-pink-50 text-pink-600 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span>Demandes</span>
                    @if($pendingRequestsCount > 0)
                        <span class="ml-auto bg-pink-500 text-white text-xs px-2 py-0.5 rounded-full font-bold">
                            {{ $pendingRequestsCount }}
                        </span>
                    @endif
                </a>
            </li>

            <li>
                <a href="{{ route('babysitter.disponibilites') }}" wire:navigate
                    class="w-full text-left px-4 py-3 rounded-lg flex items-center space-x-3 transition-colors
                          {{ request()->routeIs('babysitter.disponibilites') ? 'bg-pink-50 text-pink-600 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Disponibilités</span>
                </a>
            </li>


            <li>
                <a href="{{ route('babysitter.avis') }}" wire:navigate
                    class="w-full text-left px-4 py-3 rounded-lg flex items-center space-x-3 transition-colors
                          {{ request()->routeIs('babysitter.avis') ? 'bg-pink-50 text-pink-600 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    <span>Avis</span>
                </a>
            </li>

            <li>
                <a href="{{ route('babysitter.profile') }}"
                    class="w-full text-left px-4 py-3 rounded-lg flex items-center space-x-3 transition-colors
                          {{ request()->routeIs('babysitter.profile') ? 'bg-pink-50 text-pink-600 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Mon profil</span>
                </a>
            </li>

        </ul>
    </nav>
</div>