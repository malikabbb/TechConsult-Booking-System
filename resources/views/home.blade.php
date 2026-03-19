<x-app-layout>
    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-20">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl space-y-2">
                            <span class="block text-gray-900">Expert technical</span>
                            <span class="block text-blue-600">consultation, offline.</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Book in-person sessions with top-tier software architects, cloud engineers, and database specialists to solve your toughest technical challenges.
                        </p>
                        <div class="mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="{{ route('consultants.index') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg transition-transform transform hover:-translate-y-0.5">
                                    Find a Consultant
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                @guest
                                    <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-blue-700 bg-blue-100 hover:bg-blue-200 md:py-4 md:text-lg transition-colors">
                                        Join as Expert
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-gray-50 flex items-center justify-center hidden lg:flex">
             <div class="w-3/4 h-3/4 bg-blue-100 rounded-3xl opacity-50 absolute transform rotate-6"></div>
             <div class="w-3/4 h-3/4 bg-indigo-100 rounded-3xl opacity-50 absolute transform -rotate-3"></div>
             <div class="w-3/4 h-3/4 bg-white rounded-3xl shadow-xl z-20 flex flex-col p-8 border border-gray-100">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-16 h-16 bg-blue-500 rounded-full flex-shrink-0"></div>
                    <div>
                        <div class="w-32 h-4 bg-gray-200 rounded mb-2"></div>
                        <div class="w-24 h-3 bg-gray-100 rounded"></div>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="w-full h-8 bg-gray-50 rounded"></div>
                    <div class="w-full h-8 bg-gray-50 rounded"></div>
                    <div class="w-5/6 h-8 bg-gray-50 rounded"></div>
                </div>
                <div class="mt-auto pt-6 border-t border-gray-100">
                    <div class="w-full h-12 bg-blue-600 rounded-lg mt-4"></div>
                </div>
             </div>
        </div>
    </div>

    <!-- Features -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Why choose us</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    A better way to get technical advice
                </p>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Verified Experts</h3>
                        <p class="mt-2 text-gray-500">Connect with industry professionals with proven track records in massive tech stacks.</p>
                    </div>
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Seamless Booking</h3>
                        <p class="mt-2 text-gray-500">Pick a service, select an available date, and lock your slot instantly without back-and-forth emails.</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">In-Person Collaboration</h3>
                        <p class="mt-2 text-gray-500">Meet face-to-face for whiteboarding, architecture reviews, and high-focus deep dives.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
