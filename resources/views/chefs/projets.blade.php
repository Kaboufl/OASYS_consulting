@extends('layouts.back')
@section('content')
    <div class="h-full p-4 justify-self-stretch bg-gray-400 rounded-md row-start-2 col-start-2">
        
        <div class="h-full p-4 justify-self-stretch bg-gray-400 rounded-md row-start-2 col-start-2">
            
    
            <div class="min-w-full h-fit rounded-md border-2 border-neutral-700 bg-neutral-100">
                
                <table class="min-w-full divide-y divide-neutral-700">
                    <thead>
                        <tr class="text-neutral-500">
                            <th class="px-5 py-3 text-xs font-medium text-left uppercase">Libellé</th>
                            <th class="px-5 py-3 text-xs font-medium text-left uppercase">Domaine</th>
                            <th class="px-5 py-3 text-xs font-medium text-left uppercase">Statut</th>
                            <th class="px-5 py-3 text-xs font-medium text-right uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200">
                        @if(empty($projets))
                        <tr class="text-neutral-800">
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                            <td class="px-5 py-4 text-sm whitespace-nowrap">Aucune donnée</td>
                            <td class="px-5 py-4 text-sm whitespace-nowrap">Aucune donnée</td>
                            <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <a class="text-blue-600 underline hover:text-blue-700 hover:cursor-not-allowed">Détails</a>
                            </td>
                        </tr>
                        @endif
                        @foreach($projets as $projet)
                        <tr class="text-neutral-800">
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $projet->libelle }}</td>
                            <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $projet->domaine->libelle }}</td>
                            <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $projet->statut }}</td>
                            <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <a class="text-blue-600 underline hover:text-blue-700" href="{{ route('chef.projet.projet', ['projet' => $projet->id]) }}">Détails</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
    
                {{-- $projets->links() --}}
            
            </div>
    
        </div>

    </div>
@stop