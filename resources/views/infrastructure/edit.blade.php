<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Infrastructure') }}
        </h2>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('gestionnaire.infrastructure.update', $infrastructure) }}" method="POST" id="my-form" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2">
                            <div >

                                <div>
                                    <label for="name" class="block text-xl font-medium text-gray-700 dark:text-gray-200">Name</label>
                                    <input type="text" name="name" id="name" autocomplete="given-name" value="{{$infrastructure->name}}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                                </div>
                                
                                <div>
                                    <label for="ville" class="block text-xl font-medium text-gray-700 dark:text-gray-200">City</label>
                                    <input type="text" name="ville" id="ville" autocomplete="ville" value="{{$infrastructure->ville}}" readonly class="mt-1 read-only:text-gray-500 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                                </div>
                                <div>
                                    <label for="cite" class="block text-xl font-medium text-gray-700 dark:text-gray-200">Address</label>
                                    <input type="text" name="cite" id="cite" autocomplete="cite" value="{{$infrastructure->cite}}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                                </div>
                                <div>
                                    <label for="infrastructable_type" class="block text-xl font-medium text-gray-700 dark:text-gray-200">Type</label>
                                    <select name="infrastructable_type" id="infrastructable_type" disabled value="{{$infrastructure->infrastructable_type}}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:text-gray-200">
                                        <option value="pool" {{ $infrastructure->infrastructable_type == 'Pool' ? 'selected' : '' }}>Pool</option>
                                        <option value="stadium" {{ $infrastructure->infrastructable_type == 'Stadium' ? 'selected' : '' }}>Stadium</option>
                                        <option value="hall" {{ $infrastructure->infrastructable_type == 'Hall' ? 'selected' : '' }}>Hall</option>
                                    </select>
                                </div>
                            
                                <div id="category" class="mt-5">
                                    @if($infrastructure->infrastructable_type == 'Pool')
                                        <label class="block text-md font-medium text-gray-700 dark:text-gray-200">Pool Type</label><br>
                                        <div id="type_pool" class="grid grid-cols-1 gap-8">
                                            <div>
                                                <input type="radio"  name="pool_type" id="olympic" value="olympic" {{ ($infrastructure->getPool($infrastructure->infrastructable_id)->pool_type == 'olympic') ? 'checked' : '' }}
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                                                </input>
                                                <label for="olympic" class="ms-4"> Olympic </label>

                                            </div>
                                            <div>
                                                <input type="radio" {{ ($infrastructure->getPool($infrastructure->infrastructable_id)->pool_type == 'semi_olympic') ? 'checked' : '' }} name="pool_type" id="semi_olympic" value="semi_olympic" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500  shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                                                </input>
                                                <label for="semi_olympic" class="ms-4"> Semi-Olympic </label>
                                                
                                            </div>
                                            <div>
                                                <input type="radio"  {{ ($infrastructure->getPool($infrastructure->infrastructable_id)->pool_type == 'private') ? 'checked' : '' }} name="pool_type" id="private" value="private" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500  shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                                                </input>
                                                <label for="private" class="ms-4"> Private </label>
                                                
                                            </div>
                                        </div>
                                    @endif
                                    @if($infrastructure->infrastructable_type == 'Stadium')
                                    <label class="block text-md font-medium text-gray-700 dark:text-gray-200">Stadium Type</label><br>
                                    <div id="type_stadium" class="grid grid-cols-1 gap-6 transition ease-linear duration-1000">
                                            {{-- <x-radio-image name="stadium_type" id="eleven" value="Eleven a side" image="images/eleven-a-side_stadium.jfif" alt="Eleven-a-Side" text="Eleven-a-Side"/> --}}
                                            {{-- <x-radio-image name="stadium_type" id="seven" value="Seven a side" image="images/seven-a-side_stadium.jfif" alt="Seven-a-Side" text="Seven-a-Side"/> --}}
                                            {{-- <x-radio-image name="stadium_type" id="five" value="Five a side" image="images/five-a-side_stadium.jpg" alt="Five-a-Side" text="Five-a-Side"/> --}}
                                            <div>
                                                <input type="radio"  name="stadium_type" id="eleven" value="Eleven a side" {{ ($infrastructure->getStadium($infrastructure->infrastructable_id)->stadium_type == 'Eleven a side') ? 'checked' : '' }}
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                                                </input>
                                                <label for="eleven" class="ms-4"> Eleven-a-Side </label>

                                            </div>
                                            <div>
                                                <input type="radio" {{ ($infrastructure->getStadium($infrastructure->infrastructable_id)->stadium_type == 'Seven a side') ? 'checked' : '' }} name="stadium_type" id="seven" value="Seven a side" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500  shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                                                </input>
                                                <label for="seven" class="ms-4"> Seven-a-Side</label>
                                                
                                            </div>
                                            <div>
                                                <input type="radio"  {{ ($infrastructure->getStadium($infrastructure->infrastructable_id)->stadium_type == 'Five a side') ? 'checked' : '' }} name="stadium_type" id="five" value="Five a side" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500  shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                                                </input>
                                                <label for="five" class="ms-4"> Five-a-Side </label>
                                                
                                            </div>
                                        </div>
                                    @endif
                                    @if($infrastructure->infrastructable_type == 'Hall')
                                        <label class="block text-md font-medium text-gray-700 dark:text-gray-200">Hall Type</label><br>
                                        <div id="type_hall" class="grid grid-cols-1 gap-6">

                                            {{-- <x-radio-image name="hall_type" id="conference" value="conference" image="images/conference_hall.jfif" alt="Conference" text="Conference"/> --}}
                                            {{-- <x-radio-image name="hall_type" id="concert" value="concert" image="images/concert_hall.jfif" alt="Concert" text="Concert"/> --}}
                                            {{-- <x-radio-image name="hall_type" id="sport" value="sport" image="images/sport_hall.jfif" alt="Sport" text="Sport"/> --}}

                                            <div>
                                                <input type="radio"  name="hall_type" id="box" value="Box" {{ ($infrastructure->getHall($infrastructure->infrastructable_id)->hall_type == 'Box') ? 'checked' : '' }}
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                                                </input>
                                                <label for="box" class="ms-4"> Boxing hall </label>

                                            </div>
                                            <div>
                                                <input type="radio" {{ ($infrastructure->getHall($infrastructure->infrastructable_id)->hall_type == 'Martial arts') ? 'checked' : '' }} name="hall_type" id="arts" value="Martial arts" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500  shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                                                </input>
                                                <label for="arts" class="ms-4"> Martial arts hall (Judo, Karate..)</label>
                                                
                                            </div>
                                            <div>
                                                <input type="radio"  {{ ($infrastructure->getHall($infrastructure->infrastructable_id)->hall_type == 'Multi-sports') ? 'checked' : '' }} name="hall_type" id="multi" value="Multi-sports" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500  shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">
                                                </input>
                                                <label for="multi" class="ms-4"> Multi-sports hall (Handball, Basketball..)</label>
                                            </div>
                                        
                                        </div>
                                    @endif
                                </div>
                                
                            </div>

                            <div>

                                <div class="mb-4">
                                    <label for="main_image" class="block text-xl font-medium text-gray-700 dark:text-gray-200">Main Image</label>
                                    <div class="mb-4">
                                        <img src="{{ asset('storage/' . $infrastructure->main_image) }}" alt="Current Image" style="max-width: 200px;">
                                    </div>
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
                                    <textarea name="description" id="description" 
                                    placeholder="Write any other details.." 
                                    autocomplete="description" 
                                    class="mt-1 focus:ring-indigo-500 
                                    focus:border-indigo-500 block h-40 w-full shadow-sm sm:text-sm 
                                    border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-200">{{$infrastructure->description}}</textarea>
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
                                Update
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

            //setting the disable attribute in 'selectElement' element to false when submitting
            document.getElementById('my-form').addEventListener('submit', function() {
                selectElement.disabled = false;
            });

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