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
                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Début</th>
                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Fin</th>
                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Commentaire</th>
                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Intervenant</th>
                    <th class="px-5 py-3 text-xs font-medium text-right uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200">
                @if (empty($interventions))
                    <tr class="text-neutral-800">
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">Aucune donnée</td>
                        <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                            <a class="text-blue-600 underline hover:text-blue-700 hover:cursor-not-allowed">Détails</a>
                        </td>
                    </tr>
                    @else
                    @foreach ($interventions as $intervention)
                        <tr class="text-neutral-800">
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $intervention->libelle }}</td>
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $intervention->date_debut_intervention }}</td>
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $intervention->date_fin_intervention }}</td>
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">{{ $intervention->commentaire }}</td>
                            <td class="px-5 py-4 text-sm font-medium whitespace-nowrap">
                                {{ $intervention->intervenant->prestataire ? $intervention->intervenant->getPrestataire->raison_sociale : $intervention->intervenant->prenom.' '.$intervention->intervenant->nom }}
                            </td>
                            <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <a class="text-blue-600 underline hover:text-blue-700 hover:cursor-not-allowed">Détails</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

    </div>

    @dump($interventions, $intervenantsDispo, '')

    @foreach($intervenantsDispo as $intervenant)
        @dump($intervenant->getPrestataire()->get())
    @endforeach
    </div>
</div>

