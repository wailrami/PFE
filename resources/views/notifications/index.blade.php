<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notifications') }} 
            <span class="rounded-full size-6 inline-block text-center  font-semibold bg-red-500 text-white"> {{app\Models\Notification::unreadCount()}} </span>
        </h2>
    </x-slot>


    {{-- A list of Notification Cards for the user , if it is empty display a message in a div--}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($notifications->isEmpty())
                        <div class="text-center text-gray-900 dark:text-gray-100">
                            <p>No notifications yet.</p>
                        </div>
                    @endif
                    <div class="mx-auto">
                        @foreach ($notifications as $notification)
                            <x-notification-card :notification="$notification" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>