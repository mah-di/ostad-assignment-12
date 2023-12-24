<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Route Info') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-2xl">Route Name: <b>{{ $route->name }}</b></p>
                    <p class="text-2xl">Status: <b>{{ $route->status }}</b></p>
                    <br>
                    <p class="text-2xl">Origin Location: <b>{{ $route->origin->name }}</b></p>
                    <p class="text-2xl">Destination Location: <b>{{ $route->destination->name }}</b></p>
                    <br>
                    <p class="text-2xl">Stoppages</p>
                    <ul>
                        <li> • <b>{{ $route->origin->name }}</b></li>
                        @foreach ($route->stops as $stop)
                            <li>↓ <b>{{ $stop->name }}</b></li>
                        @endforeach
                        <li> • <b>{{ $route->destination->name }}</b></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
