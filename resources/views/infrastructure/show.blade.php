<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @isset($infrastructure)
                {{ $infrastructure->name }} {{$infrastructure->infrastructable_type}} Details
            @else
                {{ __('Infrastructure Details') }}
            @endisset
            
        </h2>
    </x-slot>
    
    <div class="py-12 px-16 grid grid-cols-1 lg:grid-cols-2 gap-4">
        
        <div class="bg-white dark:bg-slate-800 w-full h-fit shadow-lg rounded-lg">
            <div class="bg-gray-200 h-1/2 dark:bg-slate-700">
                <div class="relative h-full bg-gray-300">
                    <img class=" w-full h-full" src="{{ asset('storage/' . $infrastructure->main_image) }}" alt="{{ $infrastructure->name }}" />
                </div>
            </div>
            <div class="flex-wrap">

                <div class="p-4">
                    <div class="mb-4">
                        <h2 class="text-3xl font-bold text-gray-500 dark:text-white">{{ $infrastructure->name }}</h2>
                        <p class="text-md text-gray-500 dark:text-white"><b>Type:</b> {{ $infrastructure->infrastructable_type }}</p>
                    </div>
                    <div class="my-4">
                        <p class="text-md text-gray-500 dark:text-white">City: {{ $infrastructure->ville }}</p>
                        <p class="text-md text-gray-500 dark:text-white">Address: {{ $infrastructure->cite }}</p>
                        <p class="text-md text-gray-700 dark:text-slate-400">{{ $infrastructure->description }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-md text-gray-500 dark:text-white">Managed by:</p>
                        <p class="text-xl font-semibold text-gray-500 dark:text-white">{{ $infrastructure->gestionnaire->user->nom.' '.$infrastructure->gestionnaire->user->prenom }}</p>
                    </div>
                </div>
                @if(auth()->user()->role == 'client')
                    <div class="mb-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2">
                            <div class="p-4">
                                <a href="{{route('reservations.create', ['id' => $infrastructure->id])}}" class="px-4 py-2 bg-blue-500 text-white rounded-md">Reserve</a>
                            </div>
                            <div class="p-4">
                                <a href="{{route('infrastructure.index')}}" class="px-4 py-2 text-blue-500 rounded-md">Back</a>
                            </div>
                        </div>
                    </div>
                @else
                    @if (auth()->user()->role == 'gestionnaire')
                        <div class="mb-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 align-middle">
                                <div class="p-4">
                                    <a href="{{route('gestionnaire.infrastructure.edit', $infrastructure)}}" class="px-4 py-2 bg-blue-500 text-white rounded-md">Edit</a>
                                </div>
                                <div class="p-4">
                                    <form action="{{route("gestionnaire.infrastructure.destroy", $infrastructure)}}" method="post" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        <div class="p-4 mx-4 bg-slate-200 h-fit">
            <h2 id = 'calendar_title'> 
                @isset($infrastructure) 
                Reservation Calendar for <b>{{ $infrastructure->name }}</b>
                @endisset
            </h2>
            
            
            @isset($reservations)
                @include('components.calendar', ['reservations' => $reservations])
            @else
                @include('components.calendar', ['reservations' => []])
            @endisset
                
        </div>
    </div>

    <h2 class="mx-7 font-bold text-3xl text-gray-500 dark:text-white">More Photos for this infrastructure</h2>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-10">
        @foreach($images as $image)
        <div>
            <img src="{{ asset('storage/' . $infrastructure->main_image) }}" alt="{{ $infrastructure->name }}" />
        </div>
        @endforeach
    </div>

    

</x-app-layout>