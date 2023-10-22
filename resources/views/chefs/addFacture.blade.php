@extends('layouts.back')
@section('content')

<div class="h-full p-4 justify-self-stretch bg-gray-400 rounded-md row-start-2 col-start-2 flex flex-col items-stretch gap-4">
    <form method="POST" class="flex flex-col items-start gap-2 rounded-md border-2 border-neutral-700 bg-neutral-100 p-4">
        <h1 class="col-start-1 font-black text-2xl text-black">Facturer le client : {{ $client->raison_sociale }}</h1>
        <h3 class="col-start-1 font-bold text-xl text-black">Pour l'étape : {{ $etape->libelle }}</h3>
        <h4 class="col-start-1 font-semi bold text-md text-black">Du projet : {{ $projet->libelle }} ( {{ $projet->taux_horaire }}€ /H )</h4>

        @csrf

        <div class="flex flex-row gap-8 w-full">
            <div class="flex flex-col gap-2 w-full">
                <label for="libelle" class="font-bold text-md text-black">Libellé</label>
                <input type="text" {{ $etape->facture ? 'disabled' : '' }} name="libelle" id="libelle" class="w-full rounded-md border-2 border-neutral-700 bg-neutral-100 p-2" value="{{ old('libelle') ?? $etape->libelle }}">
            </div>
            <div class="flex flex-col gap-2 w-full">
                <label for="libelle" class="font-bold text-md text-black">Date de facturation</label>
                <input type="datetime-local" {{ $etape->facture ? 'disabled' : '' }} name="date" id="date" class="w-full rounded-md border-2 border-neutral-700 bg-neutral-100 p-2" value="{{ old('date') ?? now()->format('Y-m-d H:i') }}" step="1800">
            </div>

        </div>


        <div class="relative overflow-x-auto shadow-md rounded-lg w-full mt-8">
            <table class="w-full text-sm text-left text-gray-500">
                <h4 class="text-center font-bold pt-3 text-md text-gray-700 uppercase bg-gray-200 ">Détail des Interventions</h4>
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Libellé
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Intervenant
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Durée facturée
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Coût
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if ($interventions->isEmpty())
                    <tr class="bg-white border-b  hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                Aucune intervention
                            </th>
                            <td class="px-6 py-4">
                                -
                            </td>
                            <td class="px-6 py-4">
                                -
                            </td>
                            <td class="px-6 py-4">
                                -
                            </td>
                        </tr>
                        
                    @else
                    @foreach ($interventions as $intervention)
                        <tr class="bg-white border-b hover:bg-gray-50 ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                {{ $intervention->libelle }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $intervention->intervenant->nom }} {{ $intervention->intervenant->prenom }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $intervention->duree}} h
                            </td>
                            <td class="px-6 py-4">
                                {{ $intervention->totalPresta ? $intervention->totalPresta.' €' : 'Interne' }}
                            </td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="w-full h-fit p-2 bg-white flex flex-row">
                <div class="flex flex-col">
                    <h5>Coûts externes : {{ $interventions->sum('totalPresta') }} €</h5>
                    <h4>Total facturé : {{ $projet->total }} €</h4>
                </div>

                @if (!$etape->facture)
                    <button type="submit"
                        class="text-white ml-auto bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Facturer et clôturer l'étape</a>
                    
                @endif
            </div>
        </div>

        
    </form>
</div>

@endsection