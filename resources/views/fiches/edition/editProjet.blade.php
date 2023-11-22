@extends('layouts.back')
@section('content')
<div class="h-full p-4 justify-self-stretch bg-gray-400 rounded-md row-start-2 col-start-2 flex flex-col items-stretch gap-4">
    <div class="rounded-md border-2 border-neutral-700 bg-neutral-100 p-4">
        <form action="" method="post" class="container rounded-md grid grid-cols-2 gap-4">
            @csrf
            <h1 class="font-black text-2xl text-black">Modifier les détails du projet</h1>

            <label class="inline-block w-full col-span-2">
                <span class="block mb-2 text-sm font-medium text-gray-900 ">Libellé du projet</span>
                <input type="text" name="libelle" value="{{ $projet->libelle }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5    dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </label>

            <label class="inline-block w-full">
                <span class="block mb-2 text-sm font-medium text-gray-900 ">Domaine du projet :</span>
                
                <select id="domaine" name="domaine" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                    @foreach($domaines as $domaine)
                        <option value="{{ $domaine->id }}" {{ $projet->domaine->id == $domaine->id ? 'selected' : '' }} >{{ $domaine->libelle }}</option>
                    @endforeach
                </select>    
            </label>

            <label class="inline-block w-full">
                <span class="block mb-2 text-sm font-medium text-gray-900 ">Chef de projet :</span>
                
                <select id="chef" name="chefProj" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                    @foreach($chefsDispo as $chefProjet)
                        <option value="{{ $chefProjet->id }}" {{ $projet->chefProj->id == $chefProjet->id ? 'selected' : '' }} >{{ $chefProjet->prenom.' '.$chefProjet->nom }}</option>
                    @endforeach
                </select>
            </label>

            <label class="inline-block w-full">
                <span class="block mb-2 text-sm font-medium text-gray-900 ">Client :</span>
                
                <select id="client" name="client" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ $projet->client->id == $client->id ? 'selected' : '' }}>{{ $client->raison_sociale }}</option>
                    @endforeach
                </select>
            </label>

            <label class="inline-block w-full">
                <span class="block mb-2 text-sm font-medium text-gray-900 ">Taux horaire :</span>
                <input type="number" step="0.01" name="taux_horaire" value="{{ $projet->taux_horaire }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5    dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </label>

            <label class="inline-block w-full col-span-2">
                <span class="block mb-2 text-sm font-medium text-gray-900 ">Statut du projet :</span>
                
                <select id="statut" name="statut" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                    @foreach($statuts as $key => $statut)
                        <option value="{{ $key }}" {{ $projet->statut == $statut ? 'selected' : '' }}>{{ $statut }}</option>
                    @endforeach
                </select>
            </label>

            <div class="col-span-2 w-full flex flex-row justify-start">
                <button type="submit" class="ml-12 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Enregistrer</button>
            </div>

        </form>

    </div>
</div>

@endsection