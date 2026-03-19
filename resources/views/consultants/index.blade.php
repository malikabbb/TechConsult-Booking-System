<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Find an Expert') }}
        </h2>
        <p class="text-sm text-gray-500 mt-1">Browse our network of technical consultants and book a session.</p>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:consultant-list />
        </div>
    </div>
</x-app-layout>
