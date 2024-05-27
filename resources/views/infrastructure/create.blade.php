<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ajouter un Infrastructure') }}
        </h2>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('gestionnaire.infrastructure.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2">
                            <div >

                                <div>
                                    <label for="name" class="block text-xl font-medium text-gray-700 dark:text-gray-200">Nom</label>
                                    <input type="text" name="name" id="name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                                </div>
                                
                                <div>
                                    <label for="ville" class="block text-xl font-medium text-gray-700 dark:text-gray-200">City</label>
                                    <input type="text" name="ville" id="ville" autocomplete="ville" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                                </div>
                                <div>
                                    <label for="cite" class="block text-xl font-medium text-gray-700 dark:text-gray-200">Address</label>
                                    <input type="text" name="cite" id="cite" autocomplete="cite" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                                </div>
                                <div>
                                    <label for="infrastructable_type" class="block text-xl font-medium text-gray-700 dark:text-gray-200">Type</label>
                                    <select name="infrastructable_type" id="infrastructable_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">
                                        <option value="pool">Pool</option>
                                        <option value="stadium" selected>Stadium</option>
                                        <option value="hall">Hall</option>
                                    </select>
                                </div>
                            
                                <div id="category" class="mt-5">
                                    
                                    <div id="type_pool" class="grid grid-cols-3 gap-6 sm:grid-cols-2">
                                        {{-- <x-radio-image name="pool_type" id="pool_type" value="olympic" image="images/olympic_pool.jfif" alt="olympic" text="Olympic" /> --}}

                                        {{-- <x-radio-image name="pool_type" id="pool_type" value="semi_olympic" image="images/semi_olympic_pool.jfif" alt="semi_olympic" text="Semi-Olympic" /> --}}

                                        {{-- <x-radio-image name="pool_type" id="pool_type" value="private" image="images/private_pool.jfif" alt="private" text="Private" /> --}}


                                        {{-- <label for="pool_type" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Pool Type</label> --}}
                                        {{-- <input type="radio" name="pool_type" id="pool_type" value="olympic" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200"> --}}
                                        {{-- Olympic <img src="{{ asset('images/olympic.jpg') }}" alt="olympic" class="w-20 h-20"> --}}
                                        {{-- </input> --}}
                                        {{-- <input type="radio" name="pool_type" id="pool_type" value="semi_olympic" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200"> --}}
                                        {{-- Semi-Olympic <img src="{{ asset('images/public.jpg') }}" alt="public" class="w-20 h-20"> --}}
                                        {{-- </input> --}}
                                        {{-- <input type="radio" name="pool_type" id="pool_type" value="private" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200"> --}}
                                            {{-- Private<img src="{{ asset('images/private.jpg') }}" alt="private" class="w-20 h-20"> --}}
                                        {{-- </input> --}}
                                    </div>
                                    <div id="type_stadium" class="grid grid-cols-1 gap-6 sm:grid-cols-2 transition ease-linear duration-1000">
                                        <x-radio-image name="stadium_type" id="eleven" value="Eleven a side" image="images/eleven-a-side_stadium.jfif" alt="Eleven-a-Side" text="Eleven-a-Side"/>
                                        <x-radio-image name="stadium_type" id="seven" value="Seven a side" image="images/seven-a-side_stadium.jfif" alt="Seven-a-Side" text="Seven-a-Side"/>
                                        <x-radio-image name="stadium_type" id="five" value="Five a side" image="images/five-a-side_stadium.jpg" alt="Five-a-Side" text="Five-a-Side"/>
                                        {{-- <label for="stadium_type" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Stadium Type</label> --}}
                                        {{-- <input type="radio" name="stadium_type" id="stadium_type" value="football" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200"> --}}
                                            {{-- <img src="{{ asset('images/football.jpg') }}" alt="football" class="w-20 h-20"> --}}
                                        {{-- </input> --}}
                                        {{-- <input type="radio" name="stadium_type" id="stadium_type" value="basketball" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200"> --}}
                                        {{-- <img src="{{ asset('images/basketball.jpg') }}" alt="basketball" class="w-20 h-20"> --}}
                                        {{-- </input> --}}
                                        {{-- <input type="radio" name="stadium_type" id="stadium_type" value="volleyball" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200"> --}}
                                            {{-- <img src="{{ asset('images/volleyball.jpg') }}" alt="volleyball" class="w-20 h-20"> --}}
                                        {{-- </input> --}}
                                    </div>
                                    <div id="type_hall" class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                                        {{-- <x-radio-image name="hall_type" id="conference" value="conference" image="images/conference_hall.jfif" alt="Conference" text="Conference"/> --}}
                                        {{-- <x-radio-image name="hall_type" id="concert" value="concert" image="images/concert_hall.jfif" alt="Concert" text="Concert"/> --}}
                                        {{-- <x-radio-image name="hall_type" id="sport" value="sport" image="images/sport_hall.jfif" alt="Sport" text="Sport"/> --}}

                                        
                                        {{-- <label for="hall_type" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Hall Type</label> --}}
                                        {{-- <input type="radio" name="hall_type" id="hall_type" value="conference" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200"> --}}
                                        {{-- <img src="{{ asset('images/conference.jpg') }}" alt="conference" class="w-20 h-20"> --}}
                                        {{-- </input> --}}
                                        {{-- <input type="radio" name="hall_type" id="hall_type" value="concert" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200"> --}}
                                            {{-- <img src="{{ asset('images/concert.jpg') }}" alt="concert" class="w-20 h-20"> --}}
                                        {{-- </input> --}}
                                        {{-- <input type="radio" name="hall_type" id="hall_type" value="sport" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200"> --}}
                                        {{-- <img src="{{ asset('images/sport.jpg') }}" alt="sport" class="w-20 h-20"> --}}
                                        {{-- </input> --}}
                                    </div>
                                </div>
                                
                            </div>

                            <div>

                                <div class="mb-4">
                                    <label for="main_image" class="block text-xl font-medium text-gray-700 dark:text-gray-200">Main Image</label>
                                    <input type="file" name="main_image" id="main_image" accept="image/*" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block 
                                    shadow-sm sm:text-sm 
                                    border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-violet-50 file:text-violet-700
                                    hover:file:bg-violet-100">
                                </div>
                                <div class="my-10">
                                    <label for="drop-area" class="block text-xl font-medium text-gray-700 dark:text-gray-200">Additional Images</label>
                                    <div class="dropzone-previews dropzone" id="myDropzone">
                                        <div class="fallback">
                                            <input type="file" name="images[]" id="fileInput" multiple accept="image/*" class="block">
                                        </div>
                                    </div>
                                </div> 
                                <div>
                                    <label for="description" class="block text-xl font-medium text-gray-700 dark:text-gray-200">Description</label>
                                    <textarea name="description" id="description" placeholder="Write any other details.." autocomplete="description" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block h-40 w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200"></textarea>
                                </div>
                            </div>
                        </div>
                            @if ($errors->any())
                            <div class="mt-4">
                                <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-300">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-400 dark:hover:bg-indigo-500 dark:text-gray-900">
                                Ajouter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectElement = document.getElementById('infrastructable_type');
            const pool = document.getElementById('type_pool');
            const stadium = document.getElementById('type_stadium');
            const hall = document.getElementById('type_hall');
            const category = document.getElementById('category');

            let selectedType = selectElement.value;

            if (selectedType == 'pool') {
                
                pool.classList.remove('hidden'); pool.classList.add('block');
                stadium.classList.add('hidden'); stadium.classList.remove('block');
                hall.classList.add('hidden'); hall.classList.remove('block');
            } else if (selectedType == 'stadium') {
                
                pool.classList.add('hidden'); pool.classList.remove('block');
                stadium.classList.remove('hidden'); stadium.classList.add('block');
                hall.classList.add('hidden'); hall.classList.remove('block');

            } else if (selectedType == 'hall') {
                pool.classList.add('hidden'); pool.classList.remove('block');
                stadium.classList.add('hidden'); stadium.classList.remove('block');
                hall.classList.remove('hidden'); hall.classList.add('block');
            }

            selectElement.addEventListener('change', function() {
                let selectedType = selectElement.value;

                if (selectedType == 'pool') {
                    
                    pool.classList.remove('hidden'); pool.classList.add('block');
                    stadium.classList.add('hidden'); stadium.classList.remove('block');
                    hall.classList.add('hidden'); hall.classList.remove('block');
                } else if (selectedType == 'stadium') {
                
                    pool.classList.add('hidden'); pool.classList.remove('block');
                    stadium.classList.remove('hidden'); stadium.classList.add('block');
                    hall.classList.add('hidden'); hall.classList.remove('block');

                } else if (selectedType == 'hall') {
                
                    pool.classList.add('hidden'); pool.classList.remove('block');
                    stadium.classList.add('hidden'); stadium.classList.remove('block');
                    hall.classList.remove('hidden'); hall.classList.add('block');
                }
            });
        });

    </script>

@vite("resources\css\dropzone.css")
@vite("resources\js\dropzone.js")

</x-app-layout>