<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Register Bus') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Bus Register') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Register a new bus.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('bus.store') }}" class="mt-6 space-y-6">
                            @csrf

                            <div>
                                <x-input-label for="bus_no" :value="__('Bus Number')" />
                                <x-text-input id="bus_no" name="bus_no" type="text" class="mt-1 block w-full" required autofocus autocomplete="bus_no" />
                                <x-input-error class="mt-2" :messages="$errors->get('bus_no')" />
                            </div>

                            <div>
                                <x-input-label for="number_of_seats" :value="__('Number Of Seats')" />
                                <x-text-input id="number_of_seats" name="number_of_seats" type="text" class="mt-1 block w-full bg-gray-100 text-gray-500" value="36" required disabled autofocus autocomplete="number_of_seats" />
                                <x-input-error class="mt-2" :messages="$errors->get('number_of_seats')" />
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
