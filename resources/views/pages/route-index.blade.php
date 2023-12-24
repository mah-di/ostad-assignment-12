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
                    <div class="my-2 flex justify-end">
                        <a class="py-2 px-4 rounded bg-gray-100" href="{{ route('route.create') }}">Register New Route</a>
                    </div>
                    @foreach ($routes as $route)
                    <div class="mt-2 mb-2 p-4 bg-slate-50">
                        <a class="bg-slate-100" href="{{ route('route.show', $route->id) }}">
                            <p class="text-2xl">Origin Location: <b>{{ $route->origin->name }}</b></p>
                            <p class="text-2xl">Destination Location: <b>{{ $route->destination->name }}</b></p>
                            <p class="text-2xl">Route Name: <b>{{ $route->name }}</b></p>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
