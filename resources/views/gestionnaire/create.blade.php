<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add a Manager') }}
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.gestionnaires.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Family Name</label>
                            <input type="text" name="nom" id="nom" class="form-input rounded-md text-black shadow-sm mt-1 block w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="prenom" class="block text-sm font-medium text-gray-700 dark:text-gray-200">First Name</label>
                            <input type="text" name="prenom" id="prenom" class="form-input rounded-md text-black shadow-sm mt-1 block w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                            <input type="email" name="email" id="email" class="form-input rounded-md text-black shadow-sm mt-1 block w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="tel" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Phone Number</label>
                            <input type="tel" name="tel" id="tel" class="form-input rounded-md text-black shadow-sm mt-1 block w-full" required>
                        </div>
                        
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>