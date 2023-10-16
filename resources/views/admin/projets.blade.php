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
            <span class="ml-4 font-bold">{{ $projets->total() }} projets</span>
            <button class="flex flex-row align-center gap-2 rounded-full bg-cyan-600 text-white ml-auto px-4 py-2" onclick="addProjet.showModal()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                  
                <span>Ajouter un projet</span>
            </button>
        </div>

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
                            <a class="text-blue-600 underline hover:text-blue-700" href="{{ '/admin/projet/'.$projet->id }}">Détails</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $projets->links() }}
        
        </div>

        @dump($errors->all())

    </div>
    
    <dialog id="addProjet" class="min-w-96 w-3/4 h-fit rounded relative overflow-hidden p-8 space-y-4">
        <button onclick="addProjet.close()" class="absolute right-5 top-5 p-2 rounded-full hover:bg-gray-400 hover:text-white transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>                  
        </button>

        <h3 class="font-bold text-2xl">Ajouter un nouveau projet</h3>

        <form action="" method="POST" class="w-full space-y-4 grid grid-cols-2 gap-2 p-2 overflow-y-scroll">
            @csrf
            <label class="inline-block w-full col-span-2">
                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Libellé du projet</span>
                <input type="text" name="libelle" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </label>
            <label class="inline-block w-full">
                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Domaine du projet :</span>
                    <div x-data="{
                        selectOpen: false,
                        selectedItem: '',
                        selectableItems: [
                            @foreach($domaines as $domaine)
                            {
                                title: '{{ $domaine->libelle }}',
                                value: '{{ $domaine->id }}',
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
                
                    <button type="button"  x-ref="selectButton" @click="selectOpen=!selectOpen"
                        :class="{ 'focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400' : !selectOpen }"
                        class="relative min-h-[38px] flex items-center justify-between w-full py-2 pl-3 pr-10 text-left bg-white border rounded-md shadow-sm cursor-default border-neutral-200/70 focus:outline-none  text-sm">
                        <span x-text="selectedItem ? selectedItem.title : 'Sélectionner un domaine'" class="truncate">Sélectionner un domaine</span>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="w-5 h-5 text-gray-400"><path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd"></path></svg>
                        </span>
                    </button>

                    <input type="hidden" name="domaine" x-model="selectedItem.value" id="domaine">
                
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
            <label class="inline-block w-full">
                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Chef de projet :</span>
                <div x-data="{
                    selectOpen: false,
                    selectedItem: '',
                    selectableItems: [
                        @foreach($chefsDispo as $chefProjet)
                        {
                            title: '{{ $chefProjet->prenom.' '.$chefProjet->nom }}',
                            value: '{{ $chefProjet->id }}',
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
                    <span x-text="selectedItem ? selectedItem.title : 'Sélectionner chef de projet'" class="truncate">Sélectionner chef de projet</span>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="w-5 h-5 text-gray-400"><path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd"></path></svg>
                    </span>
                </button>

                <input type="hidden" name="chefProj" x-model="selectedItem.value" id="chefProj">
            
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

            <label class="inline-block w-full">
                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Client :</span>
                <div x-data="{
                    selectOpen: false,
                    selectedItem: '',
                    selectableItems: [
                        @foreach($clients as $client)
                        {
                            title: '{{ addslashes($client->raison_sociale) }}',
                            value: '{{ $client->id }}',
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

            <label class="inline-block w-full">
                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Taux horaire :</span>
                <input type="number" step="0.01" name="taux_horaire" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </label>

            <label class="inline-block w-full col-span-2">
                <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Statut du projet :</span>
                <div x-data="{
                    selectOpen: false,
                    selectedItem: '',
                    selectableItems: [
                        @foreach($statuts as $key => $statut)
                        {
                            title: '{{ $statut }}',
                            value: '{{ $key }}',
                            disabled: false
                        },
                        @endforeach
                    ],
                    selectableItemActive: null,
                    selectId: $id('select'),
                    selectKeydownValue: '',
                    selectKeydownTimeout: 1000,
                    selectKeydownClearTimeout: null,
                    selectDropdownPosition: 'top',
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
                    <span x-text="selectedItem ? selectedItem.title : 'Statut du projet'" class="truncate">Statut du projet</span>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="w-5 h-5 text-gray-400"><path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd"></path></svg>
                    </span>
                </button>

                <input type="hidden" name="statut" x-model="selectedItem.value" id="statut">
            
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