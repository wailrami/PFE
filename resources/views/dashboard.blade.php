<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
 --}}

 <div class="flex flex-wrap justify-center">
    <div class="bg-gray-300 w-64 h-64 dark:bg-gray-700 dark:text-white text-black border border-gray-300 m-4 rounded-lg shadow-md flex flex-col items-center justify-center text-center transform transition-all hover:scale-105 hover:shadow-xl">
        <h3 class="text-lg font-semibold">Reservation Stat 1</h3>
        <span class="text-4xl font-bold my-4">500</span>
        <button class="bg-white text-blue-500 hover:bg-blue-200 py-2 px-4 rounded">Show More</button>
    </div>

    <div class="bg-gray-300 w-64 h-64 dark:bg-gray-700 dark:text-white text-black border border-gray-300 m-4 rounded-lg shadow-md flex flex-col items-center justify-center text-center transform transition-all hover:scale-105 hover:shadow-xl">
        <h3 class="text-lg font-semibold">Reservation Stat 2</h3>
        <span class="text-4xl font-bold my-4">250</span>
        <button class="bg-white text-green-500 hover:bg-green-200 py-2 px-4 rounded">Show More</button>
    </div>

    <div class="bg-gray-300 w-64 h-64 dark:bg-gray-700 dark:text-white text-black border border-gray-300 m-4 rounded-lg shadow-md flex flex-col items-center justify-center text-center transform transition-all hover:scale-105 hover:shadow-xl">
        <h3 class="text-lg font-semibold">Reservation Stat 3</h3>
        <span class="text-4xl font-bold my-4">1000</span>
        <button class="bg-white text-yellow-500 hover:bg-yellow-200 py-2 px-4 rounded">Show More</button>
    </div>

    <div class="bg-gray-300 w-64 h-64 dark:bg-gray-700 dark:text-white text-black border border-gray-300 m-4 rounded-lg shadow-md flex flex-col items-center justify-center text-center transform transition-all hover:scale-105 hover:shadow-xl">
        <h3 class="text-lg font-semibold">Rapports</h3>
        <span class="text-4xl font-bold my-4">4</span>
        <button class="bg-white text-red-500 hover:bg-red-200 py-2 px-4 rounded">Show More</button>
    </div>
    <!-- Add more squares as needed -->
</div>

<script>
    const squares = document.querySelectorAll('.w-64');

    squares.forEach(square => {
        square.addEventListener('mouseenter', () => {
            square.classList.add('shadow-2xl');
            square.classList.add('scale-110');
        });

        square.addEventListener('mouseleave', () => {
            square.classList.remove('shadow-2xl');
            square.classList.remove('scale-110');
        });
    });
</script>

</x-app-layout>
