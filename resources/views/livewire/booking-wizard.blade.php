<div class="max-w-3xl mx-auto">
    <!-- Stepper Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between relative">
            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 z-0 rounded-full"></div>
            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-1 bg-blue-600 z-0 rounded-full transition-all duration-300" style="width: {{ ($step - 1) * 33.33 }}%"></div>
            
            @foreach(['Service', 'Date', 'Time', 'Confirm'] as $index => $label)
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300 {{ $step > $index + 1 ? 'bg-blue-600 text-white' : ($step === $index + 1 ? 'bg-blue-600 text-white ring-4 ring-blue-100' : 'bg-gray-200 text-gray-500') }}">
                        @if($step > $index + 1)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            {{ $index + 1 }}
                        @endif
                    </div>
                    <span class="mt-2 text-xs font-semibold {{ $step >= $index + 1 ? 'text-gray-900' : 'text-gray-400' }}">{{ $label }}</span>
                </div>
            @endforeach
        </div>
    </div>

    @if(session()->has('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
            <p class="text-sm border-red-500 text-red-700">{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Step 1: Select Service -->
        @if($step === 1)
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Select a Service</h2>
                <div class="space-y-4">
                    @forelse($services as $service)
                        <button wire:click="selectService({{ $service->id }})" class="w-full text-left p-5 rounded-xl border-2 {{ $selectedServiceId === $service->id ? 'border-blue-600 bg-blue-50' : 'border-gray-100 hover:border-blue-300' }} transition-colors">
                            <h3 class="font-bold text-gray-900">{{ $service->name }}</h3>
                            <p class="text-gray-500 text-sm mt-1">{{ $service->duration }} minutes session</p>
                        </button>
                    @empty
                        <p class="text-gray-500">This consultant has no services listed yet.</p>
                    @endforelse
                </div>
            </div>
        @endif

        <!-- Step 2: Select Date -->
        @if($step === 2)
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Choose a Date</h2>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Date</label>
                    <input type="date" wire:model="selectedDate" min="{{ $minDate }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 py-3 shadow-sm">
                    @error('selectedDate') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div class="flex justify-between mt-8 pt-6 border-t border-gray-100">
                    <button wire:click="goBack" class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium transition-colors">Back</button>
                    <button wire:click="selectDate" class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-medium transition-colors" {{ !$selectedDate ? 'disabled' : '' }}>Continue</button>
                </div>
            </div>
        @endif

        <!-- Step 3: Select Time Slot -->
        @if($step === 3)
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Available Time Slots</h2>
                <p class="text-gray-600 mb-6 font-medium">For {{ \Carbon\Carbon::parse($selectedDate)->format('l, F j, Y') }}</p>
                
                @if(empty($availableSlots))
                    <div class="p-6 bg-gray-50 rounded-xl text-center text-gray-500 border border-dashed border-gray-300">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p>No available slots found for this date. The consultant might be fully booked or unavailable.</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        @foreach($availableSlots as $slot)
                            <button wire:click="selectSlot('{{ $slot['start'] }}', '{{ $slot['end'] }}')" 
                                class="py-3 px-2 rounded-lg border border-gray-200 hover:border-blue-500 hover:bg-blue-50 hover:text-blue-700 text-sm font-medium text-gray-700 transition-colors shadow-sm">
                                {{ explode(' - ', $slot['label'])[0] }}
                            </button>
                        @endforeach
                    </div>
                @endif
                
                <div class="flex justify-between mt-8 pt-6 border-t border-gray-100">
                    <button wire:click="goBack" class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium transition-colors">Back</button>
                </div>
            </div>
        @endif

        <!-- Step 4: Confirm Booking -->
        @if($step === 4)
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Confirm Your Session</h2>
                
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 mb-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6">
                        <div>
                            <p class="text-sm text-blue-600 font-semibold uppercase tracking-wider">Consultant</p>
                            <p class="mt-1 text-lg font-bold text-gray-900">{{ $consultant->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-blue-600 font-semibold uppercase tracking-wider">Service</p>
                            @php $selSvc = \App\Models\Service::find($selectedServiceId); @endphp
                            <p class="mt-1 text-lg font-bold text-gray-900">{{ $selSvc ? $selSvc->name : '' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-blue-600 font-semibold uppercase tracking-wider">Date</p>
                            <p class="mt-1 text-lg font-bold text-gray-900">{{ \Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-blue-600 font-semibold uppercase tracking-wider">Time</p>
                            <p class="mt-1 text-lg font-bold text-gray-900">
                                {{ \Carbon\Carbon::parse($selectedSlotStart)->format('h:i A') }} - {{ \Carbon\Carbon::parse($selectedSlotEnd)->format('h:i A') }}
                            </p>
                        </div>
                        <div class="sm:col-span-2 pt-4 border-t border-blue-200 mt-2">
                            <p class="text-sm text-blue-600 font-semibold uppercase tracking-wider">Session Price</p>
                            <p class="mt-1 text-2xl font-bold text-gray-900">${{ rtrim(rtrim($consultant->session_price, '0'), '.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-100">
                    <button wire:click="goBack" class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium transition-colors">Back</button>
                    <button wire:click="confirmBooking" class="px-8 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700 font-bold text-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5" wire:loading.attr="disabled">
                        <span wire:loading.remove>Confirm & Book Session</span>
                        <span wire:loading>Processing...</span>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
