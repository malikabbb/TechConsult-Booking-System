<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('consultants.index') }}" class="text-gray-500 hover:text-gray-900 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Consultant Profile') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        <div class="w-full md:w-2/3">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $consultant->user->name }}</h1>
                            <p class="text-xl text-blue-600 font-medium mt-2">{{ $consultant->specialization }}</p>
                            
                            <div class="mt-6 flex flex-wrap gap-4 text-sm text-gray-600">
                                <span class="flex items-center bg-gray-50 px-3 py-1.5 rounded-full border border-gray-200">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $consultant->experience_years }} years experience
                                </span>
                                <span class="flex items-center bg-gray-50 px-3 py-1.5 rounded-full border border-gray-200">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $consultant->office_location ?? 'Online' }}
                                </span>
                            </div>

                            <div class="mt-8">
                                <h3 class="text-lg font-bold text-gray-900 border-b pb-2 mb-4">About Me</h3>
                                <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $consultant->bio ?? 'No biography provided yet by this consultant.' }}</p>
                            </div>
                        </div>

                        <div class="w-full md:w-1/3 bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="text-center mb-6">
                                <span class="text-3xl font-bold text-gray-900">${{ rtrim(rtrim($consultant->session_price, '0'), '.') }}</span>
                                <span class="text-gray-500 font-medium">/hr standard rate</span>
                            </div>

                            <h4 class="font-bold text-gray-900 mb-3 text-sm uppercase tracking-wider">Available Services</h4>
                            <ul class="space-y-3 mb-8">
                                @forelse($consultant->services as $service)
                                    <li class="flex justify-between items-center text-sm bg-white p-3 border border-gray-100 rounded-lg shadow-sm">
                                        <span class="font-medium text-gray-800">{{ $service->name }}</span>
                                        <span class="text-gray-500">{{ $service->duration }}m</span>
                                    </li>
                                @empty
                                    <li class="text-sm text-gray-500 italic">No specific services listed.</li>
                                @endforelse
                            </ul>

                            @auth
                                @if(auth()->user()->isClient())
                                    <a href="{{ route('booking', $consultant->id) }}" class="block w-full text-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                        Book a Session
                                    </a>
                                @endif
                                @if(auth()->user()->isAdmin() || auth()->user()->id === $consultant->user_id)
                                    <button class="block w-full text-center px-6 py-3 mt-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold rounded-xl transition-colors cursor-not-allowed">
                                        Edit Profile (Coming Soon)
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="block w-full text-center px-6 py-3 bg-gray-800 hover:bg-gray-900 text-white font-bold rounded-xl transition-all shadow-md">
                                    Login to Book
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
