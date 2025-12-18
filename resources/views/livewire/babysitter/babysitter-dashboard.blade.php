<div class="min-h-screen bg-[#F3F4F6] font-sans flex text-left">

    <!-- Sidebar -->
    @include('livewire.babysitter.babysitter-sidebar')

    <!-- Main Content -->
    <div class="ml-64 flex-1 flex flex-col min-h-screen">

        <!-- En-tête (Header) avec date et profil -->
        <header class="bg-white shadow-sm border-b border-gray-100 py-6 px-8">
            <div class="max-w-6xl mx-auto flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-800">
                        Bonjour {{ $babysitter?->utilisateur?->prenom ?? 'Babysitter' }} <span
                            class="text-2xl">👋</span>
                    </h1>
                    <p class="text-gray-500 mt-1">Voici un aperçu de votre activité</p>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-800">{{ $babysitter?->utilisateur?->nom ?? '' }}
                            {{ $babysitter?->utilisateur?->prenom ?? '' }}
                        </p>
                        <p class="text-xs text-green-500 font-semibold flex items-center justify-end">
                            <span class="w-2 h-2 rounded-full bg-green-500 mr-1 animate-pulse"></span> En ligne
                        </p>
                    </div>
                    <a href="{{ route('babysitter.profile') }}" class="block">
                        @if($babysitter?->utilisateur?->photo)
                            <img src="{{ asset('storage/' . $babysitter->utilisateur->photo) }}" alt="Profile"
                                class="w-10 h-10 rounded-full object-cover border-2 border-pink-100">
                        @else
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-500 to-rose-600 text-white flex items-center justify-center font-bold text-lg shadow-lg">
                                {{ substr($babysitter?->utilisateur?->prenom ?? 'B', 0, 1) }}
                            </div>
                        @endif
                    </a>
                </div>
            </div>
        </header>

        <!-- Contenu Principal -->
        <main class="flex-grow p-8">
            <div class="max-w-6xl mx-auto">
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Average Rating Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                            <span class="text-sm text-gray-500">Note moyenne</span>
                        </div>
                        <div class="flex items-baseline">
                            <span class="text-2xl font-bold text-gray-800">{{ $statistics['averageRating'] }}</span>
                            <span class="text-yellow-500 ml-2">★</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">Basée sur {{ $babysitter?->utilisateur?->nbrAvis ?? 0 }}
                            avis</p>
                    </div>

                    <!-- Completed Sittings Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-sm text-gray-500">Gardes complètes</span>
                        </div>
                        <div class="flex items-baseline">
                            <span class="text-2xl font-bold text-gray-800">{{ $statistics['completedSittings'] }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">Total des missions</p>
                    </div>

                    <!-- Pending Requests Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-[#E0B2CD] rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-[#4A132F]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </div>
                            <span class="text-sm text-gray-500">Demandes en attente</span>
                        </div>
                        <div class="flex items-baseline">
                            <span class="text-2xl font-bold text-gray-800">{{ $statistics['pendingRequests'] }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">À traiter</p>
                    </div>

                    <!-- Total Earnings Card #E0B2CD-->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-[#D5E2EE] rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-[#132F4A]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-sm text-gray-500">Revenus totaux</span>
                        </div>
                        <div class="flex items-baseline">
                            <span
                                class="text-2xl font-bold text-gray-800">{{ number_format($statistics['totalEarnings'], 0) }}</span>
                            <span class="text-gray-600 ml-2">MAD</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">Cette année</p>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Monthly Earnings Chart -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100" wire:ignore>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Revenus mensuels</h3>
                        <div class="h-64">
                            <canvas id="earningsChart"></canvas>
                        </div>
                    </div>

                    <!-- Rating Distribution Chart -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100" wire:ignore>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribution des notes</h3>
                        <div class="h-64">
                            <canvas id="ratingChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Performance Metrics -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Response Rate -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Taux de réponse</h3>
                        <div class="flex items-center justify-center">
                            <div class="relative w-32 h-32">
                                <svg class="w-32 h-32 transform -rotate-90">
                                    <circle cx="64" cy="64" r="56" stroke="#e5e7eb" stroke-width="12" fill="none" />
                                    <circle cx="64" cy="64" r="56" stroke="#F5D0E3" stroke-width="12" fill="none"
                                        stroke-dasharray="{{ 351.86 * $statistics['responseRate'] / 100 }} 351.86"
                                        stroke-linecap="round" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span
                                        class="text-2xl font-bold text-gray-800">{{ $statistics['responseRate'] }}%</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-center text-gray-600 mt-4">Des demandes acceptées/refusées</p>
                    </div>

                    <!-- On Time Rate -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Ponctualité</h3>
                        <div class="flex items-center justify-center">
                            <div class="relative w-32 h-32">
                                <svg class="w-32 h-32 transform -rotate-90">
                                    <circle cx="64" cy="64" r="56" stroke="#e5e7eb" stroke-width="12" fill="none" />
                                    <circle cx="64" cy="64" r="56" stroke="#E89BC4" stroke-width="12" fill="none"
                                        stroke-dasharray="{{ 351.86 * $statistics['onTimeRate'] / 100 }} 351.86"
                                        stroke-linecap="round" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span
                                        class="text-2xl font-bold text-gray-800">{{ $statistics['onTimeRate'] }}%</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-center text-gray-600 mt-4">Des gardes à l'heure</p>
                    </div>
                </div>




            </div>
        </main>
    </div>
</div>

<!-- Chart.js Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let earningsChart = null;
    let ratingChart = null;

    function initEarningsChart(data) {
        if (earningsChart) { earningsChart.destroy(); }
        const ctx = document.getElementById('earningsChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(143, 36, 88, 0.3)');
        gradient.addColorStop(1, 'rgba(245, 208, 227, 0.1)');

        earningsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.map(i => i.month),
                datasets: [{
                    label: 'Revenus (MAD)',
                    data: data.map(i => i.earnings),
                    borderColor: '#8F2458',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    pointBackgroundColor: '#8F2458',
                    pointBorderColor: '#FFFFFF',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { color: '#8F2458' } },
                    x: { ticks: { color: '#8F2458' } }
                }
            }
        });
    }

    function initRatingChart(data) {
        if (ratingChart) { ratingChart.destroy(); }
        const ctx = document.getElementById('ratingChart').getContext('2d');
        ratingChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(i => i.label),
                datasets: [{
                    label: 'Nombre d\'avis',
                    data: data.map(i => i.count),
                    backgroundColor: [
                        'rgba(251, 191, 36, 0.8)',
                        'rgba(251, 191, 36, 0.7)',
                        'rgba(251, 191, 36, 0.6)',
                        'rgba(251, 191, 36, 0.5)',
                        'rgba(251, 191, 36, 0.4)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
    }

    document.addEventListener('livewire:init', () => {
        // Initial load
        initEarningsChart(@json($monthlyEarnings));
        initRatingChart(@json($ratingDistribution));

        // Re-init on DOM updates (simplest fix for disappearing charts on poll)
        Livewire.hook('morph.updated', ({ el, component }) => {
             // Optional: specific check
        });

        // Listen for specific chart updates from Livewire
        Livewire.on('updateCharts', (data) => {
             if(data && data[0]) {
                 initEarningsChart(data[0].monthlyEarnings);
                 initRatingChart(data[0].ratingDistribution);
             }
        });
    });
</script>