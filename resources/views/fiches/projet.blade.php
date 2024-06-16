@extends('layouts.back')
@section('content')

    <div
        class="h-full p-4 justify-self-stretch bg-gray-400 rounded-md row-start-2 col-start-2 flex flex-col items-stretch gap-4">
        <div
            class="grid @if (isset($chefProjet)) grid-rows-3 @else grid-rows-2 @endif grid-cols-1 items-center rounded-md border-2 border-neutral-700 bg-neutral-100 p-4">
            <h1 class="col-start-1 font-black text-2xl text-black">Projet : {{ $projet->libelle }} - {{ $projet->domaine->libelle }}
            </h1>
            @if(Auth::user()->admin()->count())
            <h3 class="col-start-1 font-bold text-black flex flex-row gap-2">
                <span>Client :</span>
                <a class="text-blue-600 underline hover:text-blue-700" href="{{ route('back.clients.show', ['client' => $projet->client->id]) }}">{{ $projet->client->raison_sociale }}</a>
            </h3>
            @else
            <h3 class="col-start-1 font-bold text-black">Client : {{ $projet->client->raison_sociale }}</h3>
            @endif
            @php($projet->statut ? ($statut = $projet->statut) : ($statut = 'Indéfini'))
            <form method="POST" class="col-start-1 flex flex-row items-center gap-6" x-data="{ editStatut: false }">
                @csrf
                <span>Statut :</span>
                <div x-show="!editStatut" x-transition class="flex flex-row items-center gap-2">
                    <span class="font-medium">{{ $statut }}</span> <button class="p-2 rounded bg-blue-700 font-bold text-white text-sm" x-on:click="editStatut = !editStatut" type="button">Modifier</button>
                </div>
                <div class="flex flex-row items-stretch gap-2" x-show="editStatut" x-transition>
                    <select name="statut" id="editStatut" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5    dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($projet->getStatuts() as $key => $statut)
                            <option value="{{ $key + 1 }}" @if ($projet->statut == $statut)
                                selected

                            @endif >{{ $statut }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="p-2 rounded bg-blue-700 font-bold text-white text-sm">Enregistrer</button>
                </div>
            </form>

        </div>

        <div class="min-w-full h-fit rounded-md border-2 border-neutral-700 bg-neutral-100">

            <span class="px-5 mt-2 w-full flex flex-row justify-between items-center">
                <h5 class="font-black text-2xl text-black">Étapes :</h5>
                <button class="flex flex-row align-center gap-2 rounded-full bg-cyan-600 text-white ml-auto px-4 py-2"
                    onclick="addStep.showModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
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
                    @if (!$projet->etapes->count() > 0)
                        <tr class="text-neutral-800">
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                            <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <a class="text-blue-600 underline hover:text-blue-700 hover:cursor-not-allowed">Détails</a>
                            </td>
                        </tr>
                    @else
                        @foreach ($projet->etapes as $etape)
                            <tr class="text-neutral-800">
                                <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $etape->libelle }}</td>
                                <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    @if ($etape->facture)
                                    <a href="{{ route('back.projets.etape.show', ['projet' => $projet->id, 'etape' => $etape->id]) }}"
                                        class="text-blue-600 underline hover:text-blue-700">Facture</a>
                                    @else
                                    <a href="{{ route('back.projets.etape.show', ['projet' => $projet->id, 'etape' => $etape->id]) }}"
                                        class="text-blue-600 underline hover:text-blue-700">Détails</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

        </div>

        <div class="min-w-full h-fit rounded-md border-2 border-neutral-700 bg-neutral-100 grid grid-rows-[repeat(2, auto)] grid-cols-2">

<?php
    $total = $salaries->count() + $prestataires->count();
    if ($total > 0) {
        $prestatairesPercent = ($prestataires->count() / $total) * 100;
        $salariesPercent = ($salaries->count() / $total) * 100;

        $prestatairesPercent = round($prestatairesPercent, 2);
        $salariesPercent = round($salariesPercent, 2);
    } else {
        $prestatairesPercent = 0;
        $salariesPercent = 0;
    }
