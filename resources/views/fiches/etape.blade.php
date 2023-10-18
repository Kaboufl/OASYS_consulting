@extends('layouts.back')
@section('content')
<div class="h-full p-4 justify-self-stretch bg-gray-400 rounded-md row-start-2 col-start-2 flex flex-col items-stretch gap-4">
    <div class="grid grid-rows-3 grid-cols-[6fr_3fr] items-center rounded-md border-2 border-neutral-700 bg-neutral-100 p-4">
        <h1 class="col-start-1 font-black text-2xl text-black">Etape : {{ $etape->libelle }}</h1>
        <h3 class="col-start-1 font-bold text-black">Projet : {{ $projet->libelle }}</h3>
        
        <a class="col-start-2 row-start-1 justify-self-end row-span-3 flex flex-row items-center text-blue-400 hover:underline transition-all" href="">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
            <span>Modifier</span>
        </a>
    </div>

    <div class="min-w-full h-fit rounded-md border-2 border-neutral-700 bg-neutral-100">

        <span class="px-5 mt-2 w-full flex flex-row justify-between items-center">
            <h5 class="font-black text-2xl text-black">Interventions :</h5>
            <button class="flex flex-row align-center gap-2 rounded-full bg-cyan-600 text-white ml-auto px-4 py-2" onclick="addStep.showModal()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                  
                <span>Ajouter une Intervention</span>
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
                    <tr class="text-neutral-800">
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                            <a class="text-blue-600 underline hover:text-blue-700 hover:cursor-not-allowed">Détails</a>
                        </td>
                    </tr>
            </tbody>
        </table>

    </div>

    </div>
</div>
@endsection