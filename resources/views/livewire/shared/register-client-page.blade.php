<div>
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <livewire:shared.header />
        </div>
    </div>

    <div class="min-h-screen bg-[#F7F7F7] py-12 flex items-start justify-center">
        <div class="max-w-2xl w-full mx-auto px-4 sm:px-6 lg:px-8">
            
            @if (session()->has('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 ring-1 ring-gray-50">
                <div class="text-center mb-8">
                    <h1 class="text-3xl mb-2 text-black font-extrabold">Inscription Client</h1>
                    <p class="text-base text-[#6b7280] font-medium">Créez votre compte pour accéder à nos services</p>
                </div>

                @if($currentStep != 2)
                <div class="w-full mb-8">
                    <div class="flex items-center justify-center max-w-md mx-auto">
                        @php
                            $stepLabels = [1 => 'Informations', 1.5 => 'Vérification', 2 => 'Finalisation'];
                            $stepNumbers = [1, 1.5, 2];
                        @endphp
                        @foreach($stepNumbers as $index => $stepNum)
                            <div class="flex items-center {{ $stepNum < 2 ? 'flex-1' : '' }}">
                                <div class="flex flex-col items-center">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 transition-all duration-300 z-10 {{ $currentStep > $stepNum ? 'bg-[#2B5AA8] border-[#2B5AA8]' : ($currentStep == $stepNum ? 'bg-[#2B5AA8] border-[#2B5AA8]' : 'bg-white border-gray-300') }}">
                                        @if($currentStep > $stepNum)
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @else
                                            <span class="text-sm font-bold {{ $currentStep == $stepNum ? 'text-white' : 'text-gray-400' }}">{{ $index + 1 }}</span>
                                        @endif
                                    </div>
                                    <span class="mt-1 text-xs font-semibold text-center {{ $currentStep >= $stepNum ? 'text-[#2B5AA8]' : 'text-gray-400' }}">{{ $stepLabels[$stepNum] }}</span>
                                </div>
                                @if($stepNum < 2)
                                    <div class="flex-1 h-0.5 mx-2 transition-all duration-300 {{ $currentStep > $stepNum ? 'bg-[#2B5AA8]' : 'bg-gray-300' }}"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <form wire:submit.prevent="{{ $currentStep == 1 ? 'sendVerificationCode' : ($currentStep == 1.5 ? 'verifyCode' : 'register') }}" class="space-y-6">

                    @if($currentStep == 1)
                    <div class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">Prénom <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="firstName" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a] @error('firstName') border-red-500 @enderror" placeholder="Jean" />
                                @error('firstName') 
                                    <span class="text-red-500 text-sm mt-1 block flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">Nom <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="lastName" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a] @error('lastName') border-red-500 @enderror" placeholder="Dupont" />
                                @error('lastName') 
                                    <span class="text-red-500 text-sm mt-1 block flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">Email <span class="text-red-500">*</span></label>
                            <input type="email" wire:model="email" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a] @error('email') border-red-500 @enderror" placeholder="jean.dupont@email.com" />
                            @error('email') 
                                <span class="text-red-500 text-sm mt-1 block flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">Téléphone <span class="text-red-500">*</span></label>
                                <input type="tel" wire:model="telephone" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a] @error('telephone') border-red-500 @enderror" placeholder="06XXXXXXXX" />
                                @error('telephone') 
                                    <span class="text-red-500 text-sm mt-1 block flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">Date de Naissance <span class="text-red-500">*</span></label>
                                <input type="date" wire:model="dateNaissance" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a] @error('dateNaissance') border-red-500 @enderror" />
                                @error('dateNaissance') 
                                    <span class="text-red-500 text-sm mt-1 block flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">Mot de passe <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" wire:model="password" id="password" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-[#0a0a0a] pr-12 @error('password') border-red-500 @enderror" placeholder="••••••••" />
                                <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password') 
                                <span class="text-red-500 text-sm mt-1 block flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </span>
                            @enderror
                            <div class="mt-2 text-xs text-gray-500">Le mot de passe doit contenir au moins 8 caractères</div>
                        </div>

                        <div class="text-sm text-[#6b7280] flex items-center gap-1">
                            <span class="text-red-500">*</span> 
                            <span>Champs obligatoires</span>
                        </div>

                        <div class="flex gap-3 pt-4">
                            <a href="/inscription" class="px-8 py-3 bg-[#e5e7eb] text-[#374151] rounded-lg hover:bg-[#d1d5db] transition-all font-semibold flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Retour
                            </a>
                            <button type="submit" wire:loading.attr="disabled" wire:target="sendVerificationCode" class="flex-1 py-3 bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91] transition-all font-bold shadow-md flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span wire:loading.remove wire:target="sendVerificationCode">Continuer</span>
                                <span wire:loading wire:target="sendVerificationCode">Envoi en cours...</span>
                                <svg wire:loading.remove wire:target="sendVerificationCode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                <svg wire:loading wire:target="sendVerificationCode" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endif

                    @if($currentStep == 1.5)
                    <div class="space-y-6">
                        <div class="text-center">
                            <div class="w-20 h-20 bg-[#E1EAF7] rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-[#2B5AA8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-black mb-2">Vérifiez votre email</h2>
                            <p class="text-gray-600">Nous avons envoyé un code de vérification à<br><span class="font-semibold text-[#2B5AA8]">{{ $email }}</span></p>
                        </div>

                        <div>
                            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold text-center">Code de vérification (10 chiffres)</label>
                            <input type="text" wire:model="verificationCode" maxlength="10" class="w-full px-4 py-4 bg-white border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] focus:border-transparent transition-all text-center text-2xl tracking-widest font-mono" placeholder="0000000000" />
                            @error('verificationCode') 
                                <span class="text-red-500 text-sm mt-1 block text-center">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex gap-3">
                            <button type="button" wire:click="previousStep" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all font-semibold flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Retour
                            </button>
                            <button type="submit" wire:loading.attr="disabled" wire:target="verifyCode" class="flex-1 py-3 bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91] transition-all font-bold disabled:opacity-50">
                                <span wire:loading.remove wire:target="verifyCode">Vérifier le code</span>
                                <span wire:loading wire:target="verifyCode">Vérification...</span>
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="text-sm text-gray-600">Vous n'avez pas reçu le code ?
                                <button type="button" wire:click="resendCode" class="text-[#2B5AA8] font-semibold hover:underline">Renvoyer</button>
                            </p>
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-sm text-yellow-800 flex items-start gap-2">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                Le code expire dans 10 minutes. Vérifiez vos spams si vous ne le trouvez pas.
                            </p>
                        </div>
                    </div>
                    @endif

                    @if($currentStep == 2)
                    <div class="space-y-6">
                        <h2 class="text-xl font-bold text-black mb-4">Localisation et Photo</h2>

                        <!-- Photo de profil -->
                        <div>
                            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">Photo de profil (optionnel)</label>
                            <input type="file" wire:model="photo_profil" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#2B5AA8] file:text-white hover:file:bg-[#224A91]" />
                            <p class="text-sm text-[#6b7280] mt-2">Téléchargez une photo pour personnaliser votre profil.</p>
                            @error('photo_profil') 
                                <span class="text-red-500 text-sm mt-2 block flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </span>
                            @enderror
                            @if($photo_profil)
                                <div class="mt-3">
                                    <img src="{{ $photo_profil->temporaryUrl() }}" class="h-24 w-24 rounded-full object-cover border-2 border-[#2B5AA8]" alt="Aperçu">
                                </div>
                            @endif
                        </div>

                        <!-- Localisation -->
                        <div>
                            <label class="block text-sm mb-2 text-[#2a2a2a] font-semibold">Localisation</label>
                            
                            <!-- Bouton localisation automatique -->
                            <button
                                type="button"
                                id="locationBtnClient"
                                onclick="getLocationForClient()"
                                class="w-full py-3 bg-[#E1EAF7] text-[#2B5AA8] rounded-lg hover:bg-[#d1dbf0] transition-all font-semibold flex items-center justify-center gap-2 mb-4"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Obtenir ma localisation automatique
                            </button>

                            <div class="relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-4 bg-white text-gray-500 font-medium">ou saisissez manuellement</span>
                                </div>
                            </div>

                            <!-- Champs de localisation -->
                            <div class="grid md:grid-cols-2 gap-4 mt-4">
    <div>
        <label class="block text-xs mb-1 text-gray-600 font-medium">Pays</label>
        <input type="text" wire:model="pays" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] text-sm" placeholder="Ex: Maroc" />
        @error('pays') 
            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label class="block text-xs mb-1 text-gray-600 font-medium">Ville</label>
        <input type="text" wire:model="ville" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] text-sm" placeholder="Ex: Tétouan" />
        @error('ville') 
            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
        @enderror
    </div>
