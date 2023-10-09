@extends('layouts.back')
@section('content')

    @if($errors->any())
    <script>
        document.body.onload = function() {
        @foreach($errors->all() as $error)
            window.dispatchEvent(new CustomEvent('toast-show', { 
                detail : { 
                    type: 'danger',
                    message: '{{ $error }}',
                    description: '',
                    position : 'top-center',
                    html: '' 
                }}));
        @endforeach
        };
    </script>
    @endif


    <div class="h-full p-4 justify-self-stretch bg-gray-400 rounded-md row-start-2 col-start-2">
        <div class="w-full h-fit mb-4 flex flex-row justify-between items-center">
            <span class="ml-4 font-bold">{{ count($clients) }} clients</span>
            <button class="flex flex-row align-center gap-2 rounded-full bg-cyan-600 text-white ml-auto px-4 py-2" onclick="addClient.showModal()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                  
                <span>Ajouter un client</span>
            </button>
        </div>

        <div class="min-w-full max-h-[85%] rounded-md border-2 border-neutral-700 bg-neutral-100">
            
            <table class="min-w-full divide-y divide-neutral-700">
                <thead>
                    <tr class="text-neutral-500">
                        <th class="px-5 py-3 text-xs font-medium text-left uppercase">Raison sociale</th>
                        <th class="px-5 py-3 text-xs font-medium text-left uppercase">N° de SIRET</th>
                        <th class="px-5 py-3 text-xs font-medium text-left uppercase">Ville</th>
                        <th class="px-5 py-3 text-xs font-medium text-right uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200">
                    @if(true)
                    <tr class="text-neutral-800">
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                            <a class="text-blue-600 hover:text-blue-700 hover:cursor-not-allowed">Modifier</a>
                        </td>
                    </tr>
                    @endif
                    @foreach($clients as $client)
                    <tr class="text-neutral-800">
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $client->raison_sociale }}</td>
                        <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $client->siret }}</td>
                        <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $client->ville }}</td>
                        <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                            <a class="text-blue-600 hover:text-blue-700" href="#">Modifier</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        
    </div>
        
    </div>
    
    <dialog id="addClient" class="w-96 h-fit rounded relative overflow-hidden p-8 space-y-4">
        <button onclick="addClient.close()" class="absolute right-5 top-5 p-2 rounded-full hover:bg-gray-400 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>                  
        </button>

        <h3 class="font-bold text-2xl">Ajouter un nouveau client</h3>

        <form action="" method="POST" class="w-full space-y-4">
            @method('PUT')
            @csrf
            <label class="inline-block w-full">
                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Raison Sociale</span>
                <input type="text" name="raison_sociale" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </label>
            <label class="inline-block w-full">
                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">N° de SIRET</span>
                <input type="number" name="SIRET" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </label>
            <label class="inline-block w-full">
                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ville</span>
                <input type="text" name="ville" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </label>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Enregistrer</button>
        </form>
    </dialog>
@stop