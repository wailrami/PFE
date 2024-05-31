
@props(['notification'])
<div class="my-4">
    <!-- A notification that has a title and content, with notifiaction type , 
        and also the card bg change if the notification is read or not -->

    <div class=" {{($notification->is_read == false ? 'bg-white dark:bg-gray-800 ': 'bg-gray-200 dark:bg-gray-700 ')}}   overflow-hidden shadow-lg border rounded-full sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100 hover:bg-inherit">
            <div class="flex justify-between items-center">
                <div>
                    <div class="flex items-end">
                        <div class="flex-shrink-0">
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z" />
                            </svg> --}}
                            {{-- A ring notification icon --}}
                            <svg class="h-6 w-6 text-blue-500 animate-wiggle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 21">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                                d="M15.585 15.5H5.415A1.65 1.65 0 0 1 4 13a10.526 10.526 0 0 0 1.5-5.415V6.5a4 4 0 0 1 4-4h2a4 4 0 0 1 4 4v1.085c0 1.907.518 3.78 1.5 5.415a1.65 1.65 0 0 1-1.415 2.5zm1.915-11c-.267-.934-.6-1.6-1-2s-1.066-.733-2-1m-10.912 3c.209-.934.512-1.6.912-2s1.096-.733 2.088-1M13 17c-.667 1-1.5 1.5-2.5 1.5S8.667 18 8 17"/>
                            </svg>
                            
                        </div>
                        
                    </div>
                    <div class="">
                        <div class="text-lg font-medium text-blue-500 dark:text-blue-400"> {{ $notification->title }}</div>
                        <div class="text-md text-gray-500 dark:text-gray-300"> {{ $notification->content }}</div>
                    </div>
                </div>
                {{-- show more button and mark as read button, place to the end of the container --}}
                <div class="ml-4">
                    <form action="{{ route('notifications.show', ['id'=>$notification->id]) }}" method="POST" class="inline">
                        @csrf
                            @method('PATCH')
                            <button type="submit"
                        class="text-blue-500 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-500 mx-4">Show
                        more
                            </button>
                    </form>
                    @if ($notification->is_read == false)
                        <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST"
                            class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="text-blue-500 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-500 mx-2">Mark
                                as read</button>
                        </form>
                    @else 
                        <form action="{{ route('notifications.markAsUnread', $notification) }}" method="POST"
                            class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="text-blue-500 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-500 mx-2">Mark
                                as unread</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>