<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @isset($infrastructure)
            {{ __('Make a Reservation') }} for {{ $infrastructure->name }} {{$infrastructure->infrastructable_type}}        
            @else
                
            {{ __('Make a Reservation') }}
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
        <div class="max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('reservations.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="res_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Date</label>
                            <input type="date" name="res_date" min="{{ date('Y-m-d') }}" id="res_date" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                        </div>
                        @error('res_date')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <div class="mb-4">
                            <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Start Time</label>
                            <input type="time" name="start_time" min="06:00"  step="1800" max="23:00" id="start_time" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200" >
                        </div>
                        @error('start_time')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <div class="mb-4">
                            <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-200">End Time</label>
                            <input type="time" name="end_time" min="06:30" step="1800" max="23:30" id="end_time" class="mt-1 focus:ring-indigo-50023 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200" >
                        </div>
                        @error('end_time')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        {{-- add a switch button to enable the periodic reservation option or not --}}
                        <div class="mb-4">
                            <label for="periodicReservation" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Periodic Reservation</label>
                            <input type="checkbox" name="periodicReservation" id="periodicReservation" class="form-checkbox h-5 w-5 text-indigo-600 dark:bg-gray-700">
                        </div>
                        <div class="mb-4">
                            <label for="end_date" class="hidden text-sm font-medium text-gray-700 dark:text-gray-200">End Date</label>
                            <input type="date" name="end_date" min="{{ date('Y-m-d',strtotime(date('Y-m-d') . ' +1 day')) }}" id="end_date" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 hidden w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                        </div>
                        @error('end_date')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <div class="mb-4">
                            <label for="period" class="hidden text-sm font-medium text-gray-700 dark:text-gray-200">Period</label>
                            <select name="period" id="period" class="mt-1 hidden w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">
                                <option value="daily">Every Day</option>
                                <option value="weekly">Every Week</option>
                                <option value="monthly">Every Month</option>
                            </select>
                        </div>
                        @error('period')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                        <div class="mb-4">
                            <input type="hidden" name="infrastructure_id" value="{{ $id }}">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Reserve</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- script, if the periodic reservation checked, the end time and period elements shown, else is not --}}
    <script>
        const periodicReservation = document.getElementById('periodicReservation');
        const end_date = document.getElementById('end_date');
        const period = document.getElementById('period');
        const end_date_label = document.querySelector('label[for="end_date"]');
        const period_label = document.querySelector('label[for="period"]');
        periodicReservation.addEventListener('change', function() {
            if (periodicReservation.checked) {
                end_date.style.display = 'block';
                period.style.display = 'block';
                end_date_label.style.display = 'block';
                period_label.style.display = 'block';
            } else {
                end_date.style.display = 'none';
                period.style.display = 'none';
                end_date_label.style.display = 'none';
                period_label.style.display = 'none';
            }
        });
    </script>
</x-app-layout>