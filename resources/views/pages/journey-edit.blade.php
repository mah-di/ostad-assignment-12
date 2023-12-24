<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Journey') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Update Journey') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Update information for <b>{{ " {$journey->route->origin->name}-{$journey->route->destination->name}" }}</b> at <b>{{ $journey->getDeparture() }}</b>
                            </p>
                        </header>

                        <form method="post" action="{{ route('journey.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <input type="hidden" name="id" value="{{ $journey->id }}">

                            <div>
                                <x-input-label for="bus_id" :value="__('Select A Bus')" />
                                <select class="rounded-md mt-1 block w-full border-gray-300" name="bus_id" id="" required>
                                    <option value="">--select an option--</option>
                                    @foreach ($buses as $bus)
                                        @if ($bus->id == $journey->bus_id)
                                            <option selected value="{{ $bus->id }}">{{ $bus->bus_no }}</option>
                                        @else
                                            <option value="{{ $bus->id }}">{{ $bus->bus_no }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('bus_id')" />
                            </div>

                            <div>
                                <x-input-label for="departure" :value="__('Departure Time')" />
                                <x-text-input id="departure" name="departure" type="datetime-local" class="mt-1 block w-full" value="{{ $journey->departure }}" min="{{ $minDatetime }}" required autofocus autocomplete="departure" />
                                <x-input-error class="mt-2" :messages="$errors->get('departure')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>

                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
