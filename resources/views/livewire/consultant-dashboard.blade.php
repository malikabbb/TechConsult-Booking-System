<div>
    @if(session()->has('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md">
            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Today's Schedule -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Today's Schedule
            </h2>
            
            <div class="space-y-4">
                @forelse($todaysBookings as $booking)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 {{ $booking->status === 'confirmed' ? 'border-l-blue-500' : ($booking->status === 'pending' ? 'border-l-yellow-400' : 'border-l-gray-300') }} transition-all hover:shadow-md">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg text-gray-900">{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}</h3>
                                <p class="text-gray-600 mt-1 font-medium">{{ $booking->client->name }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $booking->service->name }} ({{ $booking->service->duration }} min)</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider 
                                {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($booking->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : 
                                   ($booking->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                                {{ $booking->status }}
                            </span>
                        </div>
                        
                        @if(in_array($booking->status, ['pending', 'confirmed']))
                            <div class="mt-4 pt-4 border-t border-gray-50 flex gap-2">
                                @if($booking->status === 'pending')
                                    <button wire:click="updateStatus({{ $booking->id }}, 'confirmed')" class="text-sm bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-2 rounded-lg font-medium transition-colors">Confirm</button>
                                @endif
                                @if($booking->status === 'confirmed')
                                    <button wire:click="updateStatus({{ $booking->id }}, 'completed')" class="text-sm bg-green-50 hover:bg-green-100 text-green-700 px-4 py-2 rounded-lg font-medium transition-colors">Mark Completed</button>
                                @endif
                                <button wire:click="updateStatus({{ $booking->id }}, 'cancelled')" class="text-sm bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-lg font-medium transition-colors">Cancel</button>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="p-8 text-center bg-gray-50 rounded-xl border border-dashed border-gray-300 text-gray-500 font-medium">
                        No bookings scheduled for today.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Upcoming Bookings -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Upcoming Bookings
            </h2>
            
            <div class="space-y-4">
                @forelse($upcomingBookings as $booking)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($booking->date)->format('M j, Y') }}</h3>
                                <p class="text-sm text-blue-600 font-medium mt-1">{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}</p>
                                <p class="text-gray-600 mt-2 font-medium">{{ $booking->client->name }}</p>
                                <p class="text-sm text-gray-500">{{ $booking->service->name }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider 
                                {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($booking->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : 
                                   ($booking->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                                {{ $booking->status }}
                            </span>
                        </div>
                        
                        @if($booking->status === 'pending')
                            <div class="mt-4 pt-4 border-t border-gray-50">
                                <button wire:click="updateStatus({{ $booking->id }}, 'confirmed')" class="text-sm bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm">Confirm Booking</button>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="p-8 text-center bg-gray-50 rounded-xl border border-dashed border-gray-300 text-gray-500 font-medium">
                        No upcoming bookings found.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
