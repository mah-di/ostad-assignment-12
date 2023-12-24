<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Stop Info') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="my-2 flex justify-end">
                        <a class="py-2 px-4 rounded bg-gray-100" href="{{ route('stop.create') }}">Register New Stoppage</a>
                    </div>
                    @foreach ($stops as $stop)
                        <div class="mt-2 mb-2 p-2 bg-slate-50">
                            <p class="text-2xl">Stoppage Name: <b>{{ $stop->name }}</b></p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
