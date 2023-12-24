<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl">Book your trip</h2>
                    <br>
                    <p>Trip date: {{ $trip->journey->getDepartureDate() }}</p>
                    <p>Trip origin: {{ $trip->origin->name }}</p>
                    <p>Trip destination: {{ $trip->destination->name }}</p>
                    <br>
                    @if (session('seats'))
                        <x-input-error class="mt-2" :messages="session('seats')" />
                    @endif
                    <br>
                    <form method="post" action="{{ route('trip.confirm') }}">
                        @csrf

                        <input type="hidden" name="id" value="{{ $trip->id }}">

                        <div class="grid grid-cols-4 gap-4">
                            @foreach ($trip->seats as $seat)
                                <div class="p-4 rounded-md {{ $seat->available ? 'bg-slate-50' : 'bg-red-300' }}">
                                    <div class="flex justify-center">
                                        @if ($seat->available)
                                            <x-text-input class="mt-1" type="checkbox" name="seats[]" id="" value="{{ $seat->id }}" />
                                        @endif
                                        <span>&nbsp;&nbsp;<b>{{ $seat->row.$seat->column }}</b></span>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <button type="submit" class="rounded-md mt-4 py-4 w-full bg-green-200">Submit</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
