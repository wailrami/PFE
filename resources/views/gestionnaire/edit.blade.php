<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier un Gestionnaire') }}
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('gestionnaire.update', $gestionnaire->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nom</label>
                            <input type="text" name="nom" id="nom" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ $gestionnaire->user->nom }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="prenom" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Prénom</label>
                            <input type="text" name="prenom" id="prenom" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ $gestionnaire->user->prenom }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                            <input type="email" name="email" id="email" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ $gestionnaire->user->email }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="tel" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Téléphone</label>
                            <input type="tel" name="tel" id="tel" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ $gestionnaire->user->tel }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-input rounded-md shadow-sm mt-1 block w-full">
                        </div>
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-input rounded-md shadow-sm mt-1 block w-full">
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

</x-app-layout>