<nav class="row-start-1 row-span-2 col-start-1 my-4 py-4 px-8 bg-gray-800 rounded-r-md">
    <span class="flex items-center justify-center pt-10 md:pt-0 flex-shrink-0 w-48 h-48 text-gray-900 rounded-full">
        <img class="w-auto -translate-y-px" src="{{ asset('assets/images/logo/svg/logo-white.svg') }}" alt="">
    </span>

    <ul class="w-full h-fit flex flex-col gap-1">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="@if(Route::currentRouteName() == 'admin.dashboard') bg-gray-400 font-bold text-gray-800 @else text-white @endif flex flex-row justify-start gap-4 items-center p-2 px-4 rounded-full hover:bg-gray-600 text-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 ml-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                  
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.clients') }}" class="@if(Route::currentRouteName() == 'admin.clients') bg-gray-400 font-bold text-gray-800 @else text-white @endif flex flex-row justify-start gap-4 items-center p-2 px-4 rounded-full hover:bg-gray-600 text-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 ml-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                  
                  
                <span>Clients</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.projets') }}" class="@if(Route::currentRouteName() == 'admin.projets' || Route::currentRouteName() == 'admin.projet') bg-gray-400 font-bold text-gray-800 @else text-white @endif flex flex-row justify-start gap-4 items-center p-2 px-4 rounded-full hover:bg-gray-600 text-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 ml-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                </svg>
                  
                  
                <span>Projets</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.dashboard') }}" class="text-white flex flex-row justify-start gap-4 items-center p-2 px-4 rounded-full hover:bg-gray-600 text-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 ml-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                </svg>
                  
                  
                  
                <span>Salariés</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.dashboard') }}" class="text-white flex flex-row justify-start gap-4 items-center p-2 px-4 rounded-full hover:bg-gray-600 text-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 ml-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                </svg>
                
                <span>Prestataires</span>
            </a>
        </li>
        
    </ul>
</nav>