@extends('layouts.back')
@section('content')
<div class="h-full p-4 justify-self-stretch bg-gray-400 rounded-md row-start-2 col-start-2 flex flex-col items-stretch gap-4">
    <div class="grid grid-rows-3 grid-cols-[6fr_3fr] items-center rounded-md border-2 border-neutral-700 bg-neutral-100 p-4">
        <h1 class="col-start-1 font-black text-2xl text-black">Client : {{ $client->raison_sociale }}</h1>
        <h3 class="col-start-1 flex flex-row gap-2 font-bold text-black">SIRET : {{ $client->siret }}</h3>

        <a class="col-start-2 row-start-1 justify-self-end row-span-3 flex flex-row items-center text-blue-400 hover:underline transition-all" href="">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
            <span>Modifier</span>
        </a>
    </div>

    @if($errors->any())
        <div class="w-full h-fit p-2 rounded-md bg-red-300 border-2 border-red-800 text-red-700">
            <h3>Erreur lors de l'ajout de l'intervention : </h3>
            <ul class="list-disc pl-4 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="min-w-full h-fit rounded-md border-2 border-neutral-700 bg-neutral-100">

        <span class="px-5 mt-2 w-full flex flex-row justify-between items-center">
            <h5 class="font-black text-2xl text-black">Projets :</h5>

        </span>


        <table class="min-w-full divide-y divide-neutral-700">
            <thead>
                <tr class="text-neutral-500">
                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Libellé</th>
                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Statut</th>
                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Taux horaire</th>
                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Domaine</th>
                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200">
                @if ($client->projets->isEmpty())
                    <tr class="text-neutral-800">
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                    </tr>
                @else
                    @foreach ($client->projets as $projet)
                        <tr class="text-neutral-800">
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $projet->libelle }}
                            </td>
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $projet->statut }}</td>
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $projet->taux_horaire }}</td>
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $projet->domaine->libelle }}</td>
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">
                                <a class="text-blue-500 underline" href="{{ route('back.projets.show', ['projet' => $projet->id]) }}">
                                    Détail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

    </div>
    </div>
</div>
@endsection
