<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('consultants.index') }}" class="text-gray-500 hover:text-gray-900 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Book a Session') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Booking consultation with {{ $consultant->user->name }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:booking-wizard :consultant="$consultant" />
        </div>
    </div>
</x-app-layout>
