@extends('layouts.back')
@section('content')

<div class="h-full p-4 justify-self-stretch bg-gray-400 rounded-md row-start-2 col-start-2 flex flex-col items-stretch gap-4">
    <div class="grid grid-rows-3 grid-cols-[6fr_3fr] items-center rounded-md border-2 border-neutral-700 bg-neutral-100 p-4">
        <h1 class="col-start-1 font-black text-2xl text-black">Projet : {{ $projet->libelle }} - {{ $domaine->libelle }}</h1>
        <h3 class="col-start-1 font-bold text-black">Client : {{ $client->raison_sociale }}</h3>
        <span class="col-start-1">Chef de projet : {{ $chefProjet->prenom.' '.$chefProjet->nom }}</span>
        
        <a class="col-start-2 row-start-1 justify-self-end row-span-3 flex flex-row items-center text-blue-400 hover:underline transition-all" href="">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
            <span>Modifier</span>
        </a>
    </div>

    <div class="min-w-full h-fit rounded-md border-2 border-neutral-700 bg-neutral-100">

        <span class="px-5 mt-2 w-full flex flex-row justify-between items-center">
            @php($projet->statut ? $statut = $projet->statut : $statut = 'Indéfini')
            <h4 class="font-bold text-2xl text-cyan-600">Statut : <span class="font-medium">{{ $statut }}</span></h4>
            <h5 class="ml-5 font-black text-2xl text-black">Étapes :</h5>
            <button class="flex flex-row align-center gap-2 rounded-full bg-cyan-600 text-white ml-auto px-4 py-2" onclick="addStep.showModal()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                  
                <span>Ajouter une étape</span>
            </button>
        </span>

            
        <table class="min-w-full divide-y divide-neutral-700">
            <thead>
                <tr class="text-neutral-500">
                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Libellé</th>
                    <th class="px-5 py-3 text-xs font-medium text-right uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200">
                @if(!$etapes->count() > 0)
                    <tr class="text-neutral-800">
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                            <a class="text-blue-600 underline hover:text-blue-700 hover:cursor-not-allowed">Détails</a>
                        </td>
                    </tr>
                @else
                    @foreach($etapes as $etape)
                        <tr class="text-neutral-800">
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $etape->libelle }}</td>
                            <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <a href="{{ route('admin.projet.etape.etape', ['projet' => $projet->id, 'etape' => $etape->id]) }}" class="text-blue-600 underline hover:text-blue-700">Détails</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

    </div>

    </div>
</div>

<dialog id="addStep" class="min-w-96 w-3/4 h-fit rounded relative overflow-hidden p-8 space-y-4">
    <button onclick="addStep.close()" class="absolute right-5 top-5 p-2 rounded-full hover:bg-gray-400 hover:text-white transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>                  
    </button>

    <h3 class="font-bold text-2xl">Ajouter une étape</h3>

    <form action="{{ route('admin.projet.etape.add', ['projet' => $projet->id]) }}" method="POST" class="w-full space-y-4 grid grid-cols-2 gap-2 p-2 overflow-y-scroll">
        @csrf
        <label class="inline-block w-full col-span-2">
            <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Libellé de l'étape</span>
            <input type="text" name="libelle" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </label>
        
        <div class="col-span-2 w-full flex flex-row justify-around">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Enregistrer</button>
            <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Supprimer</button>
        </div>
    </form>
</dialog>

@endsection