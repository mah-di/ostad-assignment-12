<x-app-layout>
    @if (Auth::user()->is_admin)
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 py-24 text-gray-900 dark:text-gray-100">

                    <h2 class="text-center text-2xl mb-8">
                        Revenue Generated
                    </h2>

                    <div class="grid grid-cols-4 gap-8">
                        <div class="py-8 text-xl text-center bg-sky-400 text-slate-50 rounded-md">
                            Today
                            <br>
                            <b>{{ $revenueToday }}</b> BDT
                        </div>
                        <div class="py-8 text-xl text-center bg-sky-400 text-slate-50 rounded-md">
                            This Month
                            <br>
                            <b>{{ $revenueThisMonth }}</b> BDT
                        </div>
                        <div class="py-8 text-xl text-center bg-sky-400 text-slate-50 rounded-md">
                            Last Month
                            <br>
                            <b>{{ $revenueLastMonth }}</b> BDT
                        </div>
                        <div class="py-8 text-xl text-center bg-sky-400 text-slate-50 rounded-md">
                            This Year
                            <br>
                            <b>{{ $revenueYear }}</b> BDT
                        </div>
                    </div>

                    <h2 class="text-center text-2xl mt-16 mb-8">
                        Route Wise Revenue Generated
                    </h2>

                    <div class="grid grid-cols-4 gap-8">
                        @foreach ($routeRevenues as $routeRevenue)
                        <div class="py-8 text-xl text-center bg-sky-400 text-slate-50 rounded-md">
                            {{ $routeRevenue->name }}
                            <br>
                            <b>{{ $routeRevenue->bookings->sum('payable') }}</b> BDT
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
    @else
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="my-48">
                        <div class="flex justify-center">
                            <h2 class="text-2xl">
                                Welcome, {{ Auth::user()->name }}
                            </h2>
                        </div>
                        <div class="mt-8 flex justify-center">
                            <a class="bg-sky-500 text-white rounded-md py-4 px-8" href="{{ route('trip.search') }}">Book a Trip</a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a class="bg-sky-500 text-white rounded-md py-4 px-8" href="{{ route('booking.upcoming') }}">Upcoming Trips</a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a class="bg-sky-500 text-white rounded-md py-4 px-8" href="{{ route('booking.index') }}">Your Bookings</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
