<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('List of Infrastructures') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative bottom-4 max-w-7xl w-full sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 align-middle">
                <div class="mb-4 sm:mb-0">
                    <x-search-component route='infrastructure.search' />
                </div>
                <div class=" text-blue-500 text-end align-middle">
                    <a class='mx-4 transition ease-linear duration-100 hover:underline hover:text-blue-400' href="{{route('infrastructure.index')}}" >All</a>
                    <a class='mx-4 transition ease-linear duration-100 hover:underline hover:text-blue-400' href="{{route('infrastructure.filter',['filter'=> 'Stadium'])}}">Stadiums</a>
                    <a class='mx-4 transition ease-linear duration-100 hover:underline hover:text-blue-400' href="{{route('infrastructure.filter',['filter'=> 'Pool'])}}">Swimming Pools</a>
                    <a class='mx-4 transition ease-linear duration-100 hover:underline hover:text-blue-400' href="{{route('infrastructure.filter',['filter'=> 'Hall'])}}">Halls</a>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-8">
                        @foreach ($infrastructures as $infrastructure)
                            <x-infrastructure-card :infrastructure="$infrastructure" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>