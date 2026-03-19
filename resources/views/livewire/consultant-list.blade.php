<div>
    <div class="mb-8">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by name or specialization..." class="w-full sm:w-1/2 md:w-1/3 px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($consultants as $consultant)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-md transition-shadow duration-300">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $consultant->user->name }}</h3>
                    <p class="text-blue-600 font-medium mt-1">{{ $consultant->specialization }}</p>
                    <p class="text-gray-500 text-sm mt-3 line-clamp-2">{{ $consultant->bio }}</p>
                    
                    <div class="mt-4 space-y-2 text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $consultant->experience_years }} years experience
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $consultant->office_location ?? 'Online only' }}
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                    <div>
                        <span class="text-2xl font-bold text-gray-900">${{ rtrim(rtrim($consultant->session_price, '0'), '.') }}</span>
                        <span class="text-sm text-gray-500">/hr</span>
                    </div>
                    @auth
                        @if(auth()->user()->isClient())
                            <a href="{{ route('booking', $consultant->id) }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm cursor-pointer">
                                Book Session
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-semibold rounded-lg transition-colors cursor-pointer">
                            Login to Book
                        </a>
                    @endauth
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-gray-500 bg-white rounded-xl border border-dashed border-gray-300">
                No consultants found matching your search.
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $consultants->links() }}
    </div>
</div>
