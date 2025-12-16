<div class="p-5">
    {{-- Header --}}
    <div class="mb-5">
        <h1 class="text-2xl mb-1" style="color: #000000; font-weight: 800;">
            Dashboard
        </h1>
        <p class="text-sm" style="color: #6b7280; font-weight: 600;">
            Vue d'ensemble de la plateforme Helpora
        </p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
        @foreach($stats as $stat)
            @php
                $isPositive = str_starts_with($stat['change'], '+');
            @endphp
            <div class="bg-white rounded-xl p-3 border border-gray-100"
                 style="box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center"
                         style="background-color: {{ $stat['bgColor'] }};">
                        @if($stat['icon'] === 'users')
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $stat['color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        @elseif($stat['icon'] === 'message-square')
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $stat['color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                            </svg>
                        @elseif($stat['icon'] === 'briefcase')
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $stat['color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                        @elseif($stat['icon'] === 'trending-up')
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $stat['color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/>
                            </svg>
                        @endif
                    </div>
                    <span class="text-xs px-1.5 py-0.5 rounded-full"
                          style="background-color: {{ $isPositive ? '#D1FAE5' : '#FEE2E2' }}; 
                                 color: {{ $isPositive ? '#059669' : '#DC2626' }}; 
                                 font-weight: 700;">
                        {{ $stat['change'] }}
                    </span>
                </div>
                <p class="text-xs mb-1" style="color: #6b7280; font-weight: 600;">
                    {{ $stat['label'] }}
                </p>
                <p class="text-xl" style="color: #000000; font-weight: 800;">
                    {{ $stat['value'] }}
                </p>
            </div>
        @endforeach
    </div>

    {{-- Charts Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-4">
        {{-- Services par mois --}}
        <div class="bg-white rounded-xl p-4 border border-gray-100 flex flex-col"
             style="box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);">
            <h2 class="text-sm mb-3" style="color: #000000; font-weight: 700;">
                Services par mois
            </h2>
            <div class="flex items-center justify-center flex-1" style="width: 100%; min-height: 250px;">
                <div style="width: 95%; height: 100%;">
                    <canvas id="servicesChart"></canvas>
                </div>
            </div>
        </div>
        {{-- Distribution des services --}}
        <div class="bg-white rounded-xl p-4 border border-gray-100"
             style="box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);">
            <h2 class="text-sm mb-3" style="color: #000000; font-weight: 700;">
                Distribution des services
            </h2>
            <div style="width: 100%; height: 220px; position: relative;">
                <canvas id="distributionChart"></canvas>
            </div>
            <div class="mt-4 space-y-2">
                @foreach($serviceDistribution as $service)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full" style="background-color: {{ $service['color'] }};"></div>
                            <span class="text-sm" style="color: #3a3a3a; font-weight: 600;">
                                {{ $service['name'] }}
                            </span>
                        </div>
                        <span class="text-sm" style="color: #000000; font-weight: 700;">
                            {{ number_format($service['value']) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Demandes par mois --}}
    <div class="bg-white rounded-xl p-4 border border-gray-100 mb-4"
         style="box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);">
        <h2 class="text-sm mb-3" style="color: #000000; font-weight: 700;">
            Évolution des demandes
        </h2>
        <div style="width: 100%; height: 220px; position: relative;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        @foreach($quickStats as $quickStat)
            <div class="bg-white rounded-xl p-3 border border-gray-100"
                 style="box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center"
                         style="background-color: {{ $quickStat['bgColor'] }};">
                        @if($quickStat['icon'] === 'book-open')
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $quickStat['color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                            </svg>
                        @elseif($quickStat['icon'] === 'baby')
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $quickStat['color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 12h.01"/><path d="M15 12h.01"/><path d="M10 16c.5.3 1.2.5 2 .5s1.5-.2 2-.5"/><path d="M19 6.3a9 9 0 0 1 1.8 3.9 2 2 0 0 1 0 3.6 9 9 0 0 1-17.6 0 2 2 0 0 1 0-3.6A9 9 0 0 1 12 3c2 0 3.5 1.1 3.5 2.5s-.9 2.5-2 2.5c-.8 0-1.5-.4-1.5-1"/>
                            </svg>
                        @elseif($quickStat['icon'] === 'paw-print')
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $quickStat['color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="4" r="2"/><circle cx="18" cy="8" r="2"/><circle cx="20" cy="16" r="2"/><path d="M9 10a5 5 0 0 1 5 5v3.5a3.5 3.5 0 0 1-6.84 1.045Q6.52 17.48 4.46 16.84A3.5 3.5 0 0 1 5.5 10Z"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs" style="color: #6b7280; font-weight: 600;">
                            {{ $quickStat['label'] }}
                        </p>
                        <p class="text-lg" style="color: #000000; font-weight: 800;">
                            {{ $quickStat['value'] }}
                        </p>
                    </div>
                </div>
                <p class="text-xs" style="color: #059669; font-weight: 700;">
                    {{ $quickStat['change'] }}
                </p>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Services par mois - Bar Chart
    const servicesCtx = document.getElementById('servicesChart').getContext('2d');
    new Chart(servicesCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($servicesData, 'month')) !!},
            datasets: [
                {
                    label: 'Soutien scolaire',
                    data: {!! json_encode(array_column($servicesData, 'Soutien scolaire')) !!},
                    backgroundColor: '#2B5AA8',
                    borderRadius: 8
                },
                {
                    label: 'Babysitting',
                    data: {!! json_encode(array_column($servicesData, 'Babysitting')) !!},
                    backgroundColor: '#B82E6E',
                    borderRadius: 8
                },
                {
                    label: 'Garde d\'animaux',
                    data: {!! json_encode(array_column($servicesData, 'Garde d\'animaux')) !!},
                    backgroundColor: '#C78500',
                    borderRadius: 8
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 10,
                    top: 10,
                    bottom: 10
                }
            },
            plugins: {
                legend: {
                    labels: {
                        font: { size: 12, weight: 600 },
                        padding: 15
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    ticks: { font: { size: 12, weight: 600 }, color: '#6b7280' }
                },
                x: {
                    ticks: { font: { size: 12, weight: 600 }, color: '#6b7280' }
                }
            }
        }
    });

    // Distribution - Pie Chart
    const distributionCtx = document.getElementById('distributionChart').getContext('2d');
    new Chart(distributionCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode(array_column($serviceDistribution, 'name')) !!},
            datasets: [{
                data: {!! json_encode(array_column($serviceDistribution, 'value')) !!},
                backgroundColor: {!! json_encode(array_column($serviceDistribution, 'color')) !!}
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Demandes par mois - Line Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($revenueData, 'month')) !!},
            datasets: [{
                label: 'Demandes',
                data: {!! json_encode(array_column($revenueData, 'revenue')) !!},
                borderColor: '#059669',
                backgroundColor: 'rgba(5, 150, 105, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                pointRadius: 6,
                pointBackgroundColor: '#059669'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    ticks: { 
                        font: { size: 12, weight: 600 }, 
                        color: '#6b7280',
                        stepSize: 1
                    }
                },
                x: {
                    ticks: { font: { size: 12, weight: 600 }, color: '#6b7280' }
                }
            }
        }
    });
</script>
@endpush
