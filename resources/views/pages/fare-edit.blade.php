<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Fare') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Update Fare') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Update fare price for <b>{{ " {$fare->origin->name}-{$fare->destination->name}" }}</b>
                            </p>
                        </header>

                        <form method="post" action="{{ route('fare.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <input type="hidden" name="id" value="{{ $fare->id }}">

                            <div>
                                <x-input-label for="price" :value="__('Fare Price')" />
                                <x-text-input id="price" name="price" type="text" class="mt-1 block w-full" :value="old('price', $fare->price)" required autofocus autocomplete="price" />
                                <x-input-error class="mt-2" :messages="$errors->get('price')" />
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