</div>

                            <div class="mt-4">
                                <label class="block text-xs mb-1 text-gray-600 font-medium">Adresse complète</label>
                                <textarea wire:model="adresse" rows="2" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2B5AA8] text-sm resize-none" placeholder="Ex: 123 Rue Mohammed V"></textarea>
                                @error('adresse') 
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button type="button" wire:click="previousStep" class="px-8 py-3 bg-[#e5e7eb] text-[#374151] rounded-lg hover:bg-[#d1d5db] transition-all font-semibold flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Retour
                            </button>
                            <button type="submit" wire:loading.attr="disabled" wire:target="register" class="flex-1 py-3 bg-[#2B5AA8] text-white rounded-lg hover:bg-[#224A91] transition-all font-bold shadow-md flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span wire:loading.remove wire:target="register">Créer mon compte</span>
                                <span wire:loading wire:target="register">Inscription en cours...</span>
                                <svg wire:loading wire:target="register" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endif

                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-[#6b7280]">Vous avez déjà un compte ?
                        <a href="/connexion" class="text-[#2B5AA8] hover:underline font-semibold ml-1">Se connecter</a>
                    </p>
                    <a href="/" class="inline-block mt-3 text-sm text-[#2B5AA8] hover:underline font-semibold">Retour à la page d'accueil</a>
                </div>
            </div>
        </div>
    </div>

    <livewire:shared.footer />

    @push('scripts')
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
            }
        }

        // Fonction de géolocalisation pour client
        window.getLocationForClient = function() {
            const btn = document.getElementById('locationBtnClient');
            
            if (!navigator.geolocation) {
                alert('La géolocalisation n\'est pas supportée par votre navigateur.');
                return;
            }

            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            btn.disabled = true;

            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    @this.set('latitude', lat);
                    @this.set('longitude', lng);

                    try {
                        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                        const data = await response.json();

                        if (data.address) {
                            const address = data.address;
                            @this.set('adresse', data.display_name);
                            @this.set('ville', address.city || address.town || address.village || '');
                            @this.set('pays', address.country || '');
                        }

                        btn.innerHTML = originalHTML;
                        btn.disabled = false;
                    } catch (error) {
                        console.error('Erreur de géocodage:', error);
                        btn.innerHTML = originalHTML;
                        btn.disabled = false;
                        alert('Localisation détectée, mais impossible de récupérer l\'adresse. Veuillez remplir manuellement.');
                    }
                },
                (error) => {
                    btn.innerHTML = originalHTML;
                    btn.disabled = false;

                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            alert('❌ Accès à la localisation refusé. Veuillez autoriser l\'accès dans les paramètres de votre navigateur.');
                            break;
                        case error.POSITION_UNAVAILABLE:
                            alert('❌ Les informations de localisation ne sont pas disponibles.');
                            break;
                        case error.TIMEOUT:
                            alert('❌ La demande de localisation a expiré.');
                            break;
                        default:
                            alert('❌ Une erreur inconnue s\'est produite.');
                            break;
                    }
                },
                {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                }
            );
        };

        setInterval(function() {
            fetch('/refresh-csrf').then(response => response.json()).then(data => {
                document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.token);
            }).catch(error => console.error('Erreur rafraîchissement CSRF:', error));
        }, 600000);
    </script>
    @endpush
</div>