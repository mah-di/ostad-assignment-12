<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Register Fare') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Fare Register') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Register a new fare information.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('fare.store') }}" class="mt-6 space-y-6">
                            @csrf

                            <div>
                                <x-input-label for="origin_id" :value="__('Origin')" />
                                <select class="rounded-md mt-1 block w-full border-gray-300" name="origin_id" id="" required>
                                    <option value="">Select Origin</option>
                                    @foreach ($stops as $stop)
                                        <option value="{{ $stop->id }}">{{ $stop->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('price')" />
                            </div>

                            <div>
                                <x-input-label for="destination_id" :value="__('Destination')" />
                                <select class="rounded-md mt-1 block w-full border-gray-300" name="destination_id" id="" required>
                                    <option value="">Select Destination</option>
                                    @foreach ($stops as $stop)
                                        <option value="{{ $stop->id }}">{{ $stop->name }}</option>
                                    @endforeach
                                </select>
                                @if (session('destination_id'))
                                    <x-input-error class="mt-2" :messages="session('destination_id')" />
                                @endif
                            </div>

                            <div>
                                <x-input-label for="price" :value="__('Fare Price')" />
                                <x-text-input id="price" name="price" type="number" class="mt-1 block w-full" required autofocus autocomplete="price" />
                                <x-input-error class="mt-2" :messages="$errors->get('price')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                @if (session('status') === 'fare-created')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>

                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
