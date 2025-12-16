<div class="max-w-4xl mx-auto p-6">
    <!-- Flash Messages -->
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif



    <!-- SIDEBAR GAUCHE -->
    <aside class="w-72 bg-white h-screen fixed left-0 top-0 border-r border-gray-100 flex flex-col z-40 shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
        <!-- Logo -->
        <div class="p-8 flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-700 rounded-xl flex items-center justify-center text-white font-bold shadow-amber-200 shadow-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
            </div>
            <span class="text-2xl font-extrabold text-gray-800 tracking-tight">Helpora</span>
        </div>

        <div class="px-6 pb-6">
            <p class="text-xs font-bold text-gray-400 mb-4 uppercase tracking-wider pl-2">Espace PetKeeper</p>
            
            <!-- Carte Profil Miniature -->
            <div class="bg-white rounded-2xl p-3 flex items-center gap-3 border border-gray-100 shadow-sm group hover:border-amber-200 transition-colors cursor-pointer">
                <div class="w-12 h-12 rounded-full bg-gray-100 p-0.5 border-2 border-white shadow-sm overflow-hidden">
                    @if(isset($user->photo) && $user->photo)
                        <img src="{{ Storage::url($user->photo) }}" class="w-full h-full rounded-full object-cover">
                    @else
                        <img class="w-full h-full rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ $user->prenom }}+{{ $user->nom }}&background=d97706&color=fff" alt="Avatar">
                    @endif
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-900 leading-tight group-hover:text-amber-700 transition-colors">
                        {{ $user->prenom }} {{ $user->nom }}
                    </h4>
                    <div class="flex items-center text-xs text-amber-600 font-bold mt-0.5">
                        <span class="bg-amber-50 px-1.5 py-0.5 rounded text-[10px] tracking-wide">★ {{ $stats['note'] ?? 4.8 }}</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 flex items-center justify-between text-[11px] font-semibold text-gray-500 bg-gray-50 rounded-lg p-2 px-4">
                <span>{{ $stats['missions'] ?? 0 }} missions</span>
                <span class="text-green-600 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> En ligne
                </span>
            </div>
            
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
            <a href="/pet-keeper/dashboard" class="flex items-center gap-3 px-4 py-3.5 bg-amber-50 text-amber-800 font-bold rounded-xl transition-all shadow-sm border-l-4 border-amber-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Tableau de bord
            </a>
            
            <a href="/petkeeper/missions"
 class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Mes Missions
            </a>

            <a href="/pet-keeper/profile" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Mon Profil
            </a>

            <a href="/pet-keeper/dashboard/services" class="flex items-center gap-3 px-4 py-3.5 text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900 rounded-xl transition-all group">
                <svg class="w-5 h-5 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                Mes Services
            </a>
        </nav>

        <div class="p-6">
            <button class="flex items-center gap-3 text-gray-400 font-bold text-sm hover:text-red-500 transition-colors w-full px-4 py-2 hover:bg-red-50 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Déconnexion
            </button>
        </div>
    </aside>







    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <!-- Header with Modify Button -->
        <div class="px-6 py-4 bg-gradient-to-r from-yellow-50 to-orange-50 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">{{ $service_name }}</h1>
                <button wire:click="toggleEdit" 
                        class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition duration-200 flex items-center gap-2">
                    @if($isEditing)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Modify Service
                    @endif
                </button>
            </div>
        </div>

        <div class="p-6">
            @if($isEditing)
                <!-- Edit Form -->
                <form wire:submit.prevent="updateService" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Service Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Service Name *
                            </label>
                            <input type="text" wire:model="service_name" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition">
                            @error('service_name') 
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Service Category -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Service Category *
                            </label>
                            <select wire:model="service_category" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition bg-white">
                                <option value="">Select a category</option>
                                @foreach(App\Constants\PetKeeping\Constants::forSelect() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('service_category') 
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Service Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Service Description *
                        </label>
                        <textarea wire:model="service_description" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"></textarea>
                        @error('service_description') 
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Pet Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pet Type Accepted *
                            </label>
                            <select wire:model="service_pet_type" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition bg-white">
                                <option value="">Select a type</option>
                                @foreach(App\Constants\PetKeeping\Constants::getSelectOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('service_pet_type') 
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Criteria -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Payment Criteria *
                            </label>
                            <select wire:model="service_payment_criteria" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition bg-white">
                                @foreach(App\Constants\PetKeeping\Constants::forSelectCriteria() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('service_payment_criteria') 
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Base Price -->
                    <div class="md:w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Base Price *
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                            <input type="number" step="0.01" wire:model="service_base_price" 
                                   class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition">
                        </div>
                        @error('service_base_price') 
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Boolean Checkboxes -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-800">Service Requirements</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Vaccination Required -->
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <input type="checkbox" wire:model="vaccination_required" 
                                       id="vaccination_required"
                                       class="h-5 w-5 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                                <label for="vaccination_required" class="ml-3 text-sm font-medium text-gray-700">
                                    Vaccination Required
                                </label>
                            </div>

                            <!-- Accepts Untrained Pets -->
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <input type="checkbox" wire:model="accepts_untrained_pets" 
                                       id="accepts_untrained_pets"
                                       class="h-5 w-5 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                                <label for="accepts_untrained_pets" class="ml-3 text-sm font-medium text-gray-700">
                                    Accepts Untrained Pets
                                </label>
                            </div>

                            <!-- Accepts Aggressive Pets -->
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <input type="checkbox" wire:model="accepts_aggressive_pets" 
                                       id="accepts_aggressive_pets"
                                       class="h-5 w-5 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                                <label for="accepts_aggressive_pets" class="ml-3 text-sm font-medium text-gray-700">
                                    Accepts Aggressive Pets
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <button type="button" wire:click="cancelEdit"
                                class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Service
                        </button>
                    </div>
                </form>
            @else
                <!-- Display View -->
                <div class="space-y-6">
                    <!-- Service Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-yellow-800 mb-1">Service Name</h3>
                            <p class="text-lg text-gray-900">{{ $service_name }}</p>
                        </div>
                        
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-yellow-800 mb-1">Category</h3>
                            <p class="text-lg text-gray-900">
                                {{ App\Constants\PetKeeping\Constants::getLabel($service_category) ?? $service_category }}
                            </p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Description</h3>
                        <p class="text-gray-800">{{ $service_description }}</p>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Pet Type</h3>
                            <p class="text-gray-900 font-medium">
                                {{ App\Constants\PetKeeping\Constants::getLabel($service_pet_type) ?? $service_pet_type }}
                            </p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Payment Criteria</h3>
                            <p class="text-gray-900 font-medium">
                                {{ App\Constants\PetKeeping\Constants::getLabel($service_payment_criteria) ?? $service_payment_criteria }}
                            </p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Base Price</h3>
                            <p class="text-gray-900 font-medium text-lg">${{ number_format($service_base_price, 2) }}</p>
                        </div>
                    </div>

                    <!-- Requirements -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Service Requirements</h3>
                        <div class="flex flex-wrap gap-3">
                            @if($vaccination_required)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Vaccination Required
                                </span>
                            @endif
                            
                            @if($accepts_untrained_pets)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Accepts Untrained Pets
                                </span>
                            @endif
                            
                            @if($accepts_aggressive_pets)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Accepts Aggressive Pets
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