<dialog id="addStep" class="min-w-96 w-3/4 h-fit rounded relative overflow-hidden p-8 space-y-4">
    <button onclick="addStep.close()" class="absolute right-5 top-5 p-2 rounded-full hover:bg-gray-400 hover:text-white transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>                  
    </button>

    <h3 class="font-bold text-2xl">Ajouter une Intervention</h3>

    <form action="{{ route('admin.projet.etape.intervention.add', ['projet' => $projet->id, 'etape' => $etape->id]) }}" method="POST" class="w-full space-y-4 grid grid-cols-2 gap-2 p-2 overflow-y-scroll">
        @csrf
        <label class="inline-block w-full col-span-2">
            <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Libellé de l'intervention</span>
            <input type="text" name="libelle" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </label>
        <label class="inline-block w-full col-span-2">
            <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date de l'intervention</span>
            <input type="date" name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </label>
        <label class="inline-block w-full col-start-1">
            <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Début de l'intervention</span>
            <input type="time" name="debut" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </label>
        <label class="inline-block w-full col-start-2">
            <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fin de l'intervention</span>
            <input type="time" name="fin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </label>
        

        <label class="inline-block w-full">
            <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Intervenant :</span>
            <div x-data="{
                selectOpen: false,
                selectedItem: '',
                selectableItems: [
                    @foreach($intervenantsDispo as $intervenant)
                    {
                        title: '{{ $intervenant->prestataire ? $intervenant->getPrestataire->raison_sociale : $intervenant->nom.' '.$intervenant->prenom }}',
                        value: '{{ $intervenant->id }}',
                        disabled: false
                    },
                    @endforeach
                ],
                selectableItemActive: null,
                selectId: $id('select'),
                selectKeydownValue: '',
                selectKeydownTimeout: 1000,
                selectKeydownClearTimeout: null,
                selectDropdownPosition: 'bottom',
                selectableItemIsActive(item) {
                    return this.selectableItemActive && this.selectableItemActive.value==item.value;
                },
                selectableItemActiveNext(){
                    let index = this.selectableItems.indexOf(this.selectableItemActive);
                    if(index < this.selectableItems.length-1){
                        this.selectableItemActive = this.selectableItems[index+1];
                        this.selectScrollToActiveItem();
                    }
                },
                selectableItemActivePrevious(){
                    let index = this.selectableItems.indexOf(this.selectableItemActive);
                    if(index > 0){
                        this.selectableItemActive = this.selectableItems[index-1];
                        this.selectScrollToActiveItem();
                    }
                },
                selectScrollToActiveItem(){
                    if(this.selectableItemActive){
                        activeElement = document.getElementById(this.selectableItemActive.value + '-' + this.selectId)
                        newScrollPos = (activeElement.offsetTop + activeElement.offsetHeight) - this.$refs.selectableItemsList.offsetHeight;
                        if(newScrollPos > 0){
                            this.$refs.selectableItemsList.scrollTop=newScrollPos;
                        } else {
                            this.$refs.selectableItemsList.scrollTop=0;
                        }
                    }
                },
                selectKeydown(event){
                    if (event.keyCode >= 65 && event.keyCode <= 90) {
                        
                        this.selectKeydownValue += event.key;
                        selectedItemBestMatch = this.selectItemsFindBestMatch();
                        if(selectedItemBestMatch){
                            if(this.selectOpen){
                                this.selectableItemActive = selectedItemBestMatch;
                                this.selectScrollToActiveItem();
                            } else {
                                this.selectedItem = this.selectableItemActive = selectedItemBestMatch;
                            }
                        }
                        
                        if(this.selectKeydownValue != ''){
                            clearTimeout(this.selectKeydownClearTimeout);
                            this.selectKeydownClearTimeout = setTimeout(() => {
                                this.selectKeydownValue = '';
                            }, this.selectKeydownTimeout);
                        }
                    }
                },
                selectItemsFindBestMatch(){
                    typedValue = this.selectKeydownValue.toLowerCase();
                    var bestMatch = null;
                    var bestMatchIndex = -1;
                    for (var i = 0; i < this.selectableItems.length; i++) {
                        var title = this.selectableItems[i].title.toLowerCase();
                        var index = title.indexOf(typedValue);
                        if (index > -1 && (bestMatchIndex == -1 || index < bestMatchIndex) && !this.selectableItems[i].disabled) {
                            bestMatch = this.selectableItems[i];
                            bestMatchIndex = index;
                        }
                    }
                    return bestMatch;
                },
                selectPositionUpdate(){
                    selectDropdownBottomPos = this.$refs.selectButton.getBoundingClientRect().top + this.$refs.selectButton.offsetHeight + parseInt(window.getComputedStyle(this.$refs.selectableItemsList).maxHeight);
                    if(window.innerHeight < selectDropdownBottomPos){
                        this.selectDropdownPosition = 'top';
                    } else {
                        this.selectDropdownPosition = 'bottom';
                    }
                }
            }"
            x-init="
                $watch('selectOpen', function(){
                    if(!selectedItem){ 
                        selectableItemActive=selectableItems[0];
                    } else {
                        selectableItemActive=selectedItem;
                    }
                    setTimeout(function(){
                        selectScrollToActiveItem();
                    }, 10);
                    selectPositionUpdate();
                    window.addEventListener('resize', (event) => { selectPositionUpdate(); });
                });
            "
            @keydown.escape="if(selectOpen){ selectOpen=false; }"
            @keydown.down="if(selectOpen){ selectableItemActiveNext(); } else { selectOpen=true; } event.preventDefault();"
            @keydown.up="if(selectOpen){ selectableItemActivePrevious(); } else { selectOpen=true; } event.preventDefault();"
            @keydown.enter="selectedItem=selectableItemActive; selectOpen=false;"
            @keydown="selectKeydown($event);"
            class="w-full relative">
        
            <button type="button" x-ref="selectButton" @click="selectOpen=!selectOpen"
                :class="{ 'focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400' : !selectOpen }"
                class="relative min-h-[38px] flex items-center justify-between w-full py-2 pl-3 pr-10 text-left bg-white border rounded-md shadow-sm cursor-default border-neutral-200/70 focus:outline-none  text-sm">
                <span x-text="selectedItem ? selectedItem.title : 'Sélectionner un client'" class="truncate">Sélectionner un client</span>
                <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="w-5 h-5 text-gray-400"><path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd"></path></svg>
                </span>
            </button>

            <input type="hidden" name="client" x-model="selectedItem.value" id="client">
        
            <ul x-show="selectOpen"
                x-ref="selectableItemsList"
                @click.away="selectOpen = false"
                x-transition:enter="transition ease-out duration-50"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100"
                :class="{ 'bottom-0 mb-10' : selectDropdownPosition == 'top', 'top-0 mt-10' : selectDropdownPosition == 'bottom' }"
                class="z-10 absolute w-full py-1 mt-1 overflow-auto text-sm bg-white rounded-md shadow-md max-h-56 ring-1 ring-black ring-opacity-5 focus:outline-none"
                x-cloak>
        
                <template x-for="item in selectableItems" :key="item.value">
                    <li 
                        @click="selectedItem=item; selectOpen=false; $refs.selectButton.focus();"
                        :id="item.value + '-' + selectId"
                        :data-disabled="item.disabled"
                        :class="{ 'bg-neutral-100 text-gray-900' : selectableItemIsActive(item), '' : !selectableItemIsActive(item) }"
                        @mousemove="selectableItemActive=item"
                        class="relative flex items-center h-full py-2 pl-8 text-gray-700 cursor-default select-none data-[disabled]:opacity-50 data-[disabled]:pointer-events-none">
                        <svg x-show="selectedItem.value==item.value" class="absolute left-0 w-4 h-4 ml-2 stroke-current text-neutral-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span class="block font-medium truncate" x-text="item.title"></span>
                    </li>
                </template>
        
            </ul>
        
        </div>
        </label>
        
        <div class="col-span-2 w-full flex flex-row justify-around">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Enregistrer</button>
            <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Supprimer</button>
        </div>
    </form>
</dialog>
@endsection