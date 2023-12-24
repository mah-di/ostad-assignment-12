<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ticket Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Ticket Booking') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Search and book trips.") }}
                            </p>
                        </header>

                        <form method="get" action="{{ route('trip.search') }}" class="mt-6 space-y-6">
                            @csrf

                            <div class="flex justify-between">
                                <div>
                                    <select class="rounded-md mt-1 block w-full border-gray-300" name="origin_id" id="" required>
                                        <option value="">Select Origin</option>
                                        @foreach ($stops as $stop)
                                            @if (isset($origin_id) and $origin_id == $stop->id)
                                                <option value="{{ $stop->id }}" selected>{{ $stop->name }}</option>
                                            @else
                                                <option value="{{ $stop->id }}">{{ $stop->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('price')" />
                                </div>

                                <div>
                                    <select class="rounded-md mt-1 block w-full border-gray-300" name="destination_id" id="" required>
                                        <option value="">Select Destination</option>
                                        @foreach ($stops as $stop)
                                            @if (isset($destination_id) and $destination_id == $stop->id)
                                                <option value="{{ $stop->id }}" selected>{{ $stop->name }}</option>
                                            @else
                                                <option value="{{ $stop->id }}">{{ $stop->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if (session('destination_id'))
                                        <x-input-error class="mt-2" :messages="session('destination_id')" />
                                    @endif
                                </div>

                                <div>
                                    <x-text-input id="date" name="date" type="date" value="{{ isset($date) ? $date : '' }}" class="mt-1 block w-full" min="{{ $minDate }}" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('date')" />
                                </div>

                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Search Trips') }}</x-primary-button>
                                </div>
                            </div>

                        </form>
                    </section>
                    <section class="mt-8">
                        @if (isset($trips) and count($trips) > 0)
                        <table class="table-auto">
                            <thead>
                                <tr class="bg-slate-100">
                                    <td class="px-4 py-2">Route</td>
                                    <td class="px-4 py-2">Origin</td>
                                    <td class="px-4 py-2">Departure Date & Time</td>
                                    <td class="px-4 py-2">Destination</td>
                                    <td class="px-4 py-2">Arrival Date & Time</td>
                                    <td class="px-4 py-2">Seats Available</td>
                                    <td class="px-4 py-2">Fare</td>
                                    <td class="px-4 py-2">Book</td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($trips as $trip)
                            <tr class="py-4 bg-slate-50">
                                <td class="px-4 py-2">{{ $trip->journey->route->name }}</td>
                                <td class="px-4 py-2">{{ $trip->journey->route->origin->name }}</td>
                                <td class="px-4 py-2">{{ $trip->journey->getDeparture() }}</td>
                                <td class="px-4 py-2">{{ $trip->journey->route->destination->name }}</td>
                                <td class="px-4 py-2">{{ $trip->journey->getArrival() }}</td>
                                <td class="px-4 py-2">{{ $trip->seats->count() }}</td>
                                <td class="px-4 py-2">{{ $fare->price }} <small>({{ $fare->origin->name }}-{{ $fare->destination->name }})</small></td>
                                <td class="px-4 py-2"><a class="link text-sky-500" href="{{ route('trip.book', $trip->id) }}">Book</a></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="mt-4">
                            <p class="text-xl">Nothing to show...</p>
                        </div>
                        @endif
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
