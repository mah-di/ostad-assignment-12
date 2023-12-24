<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Booking Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-center text-2xl">IM Travels</p>
                    <br>
                    <p class="text-center">Booking Info</p>
                    <p class="text-center text-xl">{{ $booking->trip->origin->name }} - {{ $booking->trip->destination->name }}</p>
                    <br>
                    <p class="text-center">Departure From</p>
                    <p class="text-center text-xl">{{ $booking->route->origin->name }} - {{ $booking->journey->getDeparture() }}</p>
                    <br>
                    <p class="text-center">Bus No</p>
                    <p class="text-center text-xl">{{ $booking->journey->bus->bus_no }}</p>
                    <br>
                    <p class="text-center">Seat(s)</p>
                    <p class="text-center text-xl">|
                        @foreach ($booking->tickets as $ticket)
                        &nbsp;&nbsp;&nbsp;
                        {{ $ticket->seat->row.$ticket->seat->column }}
                        &nbsp;&nbsp;&nbsp;|
                        @endforeach
                    </p>
                    <br>
                    <p class="text-center">PIN</p>
                    <p class="text-center text-xl">{{ $booking->pin }}</p>
                    <br>
                    <p class="text-center">Total Fare</p>
                    <p class="text-center text-xl">{{ $booking->payable }}</p>
                    <br>
                    <p class="text-center">Booking Date & Time</p>
                    <p class="text-center text-xl">{{ $booking->created_at->format('h:i A | d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
