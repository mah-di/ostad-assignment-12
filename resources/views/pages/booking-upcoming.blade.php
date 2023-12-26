<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your Upcoming Trips') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <section class="my-8">
                        <div class="my-4">
                            <h2 class="text-2xl text-center">Get Ready</h2>
                            <p class="text-lg text-center">List of all your upcoming trips.</p>
                        </div>
                        <div class="flex justify-center mt-8">
                            @if ($bookings->count() > 0)
                            <table class="table-auto px-4 rounded">
                                <thead>
                                    <tr class="bg-slate-100">
                                        <td class="px-4 py-2">From</td>
                                        <td class="px-4 py-2">To</td>
                                        <td class="px-4 py-2">Departure Date </td>
                                        <td class="px-4 py-2">Seats</td>
                                        <td class="px-4 py-2">Fare</td>
                                        <td class="px-4 py-2">PIN</td>
                                        <td class="px-4 py-2">Booked At</td>
                                        <td class="px-4 py-2">View Details</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $booking)
                                    @if ($booking->journey > $datetimeNow)
                                    <tr class="py-4 bg-slate-50">
                                        <td class="px-4 py-2">{{ $booking->trip->origin->name }}</td>
                                        <td class="px-4 py-2">{{ $booking->trip->destination->name }}</td>
                                        <td class="px-4 py-2">{{ $booking->journey->getDepartureDate() }}</td>
                                        <td class="px-4 py-2">{{ $booking->tickets->count() }}</td>
                                        <td class="px-4 py-2">{{ $booking->payable }}</td>
                                        <td class="px-4 py-2">{{ $booking->pin }}</td>
                                        <td class="px-4 py-2">{{ $booking->created_at->format('h:i A | d M Y') }}</td>
                                        <td class="px-4 py-2">
                                            <a class="text-sky-500 link" href="{{ route('booking.show', $booking->id) }}">
                                                Details
                                            </a>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <div class="mt-4">
                                <p class="text-xl">Nothing to show...</p>
                            </div>
                            @endif
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
