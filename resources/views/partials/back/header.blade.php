<header class="col-start-2 row-start-1 p-4 h-fit">
    <div class="w-full h-fit p-2 bg-slate-700 rounded-md flex flex-row justify-between items-center">
        <div class="ml-4">
            <h1 class="m-0 text-white text-xl font-bold capitalize">@yield('title')</h1>
        </div>

        <div x-data="{
            dropdownOpen: false
        }" class="relative">
            <button @click="dropdownOpen=true"
                class="inline-flex items-center justify-center h-12 py-2 px-3 text-sm font-medium transition-colors rounded-md text-white hover:bg-slate-500 active:bg-slate-400 focus:bg-slate-400 focus:outline-none disabled:opacity-50 disabled:pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </button>
            <div x-show="dropdownOpen" @click.away="dropdownOpen=false" x-transition:enter="ease-out duration-200"
                x-transition:enter-start="-translate-y-2" x-transition:enter-end="translate-y-0"
                class="absolute top-0 right-0 z-50 w-56 mt-14 -translate-x-1/2 -left-full" x-cloak>
                <div class="p-1 mt-1 bg-white border rounded-md shadow-md border-neutral-200/70 text-neutral-700">
                    <div class="px-2 py-1.5 text-sm font-semibold">Mon compte</div>
                    <div class="h-px my-1 -mx-1 bg-neutral-200"></div>
                    <a href="#_"
                        class="relative flex cursor-default select-none hover:bg-neutral-100 items-center rounded px-2 py-1.5 text-sm outline-none transition-colors data-[disabled]:pointer-events-none data-[disabled]:opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="w-4 h-4 mr-2">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span>Profil</span>
                    </a>

                    <div class="h-px my-1 -mx-1 bg-neutral-200"></div>
                    <a href="{{ route('logout') }}"
                        class="relative flex cursor-default select-none hover:bg-neutral-100 items-center rounded px-2 py-1.5 text-sm outline-none transition-colors focus:bg-accent focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="w-4 h-4 mr-2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" x2="9" y1="12" y2="12"></line>
                        </svg>
                        <span>Se déconnecter</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