?>

            <div class="row-start-1 mx-5 mt-3 col-span-2 flex flex-row items-center gap-4">
                <h2 class="w-fit font-black text-2xl text-black">Intervenants</h2>

                <div class="flex flex-row justify-around gap-2 mx-auto">
                    <span class="text-cyan-600">
                        Salariés : <span class="font-medium">{{ $salariesPercent }}%</span>
                    </span>
                    <span class="h-6 w-32 border-2 border-neutral-700 rounded-full overflow-hidden flex flex-row">
                        <span class="h-full bg-cyan-600" style="width: {{ $salariesPercent }}%"></span>
                        <span class="h-full bg-green-600" style="width: {{ $prestatairesPercent }}%"></span>
                    </span>
                    <span class="text-green-600">
                        Prestataires : <span class="font-medium">{{ $prestatairesPercent }}%</span>
                    </span>
                </div>


            </div>


            <div class="row-start-2 h-fit border-2 border-neutral-400 rounded-xl m-4">
                <h3 class="mx-auto p-2 font-bold text-lg w-fit">Salariés</h3>
                <table class="min-w-full divide-y divide-neutral-700">
                    <thead>
                        <tr class="text-neutral-500">
                            <th class="px-5 py-3 text-xs font-medium text-left uppercase">Libellé</th>
                            <th class="px-5 py-3 text-xs font-medium text-right uppercase">Commentaire</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200">
                        @if (!$salaries->count() > 0)
                            <tr class="text-neutral-800">
                                <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                                <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <a class="text-blue-600 underline hover:text-blue-700 hover:cursor-not-allowed">Détails</a>
                                </td>
                            </tr>
                        @else
                            @foreach ($salaries as $salarie)
                                <tr class="text-neutral-800">
                                    <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $salarie->nom.' '.$salarie->prenom }}</td>
                                    <td class="px-5 py-4 text-sm font-medium whitespace-nowrap text-right">{{ $salarie->intervention->commentaire ?? '' }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="row-start-2 h-fit border-2 border-neutral-400 m-4 rounded-xl">
                <h3 class="mx-auto p-2 font-bold text-lg w-fit">Prestataires externes</h3>
                <table class="min-w-full divide-y divide-neutral-700">
                    <thead>
                        <tr class="text-neutral-500">
                            <th class="px-5 py-3 text-xs font-medium text-left uppercase">Raison Sociale</th>
                            <th class="px-5 py-3 text-xs font-medium text-left uppercase">Prix à l'heure</th>
                            <th class="px-5 py-3 text-xs font-medium text-right uppercase">Commentaire</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200">
                        @if (!$prestataires->count() > 0)
                            <tr class="text-neutral-800">
                                <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                                <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                                <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>

                            </tr>
                        @else
                            @foreach ($prestataires as $prestataire)
                                <tr class="text-neutral-800">
                                    <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $prestataire->getPrestataire->raison_sociale }}</td>
                                    <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{-- $prestataire->getPrestataire->raison_sociale --}} 73.5€</td>
                                    <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">{{ $prestataire->intervention->commentaire ?? '' }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <dialog id="addStep" class="min-w-96 w-3/4 h-fit rounded relative overflow-hidden p-8 space-y-4">
        <button onclick="addStep.close()"
            class="absolute right-5 top-5 p-2 rounded-full hover:bg-gray-400 hover:text-white transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h3 class="font-bold text-2xl">Ajouter une étape</h3>

        <form action="{{ route('back.projets.etape.store', ['projet' => $projet->id]) }}" method="POST"
            class="w-full space-y-4 grid grid-cols-2 gap-2 p-2 overflow-y-scroll">
            @csrf
            <label class="inline-block w-full col-span-2">
                <span class="block mb-2 text-sm font-medium text-gray-900 ">Libellé de l'étape</span>
                <input type="text" name="libelle"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5    dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </label>

            <div class="col-span-2 w-full flex flex-row justify-around">
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Enregistrer</button>
                <button type="button"
                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Supprimer</button>
            </div>
        </form>
    </dialog>

@endsection
