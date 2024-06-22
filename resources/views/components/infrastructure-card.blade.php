@props(['infrastructure'])

<div class="max-w-xl min-w-32 w-72 mx-auto bg-gray-200 dark:bg-slate-700 shadow-md rounded-md overflow-hidden">
    <div class="relative h-50 bg-gray-300">
        <img class="w-full h-56" src="{{ asset('storage/' . $infrastructure->main_image) }}" alt="Infrastructure Photo">
    </div>

    @php
        if ($infrastructure->infrastructable instanceof Pool) {
            $infrastr = $infrastructure->infrastructable->pool_type;
        }else if ($infrastructure->infrastructable instanceof Stadium) {
            $infrastr = $infrastructure->infrastructable->stadium_type;

        }else if ($infrastructure->infrastructable instanceof Hall) {
            $infrastr = $infrastructure->infrastructable->hall_type;
        }
    @endphp

    <div class="p-4">
        <div class="mb-4">

            <h2 class="text-xl font-bold">{{ $infrastructure->name }}</h2>
            <p class="text-sm text-gray-500 dark:text-white">Type: {{ $infrastructure->infrastructable_type }}</p>
            {{-- <p class="text-sm text-gray-500 dark:text-white">Type 2: {{ $infrastr }}</p> --}}
            {{-- <p class="text-sm text-gray-500 dark:text-white">City: {{ $infrastructure->ville }}</p>
            <p class="text-sm text-gray-500 dark:text-white">Address: {{ $infrastructure->cite }}</p>
            <p class="text-sm text-gray-700 dark:text-slate-400">{{ $infrastructure->description }}</p> --}}
        </div>

        <div>
            <p class="text-sm text-gray-500 dark:text-white">Managed by:</p>
            <p class="text-sm font-semibold">{{ $infrastructure->gestionnaire->user->nom.' '.$infrastructure->gestionnaire->user->prenom }}</p>
        </div>
    </div>
    @auth
        @if(auth()->user()->role == 'client')
        
            <div class="grid grid-cols-1 sm:grid-cols-2">
                <div class="p-4">
                    <a href="{{route('reservations.create', ['id' => $infrastructure->id])}}" class="px-4 py-2 bg-blue-500 text-white rounded-md">Reserve</a>
                </div>
                <div class="p-4">
                    <a href="{{route('infrastructure.details', ['infrastructure' => $infrastructure->id])}}" class="px-4 py-2 text-blue-500 rounded-md">Details</a>
                </div>
            </div>
        @else 
            @if (auth()->user()->role == 'gestionnaire')
                
                <div class="p-4">
                    <a href="{{route('gestionnaire.infrastructure.show', ['infrastructure' => $infrastructure->id])}}" class="px-4 py-2 text-blue-500 rounded-md">Details</a>
                </div>
            @else
                @if (auth()->user()->role == 'admin')
                    <div class="p-4">
                        <a href="{{route('admin.infrastructure.details', ['infrastructure' => $infrastructure->id])}}" class="px-4 py-2 text-blue-500 rounded-md">Details</a>
                    </div>
                @endif
            @endif
        @endif
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2">
            <div class="p-4">
                <a href="{{route('reservations.create', ['id' => $infrastructure->id])}}" class="px-4 py-2 bg-blue-500 text-white rounded-md">Reserve</a>
            </div>
            <div class="p-4">
                <a href="{{route('guest.infrastructure.details', ['infrastructure' => $infrastructure->id])}}" class="px-4 py-2 text-blue-500 rounded-md">Details</a>
            </div>
        </div>
    @endauth
</div>
