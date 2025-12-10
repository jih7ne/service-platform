<div class="w-full mb-8">
    <div class="flex items-center justify-between max-w-3xl mx-auto">
        @foreach($steps as $stepNumber => $stepLabel)
            <div class="flex flex-col items-center flex-1 relative">
                <!-- Cercle du step -->
                <div class="flex items-center justify-center w-12 h-12 rounded-full border-2 transition-all duration-300 z-10
                    {{ $currentStep > $stepNumber ? 'bg-[#2B5AA8] border-[#2B5AA8]' : 
                       ($currentStep == $stepNumber ? 'bg-[#2B5AA8] border-[#2B5AA8]' : 'bg-white border-gray-300') }}">
                    @if($currentStep > $stepNumber)
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    @else
                        <span class="text-lg font-bold 
                            {{ $currentStep == $stepNumber ? 'text-white' : 'text-gray-400' }}">
                            {{ $stepNumber }}
                        </span>
                    @endif
                </div>

                <!-- Label du step -->
                <span class="mt-2 text-sm font-semibold
                    {{ $currentStep >= $stepNumber ? 'text-[#2B5AA8]' : 'text-gray-400' }}">
                    {{ $stepLabel }}
                </span>

                <!-- Ligne de connexion -->
                @if($stepNumber < count($steps))
                    <div class="absolute top-6 left-1/2 w-full h-0.5 -z-1 transition-all duration-300
                        {{ $currentStep > $stepNumber ? 'bg-[#2B5AA8]' : 'bg-gray-300' }}">
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>