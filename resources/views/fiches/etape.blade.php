@extends('layouts.back')
@section('content')
<div class="h-full p-4 justify-self-stretch bg-gray-400 rounded-md row-start-2 col-start-2 flex flex-col items-stretch gap-4">
    <div class="grid grid-rows-3 grid-cols-[6fr_3fr] items-center rounded-md border-2 border-neutral-700 bg-neutral-100 p-4">
        <h1 class="col-start-1 font-black text-2xl text-black">Etape : {{ $etape->libelle }}</h1>
        <h3 class="col-start-1 flex flex-row gap-2 font-bold text-black">
            <span>Projet :</span>
            <a href="{{ route('admin.projet.projet', ['projet' => $projet->id]) }}">{{ $projet->libelle }}</a>
        </h3>
        @if ($etape->facture)
                <a class="col-start-1 justify-self-start flex flex-row align-center gap-2 rounded-full bg-cyan-600 text-white px-4 py-2" href="{{ route('back.projets.etape.facture.create-facture', ['projet' => $projet->id, 'etape' => $etape->id]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      </svg>


                    <span>Voir la facture</span>
                </a>
        @elseif(!$etape->interventions->isEmpty())
                <a class="col-start-1 justify-self-start flex flex-row align-center gap-2 rounded-full bg-cyan-600 text-white px-4 py-2" href="{{ route('back.projets.etape.facture.create-facture', ['projet' => $projet->id, 'etape' => $etape->id]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>

                    <span>Facturer l'étape</span>
                </a>
        @endif

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

        @if(!$etape->facture)
            <span class="px-5 mt-2 w-full flex flex-row justify-between items-center">
                <h5 class="font-black text-2xl text-black">Interventions :</h5>
                <button class="flex flex-row align-center gap-2 rounded-full bg-cyan-600 text-white ml-auto px-4 py-2" onclick="addStep.showModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>

                    <span>Ajouter une Intervention</span>
                </button>
            </span>
        @endif

        <table class="min-w-full divide-y divide-neutral-700">
            <thead>
                <tr class="text-neutral-500">
                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Libellé</th>
                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Début</th>
                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Fin</th>
                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Commentaire</th>
                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Intervenant</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200">
                @if ($etape->interventions->isEmpty())
                    <tr class="text-neutral-800">
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                    </tr>
                @else
                    @foreach ($etape->interventions as $intervention)
                        <tr class="text-neutral-800">
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $intervention->libelle }}
                            </td>
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">
                                {{ Carbon\Carbon::parse($intervention->date_debut_intervention)->format('d/m/Y à H:i') }}
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">
                                {{ Carbon\Carbon::parse($intervention->date_fin_intervention)->format('d/m/Y à H:i') }}
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $intervention->commentaire }}
                            </td>
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">
                                <a class="text-blue-500 underline" href="{{ $intervention->intervenant->prestataire ? route('back.prestataires.show', ['prestataire' => $intervention->intervenant->id]) : route('back.salaries.show', ['salarie' => $intervention->intervenant->id]) }}">
                                    {{ $intervention->intervenant->prestataire ? $intervention->intervenant->getPrestataire->raison_sociale : $intervention->intervenant->prenom . ' ' . $intervention->intervenant->nom }}
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

<dialog id="addStep" class="min-w-96 w-3/4 h-fit rounded relative overflow-hidden p-8 space-y-4">
        <button onclick="addStep.close()"
            class="absolute right-5 top-5 p-2 rounded-full hover:bg-gray-400 hover:text-white transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h3 class="font-bold text-2xl">Ajouter une Intervention</h3>

        <form action="{{ route('back.projets.etape.store-intervention', ['projet' => $projet->id, 'etape' => $etape->id]) }}"
            method="POST" class="w-full space-y-4 grid grid-cols-2 gap-2 p-2 overflow-y-scroll">

            @csrf
            <label class="inline-block w-full col-span-2">
                <span class="block mb-2 text-sm font-medium text-gray-900 ">Libellé de l'intervention</span>
                <input type="text" name="libelle"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5    dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </label>
            <label class="inline-block w-full col-start-1">
                <span class="block mb-2 text-sm font-medium text-gray-900 ">Début de l'intervention</span>
                <input type="datetime-local" name="debut"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5    dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </label>
            <label class="inline-block w-full col-start-2">
                <span class="block mb-2 text-sm font-medium text-gray-900 ">Fin de l'intervention</span>
                <input type="datetime-local" name="fin"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5    dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </label>


            <label class="inline-block w-full">
                <span class="block mb-2 text-sm font-medium text-gray-900 ">Intervenant :</span>

                <select name="intervenant" id="intervenant" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5    dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="" default>Sélectionner un intervenant</option>
                    @foreach ($intervenants as $intervenant)
                        <option value="{{ $intervenant->id }}">
                            @if($intervenant->prestataire)
                                {{ $intervenant->getPrestataire->raison_sociale }} - Prestataire
                            @else
                                {{ $intervenant->prenom . ' ' . $intervenant->nom }} - Salarié
                            @endif
                        </option>
                    @endforeach
                </select>

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
