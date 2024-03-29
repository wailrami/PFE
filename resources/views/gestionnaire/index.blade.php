<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Liste des Gestionnaires') }}
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Nom</th>
                                <th class="px-4 py-2">Prénom</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Téléphone</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gestionnaires as $gestionnaire)
                                <tr>
                                    <td class="border px-4 py-2">{{ $gestionnaire->user->nom }}</td>
                                    <td class="border px-4 py-2">{{ $gestionnaire->user->prenom }}</td>
                                    <td class="border px-4 py-2">{{ $gestionnaire->user->email }}</td>
                                    <td class="border px-4 py-2">{{ $gestionnaire->user->tel }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('gestionnaires.show', $gestionnaire->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Voir</a>
                                        <a href="{{ route('gestionnaires.edit', $gestionnaire->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Modifier</a>
                                        <form action="{{ route('gestionnaires.destroy', $gestionnaire) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

</x-app-layout>