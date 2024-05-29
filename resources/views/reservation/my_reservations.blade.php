<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Reservations') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <x-alert-message type="success" :message="session('success')" />
    @elseif (session('error'))
        <x-alert-message type="error" :message="session('error')" />
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('N°') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Infrastructure') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Date') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Start Time') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('End Time') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Status') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($reservations as $reservation)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">{{ $i++ }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-100"> <a href="{{route('infrastructure.details',['infrastructure'=> $reservation->infrastructure])}}" > {{ $reservation->infrastructure->name }} </a></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">{{ $reservation->res_date }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">{{ $reservation->start_time }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">{{ $reservation->end_time }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full {{ $reservation->etat == 'enattente' ? 'bg-orange-500' : ($reservation->etat == 'accepte' ? 'bg-green-600' : 'bg-red-600') }} text-white">
                                            {{ $reservation->etat == 'enattente' ? 'Pending' : ($reservation->etat == 'accepte' ? 'Accepted' : 'Rejected') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        {{-- <a href="{{ route('reservation.show', $reservation->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">View</a> --}}
                                        @if ($reservation->etat == 'accepte' || $reservation->etat == 'enattente')
                                            @if ($reservation->etat == 'enattente')
                                                <a href="{{ route('reservations.edit', $reservation) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">Edit</a> 
                                            @endif
                                            <form action="{{ route('reservations.destroy',$reservation) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">Cancel</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="mx-auto size-3/4 mb-6">
        <h1 id = 'calendar_title' class="text-2xl font-bold mb-4 dark:text-white text-black"> 
            Reservation Calendar
        </h1>
        {{-- @php 
            $acceptedReservations = $reservations->where('etat', 'accepte');
        @endphp --}}
        @include('components.calendar', ['reservations' => $reservations])
    </div>
</x-app-layout>