<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Your Upcoming Sessions</h3>
                    
                    @php
                        $bookings = auth()->user()->bookings()->with(['consultant.user', 'service'])->orderBy('date')->orderBy('start_time')->get();
                    @endphp

                    @if($bookings->isEmpty())
                        <div class="p-6 text-center text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-200">
                            You don't have any bookings yet. 
                            <a href="{{ route('consultants.index') }}" class="text-blue-600 font-semibold ml-1 hover:underline">Find a consultant</a>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($bookings as $booking)
                                <div class="p-5 border border-gray-100 rounded-xl bg-gray-50 flex flex-col sm:flex-row justify-between sm:items-center">
                                    <div>
                                        <h4 class="font-bold text-gray-900">{{ $booking->consultant->user->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $booking->service->name }} ({{ $booking->service->duration }} mins)</p>
                                        <p class="text-sm font-medium text-blue-600 mt-1">
                                            {{ \Carbon\Carbon::parse($booking->date)->format('F j, Y') }} at {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}
                                        </p>
                                    </div>
                                    <div class="mt-4 sm:mt-0">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider 
                                            {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($booking->status === 'confirmed' ? 'bg-blue-100 text-blue-800' : 
                                               ($booking->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                                            {{ $booking->status }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
