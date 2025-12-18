<div class="min-h-screen bg-[#F7F7F7]">
    @php $babysitter = $babysitter ?? null; @endphp
    @if(isset($error))
        {{-- Message d'erreur --}}
        <div class="min-h-screen bg-[#F7F7F7] flex items-center justify-center p-4">
            <div class="max-w-2xl w-full">
                <div class="bg-white rounded-3xl p-10 border border-gray-100 text-center" style="box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08)">
                    <div class="w-24 h-24 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    
                    <h2 class="text-3xl mb-3 text-black font-extrabold">
                        Babysitter non trouvé
                    </h2>
                    <p class="text-lg mb-8 text-[#3a3a3a] font-medium">
                        {{ $error }}
                    </p>

                    <div class="flex gap-4">
                        <a href="/liste-babysitter" wire:navigate class="flex-1 px-6 py-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-bold text-center">
                            Retour à la recherche
                        </a>
                        <a href="/" wire:navigate class="flex-1 px-6 py-4 bg-[#B82E6E] text-white rounded-xl hover:bg-[#A02860] transition-all font-bold text-center" style="box-shadow: 0 4px 20px rgba(184, 46, 110, 0.3)">
                            Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @elseif($showSuccess)
        {{-- Success Screen --}}
        <div class="min-h-screen bg-[#F7F7F7] flex items-center justify-center p-4">
            <div class="max-w-2xl w-full">
                <div class="bg-white rounded-3xl p-10 border border-gray-100 text-center" style="box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08)">
                    <div class="w-24 h-24 bg-[#B82E6E] rounded-full flex items-center justify-center mx-auto mb-6" style="box-shadow: 0 10px 30px rgba(184, 46, 110, 0.3)">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    
                    <h2 class="text-3xl mb-3 text-black font-extrabold">
                        Demande envoyée ! 
                    </h2>
                    <p class="text-lg mb-8 text-[#3a3a3a] font-medium">
                        Votre demande a été envoyée à {{ $babysitter['prenom'] }}. Elle a 24h pour vous répondre.
                    </p>

                    <div class="bg-[#F9E0ED] rounded-2xl p-6 mb-8">
                        <p class="text-[#B82E6E] font-bold">
                            @foreach($selectedDays as $selectedDay)
                                @foreach($daysOfWeek as $day)
                                    @if($day['id'] === $selectedDay)
                                        {{ $day['label'] }} 
                                    @endif
                                @endforeach
                            @endforeach
                            • {{ $startTime }} - {{ $endTime }}
                        </p>
                        <p class="text-sm mt-2 text-gray-500 font-semibold">
                            Vous recevrez une notification dès sa réponse
                        </p>
                    </div>

                    <div class="flex gap-4">
                        <a href="/liste-babysitter" wire:navigate class="flex-1 px-6 py-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-bold text-center">
                            Retour à la recherche
                        </a>
                        <a href="/" wire:navigate class="flex-1 px-6 py-4 bg-[#B82E6E] text-white rounded-xl hover:bg-[#A02860] transition-all font-bold text-center" style="box-shadow: 0 4px 20px rgba(184, 46, 110, 0.3)">
                            Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @elseif(!$babysitter)
        {{-- Message d'erreur si babysitter null --}}
        <div class="min-h-screen bg-[#F7F7F7] flex items-center justify-center p-4">
            <div class="max-w-2xl w-full">
                <div class="bg-white rounded-3xl p-10 border border-gray-100 text-center" style="box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08)">
                    <div class="w-24 h-24 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    
                    <h2 class="text-3xl mb-3 text-black font-extrabold">
                        Babysitter non trouvé
                    </h2>
                    <p class="text-lg mb-8 text-[#3a3a3a] font-medium">
                        Le babysitter demandé n'existe pas.
                    </p>

                    <div class="flex gap-4">
                        <a href="/liste-babysitter" wire:navigate class="flex-1 px-6 py-4 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-bold text-center">
                            Retour à la recherche
                        </a>
                        <a href="/" wire:navigate class="flex-1 px-6 py-4 bg-[#B82E6E] text-white rounded-xl hover:bg-[#A02860] transition-all font-bold text-center" style="box-shadow: 0 4px 20px rgba(184, 46,110, 0.3)">
                            Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Header --}}
        <div class="bg-white border-b border-gray-100">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <a href="/babysitter-profile/{{ $babysitter['id'] }}" wire:navigate class="flex items-center gap-2 text-gray-600 hover:text-gray-900 mb-4 font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour au profil
                </a>

                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 rounded-full overflow-hidden border-3 border-white shadow-lg flex items-center justify-center bg-[#B82E6E]">
                        @if($babysitter['photo'])
                            <img src="{{ $babysitter['photo'] }}" alt="{{ $babysitter['prenom'] }}" class="w-full h-full object-cover" />
                        @else
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-2xl mb-1 text-black font-extrabold">
                            Demander un service
                        </h1>
                        <p class="text-[#3a3a3a] font-semibold">
                            {{ $babysitter['prenom'] }} {{ substr($babysitter['nom'], 0, 1) }}.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- Stepper --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 mb-8" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                <div class="flex items-center justify-between">
                    @foreach($steps as $index => $step)
                        <div class="flex items-center {{ $index < count($steps) - 1 ? 'flex-1' : '' }}">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center transition-all font-extrabold
                                    {{ $step['number'] === $currentStep ? 'bg-[#B82E6E] text-white scale-110' : '' }}
                                    {{ $step['number'] < $currentStep ? 'bg-[#B82E6E] text-white' : '' }}
                                    {{ $step['number'] > $currentStep ? 'bg-gray-200 text-gray-500' : '' }}">
                                    @if($step['number'] < $currentStep)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        {{ $step['number'] }}
                                    @endif
                                </div>
                                <span class="text-sm mt-2 font-bold
                                    {{ $step['number'] === $currentStep || $step['number'] < $currentStep ? 'text-[#B82E6E]' : 'text-gray-500' }}">
                                    {{ $step['label'] }}
                                </span>
                            </div>
                            @if($index < count($steps) - 1)
                                <div class="flex-1 h-1 mx-4 rounded-full {{ $step['number'] < $currentStep ? 'bg-[#B82E6E]' : 'bg-gray-200' }}"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Content --}}
            <div class="bg-white rounded-2xl p-8 border border-gray-100 mb-8" style="box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06)">
                {{-- Step 1: Service --}}
                @if($currentStep === 1)
                    <div>
                        <h2 class="text-2xl mb-6 text-black font-extrabold">
                            Quel service souhaitez-vous ?
                        </h2>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($availableServices as $service)
                                <button wire:click="toggleService('{{ $service['name'] }}')" type="button"
                                    class="p-6 rounded-2xl border-2 transition-all text-center
                                    {{ in_array($service['name'], $selectedServices) ? 'border-[#B82E6E] bg-[#F9E0ED]' : 'border-gray-200 hover:border-gray-300 bg-white' }}">
                                    <div class="w-16 h-16 rounded-2xl mx-auto mb-3 flex items-center justify-center"
                                         style="background-color: {{ in_array($service['name'], $selectedServices) ? '#B82E6E' : ($service['color'] ?? '#E5E7EB') }}; opacity: {{ in_array($service['name'], $selectedServices) ? 1 : 0.15 }}">
                                        <span class="text-4xl">{{ $service['icon'] }}</span>
                                    </div>
                                    <h4 class="text-black font-bold">
                                        {{ $service['name'] }}
                                    </h4>
                                </button>
                            @endforeach
                        </div>
                        
                        @if(count($selectedServices) > 0)
                            <div class="mt-6 p-4 bg-blue-50 rounded-xl">
                                <p class="text-sm text-blue-600 font-semibold">
                                    Services sélectionnés: {{ implode(', ', $selectedServices) }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Step 2: Date & Horaires --}}
                @if($currentStep === 2)
                    <div>
                        <h2 class="text-2xl mb-6 text-black font-extrabold">
                            Quand avez-vous besoin du service ?
                        </h2>

                        {{-- Sélection du jour --}}
                        <div class="mb-6">
                            <label class="block text-sm mb-3 text-[#0a0a0a] font-bold">
                                Choisissez un ou plusieurs jours
                            </label>
                            <div class="grid grid-cols-7 gap-2">
                                @foreach($daysOfWeek as $day)
                                    @php
                                        $hasSlots = isset($babysitter['availability'][$day['id']]) && count($babysitter['availability'][$day['id']]) > 0;
                                        $isSelected = in_array($day['id'], $selectedDays);
                                    @endphp
                                    <button wire:click="toggleDay('{{ $day['id'] }}')" type="button"
                                        @if(!$hasSlots) disabled @endif
                                        class="p-4 rounded-xl transition-all
                                        {{ $isSelected ? 'bg-[#B82E6E] text-white' : '' }}
                                        {{ $hasSlots && !$isSelected ? 'bg-white border-2 border-gray-200 hover:border-[#B82E6E] text-gray-700' : '' }}
                                        {{ !$hasSlots ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : '' }}">
                                        <div class="text-xs mb-1 font-semibold">
                                            {{ substr($day['label'], 0, 3) }}
                                        </div>
                                        <div class="text-xs font-medium">
                                            {{ $hasSlots ? ($isSelected ? '✓' : '○') : '✕' }}
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                            @if(!empty($selectedDays))
                                <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                                    <p class="text-sm text-blue-800">
                                        <strong>Jours sélectionnés :</strong> 
                                        @foreach($selectedDays as $index => $day)
                                            @foreach($daysOfWeek as $dayItem)
                                                @if($dayItem['id'] === $day){{ $dayItem['label'] }}@endif
                                            @endforeach
                                            {{ $index < count($selectedDays) - 1 ? ', ' : '' }}
                                        @endforeach
                                    </p>
                                </div>
                            @endif
                        </div>

                        {{-- Créneaux horaires disponibles --}}
                        @if(!empty($selectedDays))
                            <div class="bg-[#F7F7F7] rounded-2xl p-6">
                                <h3 class="text-lg mb-4 text-black font-bold">
                                    Créneaux disponibles pour les jours sélectionnés
                                </h3>
                                
                                {{-- Affichage des créneaux disponibles pour chaque jour --}}
                                <div class="mb-6">
                                    <p class="text-sm mb-3 text-gray-500 font-semibold">
                                        Cette babysitter est disponible durant les plages suivantes :
                                    </p>
                                    @foreach($selectedDays as $day)
                                        @if(isset($babysitter['availability'][$day]) && count($babysitter['availability'][$day]) > 0)
                                            <div class="mb-3">
                                                <h4 class="text-sm font-semibold text-gray-700 mb-2">
                                                    @foreach($daysOfWeek as $dayItem)
                                                        @if($dayItem['id'] === $day){{ $dayItem['label'] }}@endif
                                                    @endforeach
                                                </h4>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($babysitter['availability'][$day] as $slot)
                                                        <div class="flex items-center gap-2 px-3 py-1 bg-white rounded-lg border border-[#B82E6E]">
                                                            <svg class="w-3 h-3 text-[#B82E6E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                            <span class="text-xs text-[#B82E6E] font-bold">{{ $slot }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- Saisie manuelle des créneaux --}}
                                <div class="bg-white rounded-xl p-6 border-2 border-gray-200">
                                    <h4 class="text-lg mb-4 text-black font-bold">
                                        Ajouter des créneaux horaires
                                    </h4>
                                    <p class="text-sm mb-4 text-gray-500 font-semibold">
                                        Remplissez les heures de début et de fin, puis cliquez sur "+" pour ajouter le créneau à tous les jours sélectionnés.
                                    </p>
                                    
                                    {{-- Message d'erreur en rose --}}
                                    @if(session()->has('error'))
                                        <div class="mb-4 p-3 bg-pink-50 rounded-lg border-2 border-pink-200">
                                            <div class="flex items-start gap-2">
                                                <svg class="w-5 h-5 text-pink-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <div>
                                                    <p class="text-sm text-pink-800 font-semibold">
                                                        {{ session('error') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="mb-4 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                        <div class="flex items-start gap-2">
                                            <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <div>
                                                <p class="text-sm text-yellow-800 font-semibold">
                                                    <strong>Important :</strong> Les créneaux doivent être dans les plages horaires disponibles du babysitter affichées ci-dessus.
                                                </p>
                                                <p class="text-xs text-yellow-700 mt-1">
                                                    Exemple : Si le babysitter est disponible "08:00-12:00", vous pouvez choisir "08:00-10:00" mais pas "07:00-09:00"
                                                </p>
                                                <p class="text-xs text-yellow-700 mt-1">
                                                    <strong>Attention :</strong> Les créneaux ne peuvent pas se chevaucher. Chaque créneau doit être distinct.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label class="block text-sm mb-2 text-[#0a0a0a] font-bold">
                                                Heure de début
                                            </label>
                                            <div class="relative">
                                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <input type="time" wire:model.live="currentStartTime"
                                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#B82E6E]" />
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm mb-2 text-[#0a0a0a] font-bold">
                                                Heure de fin
                                            </label>
                                            <div class="relative">
                                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <input type="time" wire:model.live="currentEndTime"
                                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#B82E6E]" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-center">
                                        <button wire:click="addTimeSlot" type="button"
                                            class="px-6 py-3 bg-[#B82E6E] text-white rounded-xl hover:bg-[#9c2360] transition-colors font-bold flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Ajouter le créneau
                                        </button>
                                    </div>
                                </div>

                                {{-- Résumé des créneaux sélectionnés --}}
                                @if(!empty($selectedSlots))
                                    <div class="mt-6 p-4 bg-green-50 rounded-xl border-2 border-green-200">
                                        <h4 class="text-lg mb-3 text-green-800 font-bold">
                                            Créneaux sélectionnés
                                        </h4>
                                        @foreach($selectedSlots as $day => $slots)
                                            @if(!empty($slots))
                                                <div class="mb-3 p-3 bg-white rounded-lg border border-green-200">
                                                    <h5 class="text-sm font-semibold text-green-700 mb-2">
                                                        @foreach($daysOfWeek as $dayItem)
                                                            @if($dayItem['id'] === $day){{ $dayItem['label'] }}@endif
                                                        @endforeach
                                                    </h5>
                                                    <div class="space-y-2">
                                                        @foreach($slots as $slot)
                                                            <div class="flex items-center justify-between p-2 bg-green-50 rounded">
                                                                <span class="text-green-600 font-medium">{{ $slot }}</span>
                                                                <button wire:click="removeSlot('{{ $day }}', '{{ $slot }}')" type="button"
                                                                    class="text-red-500 hover:text-red-700 transition-colors">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Step 3: Lieu --}}
                @if($currentStep === 3)
                    <div>
                        <h2 class="text-2xl mb-6 text-black font-extrabold">
                            Où aura lieu l'intervention ?
                        </h2>

                        @php
                            // Récupérer les préférences de domicile du babysitter
                            $preferencesDomicile = $babysitter['preference_domicil'] ?? '';
                            
                            $babysitterAddress = '';
                            if (isset($babysitter['utilisateur']) && $babysitter['utilisateur']->localisations) {
                                $localisation = $babysitter['utilisateur']->localisations->first();
                                $babysitterAddress = $localisation ? $localisation->adresse . ', ' . $localisation->ville : '';
                            }
                        @endphp
                        
                        {{-- CAS 1: Babysitter accepte uniquement chez elle (domicil_babysitter) --}}
                        @if($preferencesDomicile === 'domicil_babysitter')
                            <div class="p-6 bg-[#F9E0ED] rounded-2xl border-2 border-[#B82E6E] mb-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-[#B82E6E] rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-black font-extrabold">
                                            🏠 Intervention chez la babysitter uniquement
                                        </p>
                                        <p class="text-sm text-gray-500 font-semibold mt-1">
                                            {{ $babysitterAddress ?: 'Adresse non renseignée' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        
                        {{-- CAS 2: Babysitter accepte uniquement chez le client (domicil_client) --}}
                        @elseif($preferencesDomicile === 'domicil_client')
                            <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                                <p class="text-sm text-blue-700 font-semibold">
                                    🚗 Cette babysitter se déplace uniquement à votre domicile
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm mb-2 text-[#0a0a0a] font-bold">
                                    Votre adresse complète <span class="text-red-500">*</span>
                                </label>
                                <textarea wire:model="address" rows="3" placeholder="Numéro et nom de rue, quartier, ville"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#B82E6E] resize-none"></textarea>
                                @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        
                        {{-- CAS 3: Babysitter accepte les deux options (les_deux) --}}
                        @else
                            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                                <p class="text-sm text-green-700 font-semibold">
                                    ✨ Cette babysitter accepte les deux options - choisissez celle qui vous convient
                                </p>
                            </div>

                            <button wire:click="$set('adresseChoice', 'babysitter')" type="button"
                                class="w-full p-6 rounded-2xl border-2 transition-all text-left mb-4
                                {{ $adresseChoice === 'babysitter' ? 'border-[#B82E6E] bg-[#F9E0ED]' : 'border-gray-200 hover:border-[#B82E6E]' }}">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-[#B82E6E] rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-black font-extrabold">
                                            🏠 Intervention chez la babysitter
                                        </p>
                                        <p class="text-sm text-gray-500 font-semibold">
                                            {{ $babysitterAddress ?: 'Adresse non renseignée' }}
                                        </p>
                                    </div>
                                    <input type="radio" name="adresseChoice" value="babysitter"
                                        {{ $adresseChoice === 'babysitter' ? 'checked' : '' }}
                                        class="w-5 h-5 text-[#B82E6E]" style="accent-color: #B82E6E" />
                                </div>
                            </button>

                            <div class="relative mb-6">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-4 bg-white text-gray-500 font-semibold">ou</span>
                                </div>
                            </div>

                            <button wire:click="$set('adresseChoice', 'client')" type="button"
                                class="w-full p-6 rounded-2xl border-2 transition-all text-left mb-6
                                {{ $adresseChoice === 'client' ? 'border-[#B82E6E] bg-[#F9E0ED]' : 'border-gray-200 hover:border-[#B82E6E]' }}">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-[#B82E6E] rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                            <polyline points="9,22 9,12 15,12 15,22"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-black font-extrabold">
                                            🚗 Intervention chez vous (à votre domicile)
                                        </p>
                                        <p class="text-sm text-gray-500 font-semibold">
                                            Saisir votre adresse ci-dessous
                                        </p>
                                    </div>
                                    <input type="radio" name="adresseChoice" value="client"
                                        {{ $adresseChoice === 'client' ? 'checked' : '' }}
                                        class="w-5 h-5 text-[#B82E6E]" style="accent-color: #B82E6E" />
                                </div>
                            </button>

                            @if($adresseChoice === 'client')
                                <div>
                                    <label class="block text-sm mb-2 text-[#0a0a0a] font-bold">
                                        Votre adresse complète <span class="text-red-500">*</span>
                                    </label>
                                    <textarea wire:model="address" rows="3" placeholder="Numéro et nom de rue, quartier, ville"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#B82E6E] resize-none"></textarea>
                                    @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            @endif
                        @endif
                    </div>
                @endif

                {{-- Step 4: Enfants --}}
                @if($currentStep === 4)
                    <div>
                        <h2 class="text-2xl mb-6 text-black font-extrabold">
                            Informations des enfants
                        </h2>

                        {{-- Afficher les catégories d'enfants acceptées par la babysitter --}}
                        @if(isset($babysitter['categories_enfants']) && count($babysitter['categories_enfants']) > 0)
                            <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
                                <p class="text-sm text-blue-700 font-semibold mb-2">
                                    👶 Cette babysitter accepte les catégories d'âge suivantes :
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($babysitter['categories_enfants'] as $categorie)
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                            {{ $categorie }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Liste des enfants ajoutés --}}
                        @if(count($children) > 0)
                            <div class="space-y-3 mb-6">
                                @foreach($children as $child)
                                    <div class="p-4 bg-[#F9E0ED] rounded-xl flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 bg-[#B82E6E] rounded-full flex items-center justify-center text-white">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-black font-bold">
                                                    {{ $child['sexe'] }}, {{ $child['age'] }} ans
                                                </p>
                                                @if(!empty($child['besoinsSpeciaux']) || !empty($child['autresBesoins']))
                                                    <p class="text-sm text-gray-500 font-semibold">
                                                        @if(!empty($child['besoinsSpeciaux']))
                                                            @if(is_array($child['besoinsSpeciaux']))
                                                                {{ implode(', ', $child['besoinsSpeciaux']) }}
                                                            @else
                                                                {{ $child['besoinsSpeciaux'] }}
                                                            @endif
                                                        @endif
                                                        @if(!empty($child['besoinsSpeciaux']) && !empty($child['autresBesoins'])) - @endif
                                                        {{ $child['autresBesoins'] }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <button wire:click="removeChild({{ $child['id'] }})" type="button"
                                            class="w-8 h-8 bg-white rounded-full flex items-center justify-center hover:bg-red-50 transition-all">
                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Formulaire d'ajout d'enfant --}}
                        <div class="bg-[#F7F7F7] rounded-2xl p-6 mb-4">
                            <h3 class="text-lg mb-4 text-black font-bold">
                                {{ count($children) > 0 ? 'Ajouter un autre enfant' : 'Ajouter un enfant' }}
                            </h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm mb-2 text-[#0a0a0a] font-bold">
                                            Âge <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number" wire:model.live="currentChild.age"
                                            placeholder="Âge en années" min="0" max="18"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#B82E6E]" />
                                    </div>
                                    <div>
                                        <label class="block text-sm mb-2 text-[#0a0a0a] font-bold">
                                            Sexe <span class="text-red-500">*</span>
                                        </label>
                                        <select wire:model.live="currentChild.sexe"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#B82E6E]">
                                            <option value="">Sélectionner</option>
                                            <option value="Garçon">Garçon</option>
                                            <option value="Fille">Fille</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Besoins spécifiques - Afficher uniquement ceux que la babysitter accepte --}}
                                @if(isset($babysitter['besoins_speciaux']) && count($babysitter['besoins_speciaux']) > 0)
                                    <div>
                                        <label class="block text-sm mb-2 text-[#0a0a0a] font-bold">
                                            Besoins spécifiques
                                        </label>
                                        <p class="text-xs text-gray-500 mb-3">
                                            Cette babysitter peut gérer les besoins suivants :
                                        </p>
                                        <div class="space-y-2 mb-3 max-h-60 overflow-y-auto">
                                            @foreach($babysitter['besoins_speciaux'] as $besoin)
                                                <label class="flex items-center gap-2 p-2 hover:bg-gray-50 rounded">
                                                    <input type="checkbox" wire:model.live="currentChild.besoinsSpeciaux" value="{{ $besoin }}" class="rounded">
                                                    <span class="text-sm">{{ $besoin }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                                        <p class="text-sm text-yellow-700 font-semibold">
                                            ℹ️ Cette babysitter n'a pas spécifié d'expérience avec des besoins spéciaux
                                        </p>
                                    </div>
                                @endif

                                <div>
                                    <label class="block text-sm mb-2 text-[#0a0a0a] font-bold">
                                        Autres besoins ou informations (optionnel)
                                    </label>
                                    <textarea wire:model.live="currentChild.autresBesoins"
                                        placeholder="Précisez d'autres besoins ou informations importantes..."
                                        rows="2"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#B82E6E] resize-none"></textarea>
                                </div>

                                <button wire:click="addChild" type="button"
                                    wire:loading.attr="disabled"
                                    class="w-full px-6 py-3 bg-[#B82E6E] text-white rounded-xl hover:bg-[#A02860] transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Ajouter l'enfant
                                </button>
                            </div>
                        </div>

                        @if(count($children) === 0)
                            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl flex items-start gap-3">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <p class="text-sm text-[#92400e] font-semibold">
                                    Vous devez ajouter au moins un enfant pour continuer
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Step 5: Confirmation --}}
                @if($currentStep === 5)
                    <div>
                        <h2 class="text-2xl mb-6 text-center text-black font-extrabold">
                            Récapitulatif de votre demande
                        </h2>

                        <div class="bg-[#F9E0ED] rounded-2xl p-6 mb-6">
                            <div class="space-y-4">
                                {{-- Service --}}
                                <div class="flex items-start gap-3 p-4 bg-white rounded-xl">
                                    <span class="text-2xl">🎯</span>
                                    <div>
                                        <p class="text-xs mb-1 text-gray-500 font-semibold">
                                            Service(s) demandé(s)
                                        </p>
                                        <p class="text-black font-bold">
                                            @if(count($selectedServices) > 0)
                                                {{ implode(', ', $selectedServices) }}
                                            @else
                                                Non sélectionné
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                {{-- Date & Heure --}}
                                <div class="flex items-start gap-3 p-4 bg-white rounded-xl">
                                    <span class="text-2xl">📅</span>
                                    <div>
                                        <p class="text-xs mb-1 text-gray-500 font-semibold">
                                            Date et horaires
                                        </p>
                                        <p class="text-black font-bold">
                                            @foreach($selectedDays as $selectedDay)
                                                @foreach($daysOfWeek as $day)
                                                    @if($day['id'] === $selectedDay){{ $day['label'] }}@endif
                                                @endforeach
                                            @endforeach
                                            @if($startTime && $endTime)
                                                • {{ $startTime }} - {{ $endTime }}
                                            @endif
                                        </p>
                                        @if($startTime && $endTime)
                                            <p class="text-sm mt-1 text-gray-500 font-semibold">
                                                Durée : 
                                                @php
                                                    $start = explode(':', $startTime);
                                                    $end = explode(':', $endTime);
                                                    $duration = ((int)$end[0] * 60 + (int)($end[1] ?? 0) - (int)$start[0] * 60 - (int)($start[1] ?? 0)) / 60;
                                                    echo $duration > 0 ? number_format($duration, 1) . ' heure' . ($duration > 1 ? 's' : '') : 'Invalide';
                                                @endphp
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Lieu --}}
                                <div class="flex items-start gap-3 p-4 bg-white rounded-xl">
                                    <span class="text-2xl">📍</span>
                                    <div>
                                        <p class="text-xs mb-1 text-gray-500 font-semibold">
                                            Lieu
                                        </p>
                                        <p class="text-black font-bold">
                                            @if($useRegisteredAddress)
                                                23 Rue des Fleurs, Maârif - Casablanca
                                            @else
                                                {{ $address ?: 'Non renseigné' }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                {{-- Enfants --}}
                                <div class="flex items-start gap-3 p-4 bg-white rounded-xl">
                                    <span class="text-2xl">👶</span>
                                    <div class="flex-1">
                                        <p class="text-xs mb-2 text-gray-500 font-semibold">
                                            Enfant(s) à garder
                                        </p>
                                        @if(count($children) > 0)
                                            <div class="space-y-2">
                                                @foreach($children as $child)
                                                    <div class="p-2 bg-[#F7F7F7] rounded-lg">
                                                        <p class="text-black font-bold">
                                                            {{ $child['sexe'] }}, {{ $child['age'] }} ans
                                                        </p>
                                                        @if(!empty($child['besoinsSpeciaux']) || !empty($child['autresBesoins']))
                                                            <p class="text-xs mt-1 text-gray-500 font-semibold">
                                                                @if(!empty($child['besoinsSpeciaux']))
                                                                    @if(is_array($child['besoinsSpeciaux']))
                                                                        {{ implode(', ', $child['besoinsSpeciaux']) }}
                                                                    @else
                                                                        {{ $child['besoinsSpeciaux'] }}
                                                                    @endif
                                                                @endif
                                                                @if(!empty($child['besoinsSpeciaux']) && !empty($child['autresBesoins'])) - @endif
                                                                {{ $child['autresBesoins'] }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-black font-bold">Aucun enfant renseigné</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm text-[#0a0a0a] font-bold">
                                    Ajouter un message (optionnel)
                                </label>
                                <span class="text-xs text-gray-500 font-medium">
                                    {{ strlen($message) }}/300
                                </span>
                            </div>
                            <textarea wire:model.live="message" maxlength="300" rows="4"
                                placeholder="Présentez-vous, expliquez vos attentes..."
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#B82E6E] resize-none"></textarea>
                        </div>

                        {{-- Prix total --}}
                        <div class="bg-[#F9E0ED] rounded-xl p-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-[#B82E6E]">Prix total estimé</span>
                                <span class="text-2xl font-extrabold text-[#B82E6E]">{{ $totalPrice }} MAD</span>
                            </div>
                            <p class="text-xs text-gray-600 mt-2">
                                * Prix basé sur le tarif horaire et le nombre d'enfants
                            </p>
                        </div>

                        <div class="flex items-start gap-3 mb-6">
                            <input type="checkbox" id="terms" wire:model.live="agreedToTerms"
                                class="w-5 h-5 text-[#B82E6E] rounded mt-1 focus:ring-[#B82E6E] focus:ring-2"
                                style="accent-color: #B82E6E" />
                            <label for="terms" class="text-sm text-gray-500 font-semibold cursor-pointer">
                                J'accepte les conditions générales d'utilisation et je comprends que cette demande
                                n'est pas encore confirmée
                            </label>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Footer --}}
            <div class="flex gap-4">
                @if($currentStep > 1)
                    <button wire:click="prevStep" type="button"
                        class="flex-1 px-6 py-4 bg-white border-2 border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition-all font-bold">
                        <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Retour
                    </button>
                @endif
                @auth
                <button 
                    @if($currentStep === 5)
                        wire:click="confirmBooking"
                    @else
                        wire:click="nextStep"
                    @endif
                    type="button"
                    @if(!$this->canProceed()) disabled @endif
                    class="flex-1 px-6 py-4 bg-[#B82E6E] text-white rounded-xl hover:bg-[#A02860] transition-all disabled:opacity-50 disabled:cursor-not-allowed font-bold"
                    style="box-shadow: 0 4px 20px rgba(184, 46, 110, 0.3)">
                    {{ $currentStep === 5 ? 'Confirmer la demande' : 'Suivant' }}
                    @if($currentStep < 5)
                        <svg class="inline w-5 h-5 ml-2 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    @else
                        <svg class="inline w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    @endif
                </button>
                @else
                <div class="flex-1 px-6 py-4 bg-gray-300 text-gray-600 rounded-xl font-bold text-center cursor-not-allowed">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span>Connectez-vous pour demander un service</span>
                    </div>
                </div>
                <a href="/connexion" class="flex-1 px-6 py-4 bg-[#B82E6E] text-white rounded-xl hover:bg-[#A02860] transition-all font-bold text-center">
                    Se connecter
                </a>
                @endauth
            </div>
        </div>
    @endif
</div>