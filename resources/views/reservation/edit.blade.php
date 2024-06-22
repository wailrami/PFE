<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @isset($reservation)
            {{ __('Edit Reservation') }} for {{ $reservation->infrastructure->name }} {{$reservation->infrastructure->infrastructable_type}}        
            @else
                
            {{ __('Edit Reservation') }}
            @endisset
        </h2>
    </x-slot>

    {{-- Succes or error message component --}}

    @if (session('success'))
        <x-alert-message type="success" :message="session('success')" />
    @elseif (session('error'))
        <x-alert-message type="error" :message="session('error')" />
    @endif

    <div class="py-12 px-16 grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="p-4 mx-4 bg-slate-200">
            <h2 id = 'calendar_title'> 
                @isset($reservation) 
                Reservation Calendar for <b>{{ $reservation->infrastructure->name }}</b>
                @endisset
            </h2>
            
            
            @isset($reservations)
                @include('components.calendar', ['reservations' => $reservations])
            @else
                @include('components.calendar', ['reservations' => []])
            @endisset
                
        </div>
        <div class="max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('reservations.update', ['reservation' => $reservation]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="res_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Date</label>
                            <input type="date" name="res_date" min="{{ date('Y-m-d') }}" id="res_date" class="mt-1 focus
                            :ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200" value="{{ $reservation->res_date }}">
                        </div>
                        @error('res_date')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <div class="mb-4">
                            <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Start Time</label>
                            <input type="time" name="start_time" min="06:00"  step="1800" max="23:00" id="start_time" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200" value="{{ $reservation->start_time }}">
                        </div>
                        @error('start_time')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <div class="mb-4">
                            <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-200">End Time</label>
                            <input type="time" name="end_time" min="06:30" step="1800" max="23:30"  id="end_time" class="mt-1 focus
                            :ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200" value="{{ $reservation->end_time }}">
                        </div>
                        @error('end_time')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <div class="mb-4">
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>