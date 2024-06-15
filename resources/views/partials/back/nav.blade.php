<nav class="row-start-1 row-span-2 col-start-1 my-4 py-4 px-8 bg-gray-800 rounded-r-md">
    <span class="flex items-center justify-center pt-10 md:pt-0 flex-shrink-0 w-48 h-48 text-gray-900 rounded-full">
        <img class="w-auto -translate-y-px" src="{{ asset('assets/images/logo/svg/logo-white.svg') }}" alt="">
    </span>

    <ul class="w-full h-fit flex flex-col gap-1">
    @if(auth()->user()->admin()->count())

        <li>
            <a href="{{ route('admin.dashboard') }}" class="@if(str_contains(Route::currentRouteName(), 'dashboard')) bg-gray-400 font-bold text-gray-800 @else text-white @endif flex flex-row justify-start gap-4 items-center p-2 px-4 rounded-full hover:bg-gray-600 text-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 ml-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>

                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('back.clients.showAll') }}" class="@if(str_contains(Route::currentRouteName(), 'clients')) bg-gray-400 font-bold text-gray-800 @else text-white @endif flex flex-row justify-start gap-4 items-center p-2 px-4 rounded-full hover:bg-gray-600 text-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 ml-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>


                <span>Clients</span>
            </a>
        </li>
        <li>
            <a href="{{ route('back.projets.showAll') }}" class="@if(str_contains(Route::currentRouteName(), 'projet')) bg-gray-400 font-bold text-gray-800 @else text-white @endif flex flex-row justify-start gap-4 items-center p-2 px-4 rounded-full hover:bg-gray-600 text-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 ml-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                </svg>


                <span>Projets</span>
            </a>
        </li>
        <li>
            <a href="{{ route('back.salaries.showAll') }}" class="@if(str_contains(Route::currentRouteName(), 'salarie')) bg-gray-400 font-bold text-gray-800 @else text-white @endif flex flex-row justify-start gap-4 items-center p-2 px-4 rounded-full hover:bg-gray-600 text-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 ml-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                </svg>



                <span>Salariés</span>
            </a>
        </li>
        <li>
            <a href="{{ route('back.prestataires.showAll') }}" class="@if(str_contains(Route::currentRouteName(), 'prestataires')) bg-gray-400 font-bold text-gray-800 @else text-white @endif flex flex-row justify-start gap-4 items-center p-2 px-4 rounded-full hover:bg-gray-600 text-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 ml-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                </svg>

                <span>Prestataires</span>
            </a>
        </li>
    @elseif(auth()->user()->chefDe()->count())
        <li>
            <a href="{{ route('back.projets.showAll') }}" class="@if(str_contains(Route::currentRouteName(), 'projets')) bg-gray-400 font-bold text-gray-800 @else text-white @endif flex flex-row justify-start gap-4 items-center p-2 px-4 rounded-full hover:bg-gray-600 text-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 ml-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                </svg>


                <span>Projets</span>
            </a>
        </li>
    @else
        <li>
            <a href="{{ route('back.intervenant.showAll') }}" class="@if(str_contains(Route::currentRouteName(), 'intervenant.showAll')) bg-gray-400 font-bold text-gray-800 @else text-white @endif flex flex-row justify-start gap-4 items-center p-2 px-4 rounded-full hover:bg-gray-600 text-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 ml-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                </svg>



                <span>Interventions</span>
            </a>
        </li>
    @endif
    </ul>
</nav>
