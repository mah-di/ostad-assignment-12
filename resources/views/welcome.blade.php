@if (Auth::user())
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="my-48">
                        <div class="flex justify-center">
                            <h2 class="text-2xl">
                                IM Travels
                            </h2>
                        </div>
                        <div class="mt-8 flex justify-center">
                            <a class="bg-sky-500 text-white rounded-md py-4 px-8" href="{{ route('trip.search') }}">Book a Trip</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@else
<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="my-48">
                        <div class="flex justify-center">
                            <h2 class="text-2xl">
                                IM Travels
                            </h2>
                        </div>
                        <div class="mt-8 flex justify-center">
                            <a class="bg-sky-500 text-white rounded-md py-4 px-8" href="{{ route('trip.search') }}">Book a Trip</a>
                        </div>
                        <div class="mt-8 flex justify-center">
                            <a class="bg-slate-400 text-white rounded-md py-2 px-4" href="{{ route('login') }}">LogIn</a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a class="bg-slate-400 text-white rounded-md py-2 px-4" href="{{ route('register') }}">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
@endif
