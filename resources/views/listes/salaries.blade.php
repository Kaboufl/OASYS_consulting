@extends('layouts.back')

@section('title', 'Salariés')

@section('content')
    <div class="h-full p-4 justify-self-stretch bg-gray-400 rounded-md row-start-2 col-start-2">
        <div class="w-full h-fit mb-4 flex flex-row justify-between items-center">
            <span class="ml-4 font-bold">{{ $salaries->total() }} Salariés</span>
            <button class="flex flex-row align-center gap-2 rounded-full bg-cyan-600 text-white ml-auto px-4 py-2" onclick="addSalarie.showModal()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>

                <span>Ajouter un salarié</span>
            </button>
        </div>

        {{-- @if($errors->any())
        <ul x-data="{ open: false }" x-bind:class="open ? 'hidden' : ''" class="relative border-2 text-red-600 font-semibold border-red-900 rounded-md bg-red-300 min-w-full p-4 mb-2">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            <button x-on:click="open = !open" class="absolute top-4 right-4 flex flex-row items-center">
                <span>Fermer</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </ul>
        @endif


        @if($errors->any())
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                    @foreach ($errors->all() as $index => $error)
                        window.toast('{!! $error !!}', {id: {{ $index }},type: 'danger'});
                    @endforeach
                })
            </script>
        @endif --}}

        @if($errors->any())
            <div class="w-full h-fit my-2 p-2 rounded-md bg-red-300 border-2 border-red-800 text-red-700">
                <h3>Erreur lors de l'ajout du salarié : </h3>
                <ul class="list-disc pl-4 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="min-w-full h-fit rounded-md border-2 border-neutral-700 bg-neutral-100">

            <table class="min-w-full divide-y divide-neutral-700">
                <thead>
                    <tr class="text-neutral-500">
                        <th class="px-5 py-3 text-xs font-medium text-left uppercase">Nom</th>
                        <th class="px-5 py-3 text-xs font-medium text-left uppercase">Prénom</th>
                        <th class="px-5 py-3 text-xs font-medium text-left uppercase">e-mail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200">
                    @if(empty($salaries))
                    <tr class="text-neutral-800">
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                            <a class="text-blue-600 underline hover:text-blue-700 hover:cursor-not-allowed">Détails</a>
                        </td>
                    </tr>
                    @endif
                    @foreach($salaries as $salarie)
                    <tr class="text-neutral-800">
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $salarie->nom }}</td>
                        <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $salarie->prenom }}</td>
                        <td class="px-5 py-4 text-sm whitespace-nowrap">{{ $salarie->email }}</td>
                        <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                            <a class="text-blue-600 underline hover:text-blue-700" href="{{ route('back.salaries.show', [ 'salarie' => $salarie->id ]) }}">Détails</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $salaries->links() }}

        </div>

    </>

    <dialog id="addSalarie" class="min-w-96 w-3/4 h-fit rounded relative overflow-hidden p-8 space-y-4">
        <button onclick="addSalarie.close()" class="absolute right-5 top-5 p-2 rounded-full hover:bg-gray-400 hover:text-white transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h3 class="font-bold text-2xl">Ajouter un salarié</h3>

        <form action="" method="POST" class="w-full space-y-4 grid grid-cols-2 gap-2 p-2 overflow-y-scroll">
            @csrf
            <label class="inline-block w-full col-start-1">
                <span class="block mb-2 text-sm font-medium text-gray-900 ">Nom</span>
                <input type="text" name="nom" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5    dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </label>
            <label class="inline-block w-full col-start-1">
                <span class="block mb-2 text-sm font-medium text-gray-900 ">Prénom</span>
                <input type="text" name="prenom" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5    dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </label>
            <label class="inline-block w-full row-start-1 col-start-2">
                <span class="block mb-2 text-sm font-medium text-gray-900 ">Adresse e-mail :</span>
                <input type="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5    dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </label>
            <label class="inline-block w-full col-start-2">
                <span class="block mb-2 text-sm font-medium text-gray-900 ">Mot de passe :</span>
                <input type="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5    dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </label>
            <label class="inline-block w-full col-start-2">
                <span class="block mb-2 text-sm font-medium text-gray-900 ">Confirmer le mot de passe :</span>
                <input type="password" name="confirmPassword" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5    dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </label>

            <div class="col-span-2 w-full flex flex-row justify-around">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Enregistrer</button>
                <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" onclick="addSalarie.showModal()">Fermer</button>
            </div>
        </form>
    </dialog>
@endsection
