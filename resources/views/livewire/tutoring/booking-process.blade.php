<div class="min-h-screen bg-white">
    <livewire:shared.header />

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Progress Steps -->
        <div class="mb-10">
            <div class="flex items-center justify-center">
                <!-- Step 1 -->
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-14 h-14 rounded-2xl {{ $currentStep >= 1 ? 'bg-[#2B5AA8] text-white' : 'bg-gray-200 text-gray-600' }} shadow-md">
                        @if($currentStep > 1)
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <span class="font-bold">1</span>
                        @endif
                    </div>
                    <span class="ml-2 text-sm {{ $currentStep >= 1 ? 'text-[#2B5AA8]' : 'text-gray-600' }} font-semibold">Détails</span>
                </div>

                <div class="w-24 h-0.5 mx-4 {{ $currentStep >= 2 ? 'bg-[#2B5AA8]' : 'bg-gray-200' }}"></div>

                <!-- Step 2 -->
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-14 h-14 rounded-2xl {{ $currentStep >= 2 ? 'bg-[#2B5AA8] text-white' : 'bg-gray-200 text-gray-600' }} shadow-md">
                        @if($currentStep > 2)
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <span class="font-bold">2</span>
                        @endif
                    </div>
                    <span class="ml-2 text-sm {{ $currentStep >= 2 ? 'text-[#2B5AA8]' : 'text-gray-600' }} font-semibold">Disponibilité</span>
                </div>

                <div class="w-24 h-0.5 mx-4 {{ $currentStep >= 3 ? 'bg-[#2B5AA8]' : 'bg-gray-200' }}"></div>

                <!-- Step 3 -->
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-14 h-14 rounded-2xl {{ $currentStep >= 3 ? 'bg-[#2B5AA8] text-white' : 'bg-gray-200 text-gray-600' }} shadow-md">
                        <span class="font-bold">3</span>
                    </div>
                    <span class="ml-2 text-sm {{ $currentStep >= 3 ? 'text-[#2B5AA8]' : 'text-gray-600' }} font-semibold">Confirmation</span>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white rounded-2xl shadow-lg p-5 md:p-8">
            <h1 class="text-2xl lg:text-3xl text-center mb-2 text-black font-extrabold">Réserver un cours</h1>
            <p class="text-center text-sm text-[#1a1a1a] mb-8 font-medium">
                Étape {{ $currentStep }} : 
                @if($currentStep === 1) Détails du cours
                @elseif($currentStep === 2) Sélectionnez votre créneau
                @else Vérifiez et confirmez votre réservation
                @endif
            </p>

            <!-- Step 1: Details -->
            @if($currentStep === 1)
                <div class="space-y-6">
                    <!-- Professor Info -->
                    <div class="bg-[#F7F7F7] rounded-2xl p-5 md:p-6">
                        <div class="flex items-center gap-4">
                            <img src="{{ $professeur->photo ? asset('storage/' . $professeur->photo) : asset('images/default-avatar.png') }}" 
                                 alt="{{ $professeur->prenom }}"
                                 class="w-16 h-16 rounded-full object-cover shadow-md">
                            <div>
                                <p class="text-xs text-[#2a2a2a] font-semibold">Professeur</p>
                                <h3 class="text-lg text-black font-bold">{{ $professeur->prenom }} {{ $professeur->nom }}</h3>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4 mt-4">
                            <div>
                                <p class="text-xs text-[#2a2a2a] font-semibold">Matière</p>
                                <p class="text-sm text-[#0a0a0a] font-bold">{{ $service->matiere->nom_matiere }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-[#2a2a2a] font-semibold">Niveau</p>
                                <div class="flex gap-2 flex-wrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                        {{ $service->niveau->nom_niveau }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-[#2a2a2a] font-semibold">Tarif</p>
                                <p class="text-lg text-[#2B5AA8] font-extrabold">{{ number_format($service->prix_par_heure, 0) }} DH/h</p>
                            </div>
                        </div>
                    </div>

                    <!-- Course Type -->
                    <div>
                        <label class="block text-base text-[#0a0a0a] mb-4 font-bold">Comment souhaitez-vous suivre ce cours ? <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- En ligne -->
                            <label class="relative cursor-pointer">
                                <input type="radio" 
                                       wire:model.live="typeService" 
                                       value="enligne" 
                                       class="peer sr-only">
                                <div class="border-2 border-gray-300 rounded-2xl p-5 peer-checked:border-[#2B5AA8] peer-checked:bg-[#E1EAF7] transition-all shadow-md hover:shadow-lg">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-1">
                                            <svg class="w-6 h-6 text-[#2B5AA8]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-[#0a0a0a] mb-1 font-bold">En ligne</h4>
                                            <p class="text-xs text-[#2a2a2a] font-medium">Cours via visioconférence</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- À domicile -->
                            <label class="relative cursor-pointer">
                                <input type="radio" 
                                       wire:model.live="typeService" 
                                       value="domicile" 
                                       class="peer sr-only">
                                <div class="border-2 border-gray-300 rounded-2xl p-5 peer-checked:border-[#2B5AA8] peer-checked:bg-[#E1EAF7] transition-all shadow-md hover:shadow-lg">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-1">
                                            <svg class="w-6 h-6 text-[#2B5AA8]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-[#0a0a0a] mb-1 font-bold">À domicile</h4>
                                            <p class="text-xs text-[#2a2a2a] font-medium">Cours au domicile de l'étudiant</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('typeService') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                    </div>

                    <!-- Address Form (appears when domicile is selected) -->
                    @if($typeService === 'domicile')
                        <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-5 md:p-6 space-y-4 animate-fadeIn">
                            <div class="flex items-start gap-3 mb-4">
                                <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <div>
                                    <h4 class="text-[#0a0a0a] mb-1 font-bold">Adresse du cours à domicile</h4>
                                    <p class="text-xs text-[#2a2a2a] font-medium">Veuillez indiquer l'adresse où aura lieu le cours</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs text-gray-700 mb-2 font-semibold">
                                        Ville <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        wire:model="ville"
                                        class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent text-sm"
                                        placeholder="Ex: Casablanca">
                                    @error('ville') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-700 mb-2 font-semibold">
                                        Adresse complète <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        wire:model="adresse"
                                        class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent text-sm"
                                        placeholder="Ex: 123 Rue Mohammed V">
                                    @error('adresse') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Special Notes -->
                    <div>
                        <label class="block text-base text-[#0a0a0a] mb-2 font-bold">Notes spéciales (optionnel)</label>
                        <textarea 
                            wire:model="noteSpeciales"
                            rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent resize-none text-sm"
                            placeholder="Ajoutez des informations particulières (sujets à aborder, besoins spécifiques, etc.)"></textarea>
                    </div>
                </div>
            @endif

            <!-- Step 2: Availability -->
            @if($currentStep === 2)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
                    <!-- Calendar -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg text-black font-bold">{{ $currentMonth }}</h3>
                            <div class="flex gap-2">
                                <button class="p-2 hover:bg-gray-100 rounded-xl transition-all">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <button class="p-2 hover:bg-gray-100 rounded-xl transition-all">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Days of week -->
                        <div class="grid grid-cols-7 gap-2 mb-2">
                            @foreach(['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $day)
                                <div class="text-center text-xs text-[#2a2a2a] py-2 font-semibold">{{ $day }}</div>
                            @endforeach
                        </div>

                        <!-- Calendar days -->
                        <div class="grid grid-cols-7 gap-2">
                            @foreach($calendarDays as $day)
                                <button 
                                    wire:click="selectDate('{{ $day['date'] }}')"
                                    @if($day['isPast']) disabled @endif
                                    class="aspect-square flex items-center justify-center rounded-xl text-sm transition-all font-semibold
                                           {{ $day['isPast'] ? 'text-gray-300 cursor-not-allowed' : 'hover:bg-gray-100' }}
                                           {{ $selectedDate === $day['date'] ? 'bg-[#2B5AA8] text-white hover:bg-[#224A91] shadow-md' : '' }}
                                           {{ $day['isToday'] && $selectedDate !== $day['date'] ? 'border-2 border-[#2B5AA8]' : '' }}">
                                    {{ $day['day'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Time Slots -->
                    <div>
                        <h3 class="text-lg text-black mb-4 font-bold">
                            Créneaux disponibles
                            @if($selectedDate)
                                - {{ \Carbon\Carbon::parse($selectedDate)->locale('fr')->isoFormat('dddd D MMMM') }}
                            @endif
                        </h3>

                        @if($selectedDate)
                            @if(count($availableSlots) > 0)
                                <div class="space-y-2 mb-6 max-h-80 overflow-y-auto">
                                    @foreach($availableSlots as $slot)
                                        <button 
                                            wire:click="toggleTimeSlot({{ json_encode($slot) }})"
                                            class="w-full p-3.5 border-2 rounded-xl flex items-center justify-center gap-2 transition-all font-semibold text-sm
                                                   {{ in_array($slot['start'] . '-' . $slot['end'], $selectedTimeSlots) ? 'border-[#2B5AA8] bg-[#2B5AA8] text-white shadow-md' : 'border-gray-300 hover:border-[#2B5AA8]' }}">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ $slot['display'] }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-sm font-medium">Aucun créneau disponible pour cette date</p>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm font-medium">Sélectionnez une date pour voir les créneaux disponibles</p>
                            </div>
                        @endif

                        <!-- Selected slots summary -->
                        @if(count($selectedTimeSlots) > 0)
                            <div class="bg-[#F7F7F7] rounded-2xl p-4">
                                <h4 class="text-[#0a0a0a] mb-3 font-bold">Créneaux sélectionnés : {{ count($selectedTimeSlots) }}</h4>
                                <div class="space-y-2">
                                    @foreach($selectedTimeSlots as $slot)
                                        <div class="flex items-center justify-between bg-white p-3 rounded-xl shadow-sm">
                                            <span class="text-xs font-medium">{{ \Carbon\Carbon::parse($selectedDate)->locale('fr')->isoFormat('ddd D MMM') }} - {{ str_replace('-', ' - ', $slot) }}</span>
                                            <button wire:click="removeTimeSlot('{{ $slot }}')" class="text-red-500 hover:text-red-700 transition-colors">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-[#2a2a2a] font-semibold">Total</span>
                                        <span class="text-2xl text-[#2B5AA8] font-extrabold">{{ count($selectedTimeSlots) * $service->prix_par_heure }} DH</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 font-medium">{{ count($selectedTimeSlots) }} heure{{ count($selectedTimeSlots) > 1 ? 's' : '' }} × {{ number_format($service->prix_par_heure, 0) }} DH/h</p>
                                </div>
                            </div>
                        @endif
                        @error('selectedTimeSlots') <span class="text-red-500 text-xs mt-2 block font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>
            @endif

            <!-- Step 3: Confirmation -->
            @if($currentStep === 3)
                <div class="flex justify-center">
                    <!-- Personal Info -->
                    <div>
                        <h3 class="max-w-2xl w-full text-lg text-black mb-6 font-bold">Informations de réservation</h3>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <div>
                                    <p class="text-xs text-[#2a2a2a] font-semibold">Professeur</p>
                                    <p class="text-sm text-[#0a0a0a] font-bold">{{ $professeur->prenom }} {{ $professeur->nom }}</p>
                                    <div class="flex items-center gap-1 mt-1">
                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="text-xs font-semibold">{{ number_format($professeur->note, 1) }}/5</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Subject -->
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <div>
                                    <p class="text-xs text-[#2a2a2a] font-semibold">Matière</p>
                                    <p class="text-sm font-bold">{{ $service->matiere->nom_matiere }}</p>
                                </div>
                            </div>

                            <!-- Level -->
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                                <div>
                                    <p class="text-xs text-[#2a2a2a] font-semibold">Niveau</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                        {{ $service->niveau->nom_niveau }}
                                    </span>
                                </div>
                            </div>

                            <!-- Mode -->
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    @if($typeService === 'enligne')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    @endif
                                </svg>
                                <div>
                                    <p class="text-xs text-[#2a2a2a] font-semibold">Mode de cours</p>
                                    <p class="text-sm font-bold">
                                        @if($typeService === 'enligne')
                                            En ligne (Visioconférence)
                                        @elseif($typeService === 'domicile' && $ville)
                                            À domicile - {{ $ville }}
                                        @else
                                            À domicile
                                        @endif
                                    </p>
                                    @if($typeService === 'domicile' && $adresse)
                                        <p class="text-xs text-gray-500 mt-0.5 font-medium">{{ $adresse }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Schedule -->
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div class="flex-grow">
                                    <p class="text-xs text-[#2a2a2a] mb-2 font-semibold">Créneaux réservés</p>
                                    <div class="bg-[#F7F7F7] rounded-xl p-3 border border-gray-200">
                                        <p class="text-sm font-bold mb-2">{{ \Carbon\Carbon::parse($selectedDate)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</p>
                                        @foreach($selectedTimeSlots as $slot)
                                            <div class="flex items-center gap-2 text-xs text-gray-700 py-1 font-medium">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ str_replace('-', ' - ', $slot) }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="pt-4 border-t border-gray-200">
                                <div class="flex justify-between text-xs mb-2">
                                    <span class="text-[#2a2a2a] font-semibold">Nombre d'heures</span>
                                    <span class="font-bold">{{ $nombreHeures }} heure{{ $nombreHeures > 1 ? 's' : '' }}</span>
                                </div>
                                <div class="flex justify-between text-xs mb-3">
                                    <span class="text-[#2a2a2a] font-semibold">Tarif horaire</span>
                                    <span class="font-bold">{{ number_format($service->prix_par_heure, 0) }} DH/h</span>
                                </div>
                                <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                                    <span class="text-base font-bold">Total</span>
                                    <span class="text-2xl lg:text-3xl text-[#2B5AA8] font-extrabold">{{ number_format($montantTotal, 0) }} DH</span>
                                </div>
                            </div>
                        </div>

                        <!-- Info Message -->
                        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <div class="flex gap-3">
                                <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-xs text-blue-800 font-medium">
                                    Votre demande sera envoyée au professeur qui pourra l'accepter ou la refuser. Vous recevrez une notification par email dès qu'il aura répondu.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                <button 
                    wire:click="{{ $currentStep === 1 ? 'cancel' : 'previousStep' }}"
                    class="flex items-center gap-2 px-4 py-2.5 text-[#0a0a0a] bg-white border-2 border-gray-300 rounded-xl font-bold hover:bg-gray-50 transition-all shadow-sm text-sm">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    {{ $currentStep === 1 ? 'Annuler' : 'Retour' }}
                </button>

                @if($currentStep < 3)
                    <button 
                        wire:click="nextStep"
                        class="flex items-center gap-2 px-6 py-2.5 bg-[#2B5AA8] text-white rounded-xl font-bold hover:bg-[#224A91] transition-all shadow-lg text-sm">
                        Suivant
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                @else
                    <button 
                        wire:click="submitBooking"
                        class="flex items-center gap-2 px-6 py-2.5 bg-[#2B5AA8] text-white rounded-xl font-bold hover:bg-[#224A91] transition-all shadow-lg text-sm">
                        Soumettre la demande
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    </div>

    <livewire:shared.footer />
</div>